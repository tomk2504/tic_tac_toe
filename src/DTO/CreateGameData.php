<?php
declare(strict_types=1);

namespace App\DTO;

class CreateGameData
{
    private string $playerOne;
    private string $playerTwo;

    public function __construct(
        string $playerOne,
        string $playerTwo
    ) {
        $this->playerOne = $playerOne;
        $this->playerTwo = $playerTwo;
    }

    public function getPlayerOne(): string
    {
        return $this->playerOne;
    }

    public function getPlayerTwo(): string
    {
        return $this->playerTwo;
    }

}