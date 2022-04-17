<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\GameRound;
use App\Support\Exception\ApplicationException;
use Doctrine\ORM\EntityManagerInterface;

class GameRoundRepository
{
    const GAME_ROUND_DONT_EXIST_ERROR_MESSAGE = 'GAME_ROUND_NOT_FOUND';
    private EntityManagerInterface $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(GameRound::class);
    }

    public function add(GameRound $gameRound) {
        $this->entityManager->persist($gameRound);
        $this->entityManager->flush();
    }

    public function update(GameRound $gameRound) {
        $this->entityManager->persist($gameRound);
        $this->entityManager->flush();
    }

    public function isValidPlayer(int $gameId, int $playerNumber) {
        /** @var GameRound $gameRound */
        $gameRound = $this->repository->findOneBy(['gameId' => $gameId], ['id' => 'DESC']);

        return (empty($gameRound) || $gameRound->getPlayerNumber() !== $playerNumber);
    }

    public function isValidMove(int $gameId, int $position) {
        $gameRound = $this->repository->findOneBy([
            'gameId' => $gameId,
            'position' => $position
        ]);

        return empty($gameRound);
    }

    public function getAllByGame(int $gameId) {
        return $this->repository->findBy(['gameId' => $gameId]);
    }
}