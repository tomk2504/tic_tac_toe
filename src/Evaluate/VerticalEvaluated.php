<?php
declare(strict_types=1);

namespace App\Evaluate;

use App\Contract\EvaluatedContract;

class VerticalEvaluated extends AbstractEvaluated implements EvaluatedContract
{
    public function execute(array $matrixTransformedData): void {

        $points = [];

        for($xCoordinate = 0; $xCoordinate < 3; $xCoordinate++) {
            for($yCoordinate = 0; $yCoordinate < 3; $yCoordinate++) {

                $actualPlayer = $matrixTransformedData[$xCoordinate][$yCoordinate];

                if($actualPlayer == 0) {
                    continue;
                }

                if(!isset($points[$yCoordinate][$actualPlayer])) {
                    $points[$yCoordinate] = null;
                    $points[$yCoordinate][$actualPlayer] = 1;
                    continue;
                }

                $points[$yCoordinate][$actualPlayer]++;

                if($points[$yCoordinate][$actualPlayer] == 3) {
                    $this->setIsEnd(true);
                    $this->setWinner($actualPlayer);
                    return;
                }
            }
        }
    }
}