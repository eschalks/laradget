<?php

namespace App\TypeScript;

use ReflectionClass;
use Spatie\TypeScriptTransformer\Collectors\Collector;
use Spatie\TypeScriptTransformer\Structures\TransformedType;

class PageCollector extends Collector
{
    public function getTransformedType(ReflectionClass $class): ?TransformedType
    {
        // TODO: Implement getTransformedType() method.
    }
}
