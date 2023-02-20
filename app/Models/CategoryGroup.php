<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

/**
 * App\Models\CategoryGroup
 *
 * @property int $id
 * @property string $name
 * @property int $seq
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryGroup whereSeq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 */
class CategoryGroup extends AbstractModel
{
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class)->orderBy('seq');
    }
}
