<?php
declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Game;
use App\Http\ApplicationCode;
use App\Repository\GameRepository;
use App\Tests\AbstractBaseWebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class CreateGameControllerTest extends AbstractBaseWebTestCase
{
    use ReloadDatabaseTrait;

    public function test_it_can_create_a_game() {

        $playerOne = $this->faker->userName();
        $playerTwo = $this->faker->userName();

        $this->client->request(
            'POST',
            '/api/1.0/game/create',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'player_one' => $playerOne,
                'player_two' => $playerTwo
            ])
        );

        $game = $this->entityManager
            ->getRepository(Game::class)
            ->findOneBy([
                'playerOne' => $playerOne,
                'playerTwo' => $playerTwo
            ]);

        $this->assertInstanceOf(Game::class, $game);
        $this->assertResponseIsSuccessful();
    }

    public function test_it_cant_create_a_game_with_wrong_payload() {
        $this->client->request(
            'POST',
            '/api/1.0/game/create',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'playerone' => $this->faker->userName(),
                'player_two' => $this->faker->userName()
            ])
        );

        $this->assertResponseStatusCodeSame(ApplicationCode::BAD_REQUEST);
    }
}