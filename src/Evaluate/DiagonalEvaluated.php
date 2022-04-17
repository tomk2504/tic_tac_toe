<?php
declare(strict_types=1);

namespace App\Evaluate;

use App\Contract\EvaluatedContract;
use App\Transformer\GameMatrixTransformedData;

class DiagonalEvaluated extends AbstractEvaluated implements EvaluatedContract
{
    const LEFT_DIRECTION = 'left';
    const RIGHT_DIRECTION = 'right';

    public function execute(array $matrixTransformedData): void {
        $points = [];
        $positionCount = 0;

        // left diagonal always 4 difference per row (1,2,3,  4,5,6,  7,8,9) -> 1 x 4 x 9 !
        // right diagonal always 2 difference per row
        if($this->evaluateDiagonal($positionCount, $matrixTransformedData, $points, self::LEFT_DIRECTION)) {
            return;
        }
        $this->evaluateDiagonal($positionCount, $matrixTransformedData, $points, self::RIGHT_DIRECTION);
    }

    /**
     * @param int $positionCount
     * @param array $matrixTransformedData
     * @param array $points
     * @return void
     */
    private function evaluateDiagonal(
        int $positionCount,
        array $matrixTransformedData,
        array $points, string $direction
    ): bool {
        $diagonalPointsPerRowDifference = $direction === self::LEFT_DIRECTION ? 4 : 2;

        for ($xCoordinate = 0; $xCoordinate < 3; $xCoordinate++) {
            for ($yCoordinate = 0; $yCoordinate < 3; $yCoordinate++) {
                $positionCount++;
                $actualPlayer = $matrixTransformedData[$xCoordinate][$yCoordinate];

                if ($actualPlayer == 0) {
                    continue;
                }

                if ($xCoordinate == 0) {
                    $points[$positionCount][$actualPlayer] = 1;
                    continue;
                }

                if (isset($points[$positionCount - $diagonalPointsPerRowDifference][$actualPlayer])) {
                    $points[$positionCount][$actualPlayer]
                        = $points[$positionCount - $diagonalPointsPerRowDifference][$actualPlayer] + 1;
                } else {
                    $points[$positionCount][$actualPlayer] = 1;
                    continue;
                }

                if ($points[$positionCount][$actualPlayer] == 3) {
                    $this->setIsEnd(true);
                    $this->setWinner($actualPlayer);
                    return true;
                }
            }
        }
        return false;
    }
}