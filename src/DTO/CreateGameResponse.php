<?php
declare(strict_types=1);

namespace App\DTO;

use App\Contract\GameResponse;

class CreateGameResponse implements GameResponse
{
    private int $gameId;

    public function __construct(int $gameId) {
        $this->gameId = $gameId;
    }

    public function getData(): array
    {
        return [
            'game_id' => $this->gameId
        ];
    }
}