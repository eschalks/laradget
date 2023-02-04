<?php

namespace App\Http\Controllers\CounterParties;

use App\Data\Forms\UpdateCounterPartyForm;
use App\Http\Controllers\Controller;
use App\Models\CounterParty;
use App\Models\Transaction;

class UpdateCounterParty extends Controller
{
    public function __invoke(CounterParty $counterParty, UpdateCounterPartyForm $form)
    {
        \DB::transaction(function () use ($counterParty, $form) {
            Transaction::where('counter_party_id', $counterParty->getKey())
                       ->where('category_id', $counterParty->default_category_id)
                       ->update([
                                    'category_id' => $form->defaultCategoryId,
                                ]);

            $counterParty->update($form->all());
        });
    }
}
