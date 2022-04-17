<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Game;
use App\Support\Exception\ApplicationException;
use Doctrine\ORM\EntityManagerInterface;

class GameRepository
{
    const GAME_DONT_EXIST_ERROR_MESSAGE = 'GAME_NOT_FOUND';
    private EntityManagerInterface $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Game ::class);
    }

    public function get(int $id): Game {
        if (null === ($game = $this->repository->find($id))) {
            throw new ApplicationException(self::GAME_DONT_EXIST_ERROR_MESSAGE);
        }

        return $game;
    }

    public function add(Game $game) {
        $this->entityManager->persist($game);
        $this->entityManager->flush();
    }

    public function isValidGame(int $gameId) {
        $game = $this->get($gameId);
        return !empty($game);
    }
}