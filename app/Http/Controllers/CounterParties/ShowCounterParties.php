<?php

namespace App\Http\Controllers\CounterParties;

use App\Data\Models\CategoryGroupDto;
use App\Data\Models\CounterPartyDetailsDto;
use App\Http\Controllers\Controller;
use App\Models\CounterParty;
use Inertia\Inertia;

class ShowCounterParties extends Controller
{
    public function __invoke()
    {
        CategoryGroupDto::shareWithInertia();

        return Inertia::render('CounterPartiesPage', [
            'counterParties' => CounterPartyDetailsDto::collection(CounterParty::orderBy('name')
                                                                               ->get()),
        ]);
    }
}
