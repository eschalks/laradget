<?php

namespace App\Http\Controllers\CounterParties;

use App\Data\Models\CategoryGroupDto;
use App\Data\Models\CounterPartyDetailsDto;
use App\Http\Controllers\Controller;
use App\Models\CounterParty;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

class ShowCounterParties extends Controller
{
    public function __invoke()
    {
        CategoryGroupDto::shareWithInertia();

        $counterParties = CounterParty::whereNull('default_category_id')
                                      ->orderBy('name')
                                      ->get();

        $uncategorizedTransactionCounts = Transaction::select([
                                                                  'counter_party_id',
                                                                  \DB::raw('count(*) as count'),
                                                              ])
                                                     ->whereNull('category_id')
                                                     ->groupBy('counter_party_id')
                                                     ->get()
                                                     ->pluck('count', 'counter_party_id');

        return Inertia::render('CounterPartiesPage', [
            'counterParties'                 => CounterPartyDetailsDto::collection($counterParties),
            'uncategorizedTransactionCounts' => $uncategorizedTransactionCounts,
        ]);
    }
}
