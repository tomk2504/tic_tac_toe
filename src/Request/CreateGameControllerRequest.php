<?php
declare(strict_types=1);

namespace App\Request;

use App\DTO\CreateGameData;
use App\Support\Request\AbstractControllerJsonRequest;
use Assert\Assert;

class CreateGameControllerRequest extends AbstractControllerJsonRequest
{
    private function getPlayerOne() {
        return $this->request['player_one'];
    }

    private function getPlayerTwo() {
        return $this->request['player_two'];
    }

    public function getData(): CreateGameData {
        Assert::lazy()
            ->that($this->request, 'exist player_one')->keyExists('player_one')
            ->that($this->request['player_one'],'player_one conditions')->notEmpty()->string()
            ->that($this->request, 'exist player_two')->keyExists('player_one')
            ->that($this->request['player_two'], 'player_two conditions')->notEmpty()->string()
            ->verifyNow();

        return new CreateGameData(
            $this->getPlayerOne(),
            $this->getPlayerTwo(),
        );
    }
}