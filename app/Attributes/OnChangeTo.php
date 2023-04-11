<?php

namespace App\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
/**
 * Marks model methods that should be called when the specified field changes.
 */
class OnChangeTo
{
    public function __construct(public readonly string $field, public bool $beforeSave = true)
    {
    }
}
