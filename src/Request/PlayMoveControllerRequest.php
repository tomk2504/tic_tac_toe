<?php
declare(strict_types=1);

namespace App\Request;

use App\DTO\PlayMoveData;
use App\Support\Request\AbstractControllerJsonRequest;
use Assert\Assert;

class PlayMoveControllerRequest extends AbstractControllerJsonRequest
{
    private function getGameId() {
        return $this->request['game_id'];
    }

    private function getPlayerNumber() {
        return $this->request['player_number'];
    }

    private function getPosition() {
        return $this->request['position'];
    }

    public function getData(): PlayMoveData
    {
        Assert::lazy()
            ->that($this->request, 'exist game_id')
                ->keyExists('game_id')
            ->that($this->request['game_id'],'position conditions')
                ->notEmpty()->integer()
            ->that($this->request, 'exist player_number')
                ->keyExists('player_number')
            ->that($this->request['player_number'], 'player_number conditions')
                ->notEmpty()->integer()->between(1,2)
            ->that($this->request, 'exist position')
                ->keyExists('position')
            ->that($this->request['position'], 'position conditions')
                ->notEmpty()->integer()->between(1,9)
            ->verifyNow();


        return new PlayMoveData(
            $this->getGameId(),
            $this->getPlayerNumber(),
            $this->getPosition()
        );
    }
}