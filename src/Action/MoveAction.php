<?php
declare(strict_types=1);

namespace App\Action;

use App\DTO\PlayMoveData;
use App\Entity\GameRound;
use App\Repository\GameRoundRepository;

class MoveAction
{
    private GameRoundRepository $gameRoundRepository;

    public function __construct(
        GameRoundRepository $gameRoundRepository
    ) {
        $this->gameRoundRepository = $gameRoundRepository;
    }

    public function execute(PlayMoveData $playMoveData) {

        $gameRound = GameRound::create(
            $playMoveData->getGameId(),
            $playMoveData->getPlayerNumber(),
            $playMoveData->getPostion()
        );

        $this->persistGameRound($gameRound);

        return $this->gameRoundRepository->getAllByGame($playMoveData->getGameId());
    }

    private function persistGameRound(GameRound $gameRound) {
        $this->gameRoundRepository->add($gameRound);
    }
}