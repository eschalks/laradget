<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Endroid\QrCode\Builder\Builder as QrBuilder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CreatePersonalAccessToken extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $this->validate($request, ['name' => 'required']);

        /** @var \Laravel\Sanctum\NewAccessToken $newToken */
        $newToken = $request->user()->createToken($data['name']);

        $plainToken = $newToken->plainTextToken;

        $mobileUrl  = $this->createMobileUrl($plainToken);

        $qr = QrBuilder::create()
                       ->data($mobileUrl)
                       ->encoding(new Encoding('UTF-8'))
                       ->writer(new PngWriter())
                       ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                       ->size(300)
                       ->margin(10)
                       ->build();

        $encodedQr = 'data:'.$qr->getMimeType().';charset=utf-8;base64,'.base64_encode($qr->getString());

        return Inertia::render('NewAccessTokenPage', [
            'token' => $plainToken,
            'qr'    => $encodedQr,
            'url'   => $mobileUrl,
        ]);
    }

    private function createMobileUrl(string $token): string
    {
        $urlData = [
            'url'   => config('app.url'),
            'token' => $token,
        ];

        $urlJson = json_encode($urlData, flags: JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);

        return 'laradget://'.base64_encode($urlJson);
    }
}
