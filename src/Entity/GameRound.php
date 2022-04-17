<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class GameRound
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=11)
     */
    private $gameId;

    /**
     * @ORM\Column(type="smallint")
     */
    private $position;

    /**
     * @ORM\Column(type="smallint")
     */
    private $playerNumber;

    private function __construct() {}

    public static function create(
        int $gameId,
        int $playerNumber,
        int $position
    ): GameRound {
        $gameRound = new self();
        $gameRound->gameId = $gameId;
        $gameRound->playerNumber = $playerNumber;
        $gameRound->position = $position;
        return $gameRound;
    }

    public function getPlayerNumber(): int {
        return $this->playerNumber;
    }

    public function getPosition(): int {
        return $this->position;
    }

    public function getGameId(): int {
        return $this->gameId;
    }

    public function getId(): int {
        return $this->id;
    }
}
