<?php

namespace App\Rules\Attributes;

use App\Rules\ModelExistsRule;
use Attribute;
use Spatie\LaravelData\Support\Validation\ValidationRule;


#[Attribute(Attribute::TARGET_PROPERTY)]
class ModelExists extends ValidationRule
{
    public function __construct(public  readonly string $modelClass)
    {

    }

    public function getRules(): array
    {
        return [
            new ModelExistsRule($this->modelClass),
        ];
    }
}
