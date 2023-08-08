<?php

namespace App\Http\Controllers\Api;

use App\Data\Api\UpdateTransactionDto;
use App\Data\Forms\UpdateTransactionForm;
use App\Data\Models\TransactionDto;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateTransaction extends Controller
{
    public function __invoke(Transaction $transaction, UpdateTransactionForm $updateTransactionForm): Responsable
    {
        $transaction->update([
                                 'category_id' => $updateTransactionForm->categoryId,
                             ]);

        $transaction->loadMissing('counterParty');

        return TransactionDto::from($transaction);
    }
}
