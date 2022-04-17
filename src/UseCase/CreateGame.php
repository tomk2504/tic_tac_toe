<?php
declare(strict_types=1);

namespace App\UseCase;


use App\Contract\GameResponse;
use App\DTO\CreateGameData;
use App\DTO\CreateGameResponse;
use App\Entity\Game;
use App\Exception\CreateGameException;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class CreateGame
{
    const CREATE_GAME_ERROR_MESSAGE = 'create game error';
    private GameRepository $gameRepository;
    private LoggerInterface $logger;
    private EntityManagerInterface $entityManager;

    public function __construct(
        GameRepository $gameRepository,
        LoggerInterface $logger,
        EntityManagerInterface $entityManager
    ) {
        $this->gameRepository = $gameRepository;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    public function execute(CreateGameData $createGameData): GameResponse {
        $this->entityManager->getConnection()->beginTransaction();

        try {
            $game = Game::create(
                $createGameData->getPlayerOne(),
                $createGameData->getPlayerTwo()
            );

            $this->persistGame($game);
            $this->entityManager->getConnection()->commit();

        } catch (\Exception $e) {
            $this->entityManager->getConnection()->rollBack();
            $this->logger->error(self::CREATE_GAME_ERROR_MESSAGE);
            throw new CreateGameException(self::CREATE_GAME_ERROR_MESSAGE);
        }

        return new CreateGameResponse($game->getId());
    }

    private function persistGame(Game $game):void
    {
        $this->gameRepository->add($game);
    }
}