<?php
declare(strict_types=1);

namespace App\Evaluate;

use App\Contract\EvaluatedContract;
use App\Transformer\GameMatrixTransformedData;

class HorizontalEvaluated extends AbstractEvaluated implements EvaluatedContract
{
    public function execute(array $matrixTransformedData): void {

        $points = 0;
        $actualPlayer = 0;

        foreach($matrixTransformedData as $matrixRow) {
            foreach($matrixRow as $column => $coordinateValue) {
                if($coordinateValue == 0) {
                    continue;
                }

                if($actualPlayer != $coordinateValue) {
                    $points++;
                    $actualPlayer = $coordinateValue;
                    continue;
                }

                $points++;

                if($points == 3) {
                    $this->setIsEnd(true);
                    $this->setWinner($actualPlayer);
                    return;
                }
            }
            $points = 0;
        }
    }
}