<?php

namespace App\Models;

/**
 * App\Models\CounterParty
 *
 * @property int $id
 * @property string $name
 * @property string $iban
 * @property int|null $default_category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty query()
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty whereDefaultCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CounterParty extends AbstractModel
{
}
