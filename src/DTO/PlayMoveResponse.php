<?php
declare(strict_types=1);

namespace App\DTO;

use App\Contract\GameResponse;

class PlayMoveResponse implements GameResponse
{
    private int $gameId;
    private bool $isEndGame;
    private int $wonPlayer;
    private array $gameMatrix;

    public function __construct(
        int $gameId,
        bool $isEndGame,
        int $wonPlayer,
        array $gameMatrix
    ) {

        $this->gameId = $gameId;
        $this->isEndGame = $isEndGame;
        $this->wonPlayer = $wonPlayer;
        $this->gameMatrix = $gameMatrix;
    }

    public function getData(): array
    {
        return [
            'game_id' => $this->gameId,
            'isEndGame' => $this->isEndGame,
            'wonPlayer' => $this->wonPlayer,
            'gameMatrix' => $this->gameMatrix
        ];
    }
}