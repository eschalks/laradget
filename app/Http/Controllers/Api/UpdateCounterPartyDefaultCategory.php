<?php

namespace App\Http\Controllers\Api;

use App\Data\Api\UpdateCounterPartyDefaultCategoryDto;
use App\Data\Forms\UpdateCounterPartyForm;
use App\Data\Models\CounterPartyDto;
use App\Data\Models\TransactionDto;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CounterParty;
use App\Models\Transaction;

class UpdateCounterPartyDefaultCategory extends Controller
{
    public function __invoke(CounterParty $counterParty, UpdateCounterPartyForm $form)
    {
        return \DB::transaction(function () use ($counterParty, $form) {
            $category = Category::find($form->categoryId);
            $updatedTransactions = $counterParty->updateDefaultCategory($category);

            return TransactionDto::collect($updatedTransactions);
        });
    }
}
