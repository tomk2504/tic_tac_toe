<?php
declare(strict_types=1);

namespace App\Action;

use App\Contract\EvaluatedContract;
use App\DTO\EvaluatedData;
use App\Evaluate\DiagonalEvaluated;
use App\Evaluate\HorizontalEvaluated;
use App\Evaluate\VerticalEvaluated;
use App\Transformer\GameMatrixTransformedData;
use Doctrine\Common\Collections\ArrayCollection;

class EvaluateMoveAction
{
    const SIZE_MATRIX_X = 3;
    const SIZE_MATRIX_Y = 3;
    private EvaluatedData $evaluatedData;

    public function execute(array $matrixTransformedData, array $gameRounds): EvaluatedData {
        $evaluationsAction = [
            new HorizontalEvaluated(),
            new VerticalEvaluated(),
            new DiagonalEvaluated()
        ];

        $this->evaluatedData = new EvaluatedData();

        array_map(function(EvaluatedContract $one) use ($matrixTransformedData) {
            if($one->hasWinner()) {
                return false;
            }
            $one->execute($matrixTransformedData);
            $this->evaluatedData->setEndGame($one->getIsEnd());

            if($one->hasWinner()) {
                $this->evaluatedData->setWinner($one->getWinner());
                $this->evaluatedData->setEndGame(true);
                return false;
            }
        }, $evaluationsAction);

        $this->evaluateEndGame($gameRounds);

        return $this->evaluatedData;
    }

    private function evaluateEndGame(array $gameRounds): void {
        $isEndGame = count($gameRounds) === (self::SIZE_MATRIX_X * self::SIZE_MATRIX_Y) ||
            !empty($this->evaluatedData->getWinner()) ? true : false;
        $this->evaluatedData->setEndGame($isEndGame);
    }
}