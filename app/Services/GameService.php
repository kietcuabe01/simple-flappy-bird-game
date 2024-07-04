<?php

namespace App\Services;

use App\Helper\CacheHelper;
use App\Models\Game;

class GameService
{
    public function passPillar(Game $game): void
    {
        $keyCache = CacheHelper::getKeyCacheUserIpScore($game->user_id, $game->score);

        if ($game->isFinished() || $game->isMaxScore()) {
            throw new \DomainException('Invalid Param');
        }

        $game->increaseScore();

        if ($game->isMaxScore()) {
            $game->finishGame();
        }

        $game->save();
    }

    public function hitPillar(Game $game): void
    {
        if ($game->isFinished()) {
            throw new \DomainException('Invalid Param');
        }
        $game->finishGame();
        $game->save();
    }
}