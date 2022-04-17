<?php

namespace App\Tests\Helper;

use App\Entity\Game;
use App\Entity\GameRound;
use App\Repository\GameRepository;
use App\Repository\GameRoundRepository;
use App\Tests\Faker\Entity\GameFaker;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\DependencyInjection\Container;

class TestHelper
{
    const FIRST_GAME_ID = 1;
    private Container $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function hasGame() {
        $faker = Factory::create();

        $game = Game::create(
            $faker->userName(),
            $faker->userName()
        );

        $gameRepository = $this->container->get(GameRepository::class);
        $gameRepository->add($game);
    }

    public function playerHasMoves(array $moves) {

        foreach($moves as $move) {

            $gameRound = GameRound::create(
                self::FIRST_GAME_ID,
                $move['player'],
                $move['position']
            );

            $gameRoundRepository = $this->container->get(GameRoundRepository::class);
            $gameRoundRepository->add($gameRound);
        }
    }
}