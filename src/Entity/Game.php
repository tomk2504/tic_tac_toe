<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $playerOne;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $playerTwo;

    private function __construct() {}

    public static function create(
        string $playerOne,
        string $playerTwo
    ): Game {
        $game = new self();
        $game->playerOne = $playerOne;
        $game->playerTwo = $playerTwo;
        return $game;
    }

    public function getPlayerTwo(): string {
        return $this->playerTwo;
    }

    public function getPlayerOne(): string {
        return $this->playerOne;
    }

    public function getId(): int {
        return $this->id;
    }

}
