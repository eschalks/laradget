<?php

namespace App\Http\Controllers\Budget;

use App\Data\Models\CategoryGroupDto;
use App\Data\Responses\PeriodSummary;
use App\Models\CategoryGroup;
use Illuminate\Contracts\Support\Responsable;
use Inertia\Inertia;

class BudgetPageResponse implements Responsable
{
    public function __construct(private readonly PeriodSummary $summary)
    {
    }

    public function toResponse($request)
    {
        return Inertia::render('BudgetPage', [
            'categoryGroups' => CategoryGroupDto::fetchAll(),
            'summary'        => $this->summary,
        ])
                      ->toResponse($request);
    }
}
