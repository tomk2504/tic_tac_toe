<?php
declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Game;
use App\Http\ApplicationCode;
use App\Repository\GameRepository;
use App\Tests\AbstractBaseWebTestCase;
use App\Tests\Faker\Entity\GameFaker;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class PlayMoveControllerTest extends AbstractBaseWebTestCase
{
    use ReloadDatabaseTrait;

    public function test_it_can_make_a_first_move() {

        $this->helper->hasGame();

        $this->client->request(
            'POST',
            '/api/1.0/game/move',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'game_id' => $this->helper::FIRST_GAME_ID,
                'player_number' => 1,
                'position' => 5
            ])
        );
        $response = $this->client->getResponse();

        $this->assertResponseIsSuccessful();
    }

    public function test_it_player_make_winning_move_horizontal() {

        $this->helper->hasGame();
        $this->helper->playerHasMoves([
            ['player' => 1, 'position' => 2],['player' => 1, 'position' => 3], //player one move
            ['player' => 2, 'position' => 4],['player' => 2, 'position' => 7] //player two move
        ]);

        $this->client->request(
            'POST',
            '/api/1.0/game/move',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'game_id' => $this->helper::FIRST_GAME_ID,
                'player_number' => 1,
                'position' => 1
            ])
        );

        $this->assertResponseIsSuccessful();
    }

    public function test_it_player_make_winning_move_vertical() {

        $this->helper->hasGame();
        $this->helper->playerHasMoves([
            ['player' => 1, 'position' => 1],['player' => 2, 'position' => 2], //player one move
            ['player' => 2, 'position' => 5],['player' => 1, 'position' => 6] //player two move
        ]);

        $this->client->request(
            'POST',
            '/api/1.0/game/move',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'game_id' => $this->helper::FIRST_GAME_ID,
                'player_number' => 2,
                'position' => 8
            ])
        );

        $this->assertResponseIsSuccessful();
    }

    public function test_it_player_make_winning_move_diagonal_left() {

        $this->helper->hasGame();
        $this->helper->playerHasMoves([
            ['player' => 1, 'position' => 1],['player' => 2, 'position' => 2], //player one move
            ['player' => 1, 'position' => 5],['player' => 2, 'position' => 6] //player two move
        ]);

        $this->client->request(
            'POST',
            '/api/1.0/game/move',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'game_id' => $this->helper::FIRST_GAME_ID,
                'player_number' => 1,
                'position' => 9
            ])
        );

        $this->assertResponseIsSuccessful();
    }

    public function test_it_player_make_winning_move_diagonal_right() {

        $this->helper->hasGame();
        $this->helper->playerHasMoves([
            ['player' => 1, 'position' => 3],['player' => 2, 'position' => 2], //player one move
            ['player' => 1, 'position' => 5],['player' => 2, 'position' => 6] //player two move
        ]);

        $this->client->request(
            'POST',
            '/api/1.0/game/move',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'game_id' => $this->helper::FIRST_GAME_ID,
                'player_number' => 1,
                'position' => 7
            ])
        );

        $this->assertResponseIsSuccessful();
    }
}