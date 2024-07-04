<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Lottery;

/**
 * @property User $user
 * @property int $score
 * @property \DateTimeInterface|null $finished_at
 * @property $reward_id
 * @property $reward_name
 * @property $user_id
 * @property $ip
 */
class Game extends Model
{
    protected $table = 'games';

    protected $fillable = [
        'user_id',
        'score',
        'finished_at',
        'reward_id',
        'ip'
    ];

    const MAX_SCORE = 1000;
    const CERTAIN_SCORE = 5;

    protected function casts(): array
    {
        return [
            'finished_at' => 'datetime',
            'score' => 'int'
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getRewardNameAttribute()
    {
        if (!$this->reward_id) return '';
        return Reward::getAllRewards()->get($this->reward_id)->item;
    }

    public static function init($userId, $ip = null): Game
    {
        if (!$ip) {
            $ip = request()->ip();
        }
        return new Game([
            'user_id' => $userId,
            'score' => 0,
            'finished_at' => null,
            'reward_id' => null,
            'ip' => $ip
        ]);
    }

    public function isFinished(): bool
    {
        return $this->finished_at !== null;
    }

    public function isMaxScore(): bool
    {
        return $this->score === static::MAX_SCORE;
    }

    public function increaseScore(): void
    {
        $this->score++;
    }

    public function canHasReward(): bool
    {
        return $this->score > static::CERTAIN_SCORE;
    }

    public function finishGame(): void
    {
        $this->finished_at = Carbon::now();
        if ($this->canHasReward()) {
            $this->chooseReward();
        }
    }

    public function chooseReward(): void
    {
        /** @var Reward $reward */
        foreach (Reward::getAllRewards() as $reward) {
            Lottery::odds($reward->probability, 100)->winner(fn() => $this->reward_id = $reward->id)->choose(1);
            if ($this->reward_id) break;
        }
    }

}