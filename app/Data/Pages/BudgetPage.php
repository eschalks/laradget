<?php

namespace App\Data\Pages;

use App\Data\Models\CategoryGroupDto;
use App\Data\Responses\PeriodSummary;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

class BudgetPage extends AbstractPage
{
    private function __construct(
        public readonly Collection $categoryGroups,
        public readonly PeriodSummary  $summary,
    ) {
    }

    public static function create(PeriodSummary $summary): self
    {
        return new self(CategoryGroupDto::fetchAll(), $summary);
    }

    protected function getPageComponent(): string
    {
        return 'BudgetPage';
    }
}
