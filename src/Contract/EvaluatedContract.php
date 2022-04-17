<?php
declare(strict_types=1);

namespace App\Contract;

use App\Transformer\GameMatrixTransformedData;

interface EvaluatedContract
{
    public function execute(array $matrixTransformedData): void;
    public function hasWinner(): bool;
    public function getWinner(): int;
    public function getIsEnd(): bool;
}