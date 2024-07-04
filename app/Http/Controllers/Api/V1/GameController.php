<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\ResponseHelper;
use App\Http\Controllers\ApiController;
use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Services\GameService;
use Illuminate\Support\Facades\Auth;

class GameController extends ApiController
{
    public function init()
    {
        $game = Game::init(Auth::id());
        $game->save();
        return ResponseHelper::success('ok', new GameResource($game));
    }

    public function passPillar(Game $game)
    {
        /** @var GameService $service */
        $service = app(GameService::class);
        $service->passPillar($game);
        return ResponseHelper::success('ok', new GameResource($game));
    }

    public function hitPillar(Game $game)
    {
        /** @var GameService $service */
        $service = app(GameService::class);
        $service->hitPillar($game);
        return ResponseHelper::success('ok', new GameResource($game));
    }
}