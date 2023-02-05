<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractModel extends Model
{
    protected $guarded = [];

    public static function getFriendlyName(): string
    {
        return str(static::class)
            ->classBasename()
            ->snake(' ');
    }

    public function asCollection(): Collection
    {
        return $this->newCollection([$this]);
    }
}
