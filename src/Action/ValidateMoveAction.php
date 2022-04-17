<?php
declare(strict_types=1);

namespace App\Action;

use App\DTO\PlayMoveData;
use App\Exception\MoveNotValidException;
use App\Repository\GameRepository;
use App\Repository\GameRoundRepository;
use App\Exception\NotValidGameException;
use Psr\Log\LoggerInterface;

class ValidateMoveAction
{
    const NOT_VALID_GAME_ID_EXCEPTION = 'not valid game_id exception';
    const NOT_VALID_TURN = 'not valid turn';

    private GameRepository $gameRepository;
    private GameRoundRepository $gameRoundRepository;

    public function __construct(
        GameRepository $gameRepository,
        GameRoundRepository $gameRoundRepository
    ) {
        $this->gameRepository = $gameRepository;
        $this->gameRoundRepository = $gameRoundRepository;
    }

    public function execute(PlayMoveData $playMoveData) {

        if(!$this->gameRepository->isValidGame($playMoveData->getGameId())) {
            throw new NotValidGameException(self::NOT_VALID_GAME_ID_EXCEPTION);
        }

        if(!$this->gameRoundRepository->isValidPlayer($playMoveData->getGameId(), $playMoveData->getPlayerNumber())
             || !$this->gameRoundRepository->isValidMove($playMoveData->getGameId(), $playMoveData->getPostion())) {

            throw new MoveNotValidException(self::NOT_VALID_TURN);
        }
    }
}