<?php
declare(strict_types=1);

namespace App\Transformer;

class GameMatrixTransformedData
{
    public function transform(?array $roundData): array {

        $playedMoves = [];

        foreach($roundData as $gameRound) {
            $playedMoves[$gameRound->getPosition()] = $gameRound->getPlayerNumber();
        }

        $gameMatrix = [];
        $actualPosition = 1;

        for($xCoordinate=0; $xCoordinate<3; $xCoordinate++) {
            for($yCoordinate=0; $yCoordinate<3; $yCoordinate++) {
                $playerPosition = 0;
                if(array_key_exists($actualPosition, $playedMoves)) {
                    $playerPosition = $playedMoves[$actualPosition];
                }
                $gameMatrix[$xCoordinate][$yCoordinate] = $playerPosition;
                $actualPosition++;
            }
        }
        return $gameMatrix;
    }
}