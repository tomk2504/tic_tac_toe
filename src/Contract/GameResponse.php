<?php
declare(strict_types=1);

namespace App\Contract;

interface GameResponse
{
    public function getData(): array;
}