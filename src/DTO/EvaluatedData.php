<?php
declare(strict_types=1);

namespace App\DTO;

class EvaluatedData
{
    private int $winner = 0;
    private bool $isEndgame = false;

    public function setWinner(int $winner) {
        $this->winner = $winner;
    }
    
    public function setEndGame(bool $status) {
        $this->isEndgame = $status;
    }

    public function getWinner(): ?int
    {
        return $this->winner;
    }

    public function isEndgame(): bool
    {
        return $this->isEndgame;
    }
}