<?php
declare(strict_types=1);

namespace App\UseCase;

use App\Action\EvaluateMoveAction;
use App\Action\MoveAction;
use App\Action\ValidateMoveAction;
use App\Contract\GameResponse;
use App\DTO\PlayMoveData;
use App\DTO\PlayMoveResponse;
use App\Support\Exception\ApplicationException;
use App\Transformer\GameMatrixTransformedData;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class PlayMove
{
    const PLAY_MOVE_ERROR_MESSAGE = 'play move error';
    private ValidateMoveAction $validateMoveAction;
    private MoveAction $moveAction;
    private EvaluateMoveAction $evaluateMoveAction;
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;

    public function __construct(
        ValidateMoveAction $validateMoveAction,
        MoveAction $moveAction,
        EvaluateMoveAction $evaluateMoveAction,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    ) {
        $this->validateMoveAction = $validateMoveAction;
        $this->moveAction = $moveAction;
        $this->evaluateMoveAction = $evaluateMoveAction;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    /**
     * @param PlayMoveData $playMoveData
     * @return GameResponse
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function execute(PlayMoveData $playMoveData): GameResponse {

        $this->entityManager->getConnection()->beginTransaction();

        try {
            $this->validateMoveAction->execute($playMoveData);
            $gameRounds = $this->moveAction->execute($playMoveData);
            $transformedGameMatrix = (new GameMatrixTransformedData())->transform($gameRounds);

            $evaluatedResponse = $this->evaluateMoveAction->execute(
                $transformedGameMatrix, $gameRounds);

            $this->entityManager->getConnection()->commit();

            return new PlayMoveResponse(
                $playMoveData->getGameId(),
                $evaluatedResponse->isEndgame(),
                $evaluatedResponse->getWinner(),
                $transformedGameMatrix
            );

        } catch (ApplicationException $e) {
            $this->entityManager->getConnection()->rollBack();
            $this->logger->error($e->getMessage());
            throw new ApplicationException($e->getMessage());
        }
    }
}