<?php

namespace App\Http\Resources;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Game|JsonResource $this */
        return [
            'id' => $this->id,
            'score' => $this->score,
            'reward_name' => $this->reward_name,
            'finished_at' => $this->finished_at,
            'is_max_score' => $this->isMaxScore()
        ];
    }
}
