<?php

namespace App\Models;

/**
 * App\Models\AccountProvider
 *
 * @property int $id
 * @property string $access_token
 * @property string $refresh_token
 * @property \Illuminate\Support\Carbon $expires_at
 * @method static \Illuminate\Database\Eloquent\Builder|AccountProvider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountProvider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountProvider query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountProvider whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountProvider whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountProvider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountProvider whereRefreshToken($value)
 * @property int $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|AccountProvider whereIsActive($value)
 * @mixin \Eloquent
 */
class AccountProvider extends AbstractModel
{
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public $timestamps = false;
}
