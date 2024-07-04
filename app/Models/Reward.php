<?php

namespace App\Models;

use App\Helper\CacheHelper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * @property float $probability
 * @property string $item
 */
class Reward extends Model
{
    protected $table = 'rewards';

    protected $fillable = [
        'probability',
        'item'
    ];

    protected function casts(): array
    {
        return [
            'probability' => 'float',
        ];
    }

    private static $_rewards = null;

    public static function getAllRewards(): Collection
    {
        if (static::$_rewards === null) {
            static::$_rewards = Cache::rememberForever(CacheHelper::KEY_ALL_REWARDS, fn () => Reward::all()->keyBy('id'));
        }
        return static::$_rewards;
    }
}