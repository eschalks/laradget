<?php

namespace App\TrueLayer;

use App\Exceptions\AccountProviderExpired;
use App\Models\AccountProvider;
use Assert\Assertion;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Exceptions\CannotCreateData;

class TrueLayerClient
{
    private ?AccountProvider $accountProvider;

    public function __construct()
    {

    }

    /**
     * @return \Spatie\LaravelData\DataCollection<int, \App\TrueLayer\AccountTL>|\App\TrueLayer\AccountTL[]
     */
    public function fetchAccounts(): DataCollection
    {
        return $this->get(AccountTL::class, 'accounts');
    }

    /**
     * @return \Spatie\LaravelData\DataCollection<int, \App\TrueLayer\AccountTL>|\App\TrueLayer\AccountTL[]
     */
    public function fetchBalance(string $accountId): BalanceTL
    {
        return $this->get(BalanceTL::class, "accounts/$accountId/balance")
            ->first();
    }

    /**
     * @return \Spatie\LaravelData\DataCollection<int, \App\TrueLayer\TransactionTL>|\App\TrueLayer\AccountTL[]
     */
    public function fetchTransactions(
        string             $accountId,
        \DateTimeInterface $from,
        \DateTimeInterface $to
    ): DataCollection {
        return $this->get(TransactionTL::class, "accounts/$accountId/transactions", [
            'from' => $from->format(DATE_RFC3339_EXTENDED),
            'to'   => $to->format(DATE_RFC3339_EXTENDED),
        ]);
    }

    /**
     * @template T from Spatie\LaravelData\Data
     *
     * @param string          $path
     * @param class-string<T> $dataClass
     *
     * @return DataCollection<int, T>
     */
    private function get(string $dataClass, string $path, ?array $query = null): DataCollection
    {
        Assertion::subclassOf($dataClass, Data::class);

        $response = \Http::withToken($this->fetchValidToken())
            ->get("https://api.truelayer.com/data/v1/$path", $query);
        $json     = $response->json();

        return new DataCollection($dataClass, $json['results']);
    }

    private function fetchValidToken(): string
    {
        if (! $this->getAccountProvider()->is_active) {
            throw new AccountProviderExpired();
        }

        return \DB::transaction(function () {

            // Can't be sure how much time there is between now and the actual usage, so we'll take a 10-second margin
            if ($this->getAccountProvider()->expires_at <= now()->subSeconds(10)) {
                $this->refreshAccessToken();
            }

            return $this->getAccountProvider()->access_token;
        });
    }

    private function refreshAccessToken(): void
    {
        $responseStart = now();
        $response      = \Http::asForm()
            ->post('https://auth.truelayer.com/connect/token', [
                ...$this->getConfiguration(['client_id', 'client_secret']),
                'refresh_token' => $this->accountProvider->refresh_token,
                'grant_type'    => 'refresh_token',
            ]);

        $responseBody = $response->body();

        try {
            $tokenResponse = TokenResponse::from($responseBody);
        } catch (CannotCreateData $cannotCreateData) {
            try {
                $errorResponse = ErrorResponse::from($responseBody);
                if ($errorResponse->error === TrueLayerError::InvalidGrant) {
                    $this->getAccountProvider()
                         ->update(['is_active' => false]);
                    \DB::commit();
                    throw new AccountProviderExpired();
                }
                throw $cannotCreateData;
            } catch (CannotCreateData) {
                // Unexpected error type in the ErrorResponse, just move on to the exception below
            }

            throw new \Exception('Refresh response failed with error: '.$responseBody, previous: $cannotCreateData);
        }

        Assertion::true($this->accountProvider->update([
                                                           'refresh_token' => $tokenResponse->refresh_token,
                                                           'access_token'  => $tokenResponse->access_token,
                                                           'expires_at'    => $responseStart->addSeconds($tokenResponse->expires_in),
                                                       ]));
    }

    private function getAccountProvider(): AccountProvider
    {
        $this->accountProvider ??= AccountProvider::first();

        return $this->accountProvider;
    }

    public function getProviderId(): int
    {
        return $this->getAccountProvider()
                    ->getKey();
    }

    private function getConfiguration(array $keys = []): array
    {
        return $keys ? \Arr::only(config('services.truelayer'), $keys) : config('services.truelayer');
    }

    public function getAuthenticationUrl(): string
    {
        $configuration = $this->getConfiguration();

        $parameters = array_merge($configuration['parameters'], [
            'client_id'     => $configuration['client_id'],
            'redirect_uri'  => $this->getRedirectUri(),
            'response_type' => 'code',
        ]);

        return 'https://auth.truelayer.com/?'.http_build_query($parameters);
    }

    public function authenticate(): void
    {
        $response = \Http::asForm()
                         ->post('https://auth.truelayer.com/connect/token', [
                             'client_id'     => $this->clientId,
                             'client_secret' => $this->clientSecret,
                             'redirect_uri'  => $this->getRedirectUri(),
                             'grant_type'    => 'authorization_code',
                             'code'          => request('code'),
                         ]);

        $connectResponse = ConnectResponse::from($response->json());

        // TODO: support for multiple account providers
        $this->getAccountProvider()
             ->update([
                          'access_token'  => $connectResponse->access_token,
                          'refresh_token' => $connectResponse->refresh_token,
                          'expires_at'    => now()->addSeconds($connectResponse->expires_in),
                          'is_active'     => true,
                      ]);
    }

    private function getRedirectUri(): string
    {
        return route('oauth.callback');
    }
}
