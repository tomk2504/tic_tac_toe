<?php
declare(strict_types=1);

namespace App\DTO;

class PlayMoveData
{
    private int $gameId;
    private int $playerNumber;
    private int $postion;

    /**
     * @param int $gameId
     * @param int $playerNumber
     * @param int $postion
     */
    public function __construct(
        int $gameId,
        int $playerNumber,
        int $postion
    ) {
        $this->gameId = $gameId;
        $this->playerNumber = $playerNumber;
        $this->position = $postion;
    }

    public function getGameId(): int {
        return $this->gameId;
    }

    public function getPlayerNumber(): int {
        return $this->playerNumber;
    }

    public function getPostion(): int {
        return $this->position;
    }
}