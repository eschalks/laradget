<?php

namespace App\Rules;

use App\Models\AbstractModel;
use Assert\Assertion;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class ModelExistsRule implements Rule
{
    public function __construct(private readonly string $modelClass)
    {
        Assertion::subclassOf($this->modelClass, AbstractModel::class);
    }

    public function passes($attribute, $value)
    {
        return $this->modelClass::whereKey($value)->exists();
    }

    public function message()
    {
        return sprintf('Not a valid %s', $this->modelClass::getFriendlyName());
    }
}
