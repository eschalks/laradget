<?php

namespace App\Http\Controllers\Api;

use App\Data\Api\UpdateTransactionDto;
use App\Data\Models\TransactionDto;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateTransaction extends Controller
{
    public function __invoke(Transaction $transaction, UpdateTransactionDto $updateTransactionDto): Responsable
    {
        \DB::transaction(static function () use ($transaction, $updateTransactionDto) {
            $transaction->update([
                                     'category_id' => $updateTransactionDto->categoryId,
                                 ]);

            if ($updateTransactionDto->updateCounterParty) {
                $transaction->counterParty->update([
                                                       'default_category_id' => $updateTransactionDto->categoryId,
                                                   ]);
            }
        });

        $transaction->loadMissing('counterParty');

        return TransactionDto::from($transaction);
    }
}
