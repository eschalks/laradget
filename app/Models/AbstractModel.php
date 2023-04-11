<?php

namespace App\Models;

use App\Attributes\OnChangeTo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

abstract class AbstractModel extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::registerChangeListeners();
    }

    public static function getFriendlyName(): string
    {
        return str(static::class)
            ->classBasename()
            ->snake(' ');
    }

    private static function registerChangeListeners()
    {
        $class = new \ReflectionClass(static::class);

        foreach ($class->getMethods() as $method) {
            $attributes = $method->getAttributes(OnChangeTo::class);
            foreach ($attributes as $attribute) {
                /** @var  OnChangeTo $attributeInstance */
                $attributeInstance = $attribute->newInstance();

                $event = $attributeInstance->beforeSave ? 'saving' : 'saved';

                static::{$event}(static function (AbstractModel $model) use ($attributeInstance, $method) {
                    if ($model->isDirty($attributeInstance->field)) {
                        $method->invoke($model);
                    }
                });
            }
        }
    }

    public function asCollection(): Collection
    {
        return $this->newCollection([$this]);
    }
}
