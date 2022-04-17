<?php
declare(strict_types=1);

namespace App\Evaluate;

abstract class AbstractEvaluated
{
    private $winner;
    private bool $isEnd = false;

    public function setWinner(int $winner) {
        $this->winner = $winner;
    }

    public function hasWinner(): bool {
        return !is_null($this->winner);
    }

    public function getWinner(): int {
        return $this->winner;
    }

    public function isEnd(): bool {
        return $this->isEnd;
    }

    public function setIsEnd(bool $isEnd): void {
        $this->isEnd = $isEnd;
    }

    public function getIsEnd(): bool {
        return $this->isEnd;
    }
}