<?php

namespace App\Data\Pages;

use Illuminate\Contracts\Support\Responsable;
use Inertia\Inertia;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;


abstract class AbstractPage extends Data
{
    abstract protected function getPageComponent(): string;

    public function toResponse($request)
    {
        return Inertia::render($this->getPageComponent(), $this)
                      ->toResponse($request);
    }
}
