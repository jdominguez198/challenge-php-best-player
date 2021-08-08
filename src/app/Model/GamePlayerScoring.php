<?php

declare(strict_types=1);

namespace ChallengeBestPlayer\Model;

use ChallengeBestPlayer\Api\GamePlayerScoringInterface;

class GamePlayerScoring implements GamePlayerScoringInterface {
    protected string $name;
    protected string $nickName;
    protected array $gamePoints = [];

    public function setName(string $name): GamePlayerScoringInterface
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setNickName(string $nickName): GamePlayerScoringInterface
    {
        $this->nickName = $nickName;

        return $this;
    }

    public function getNickName(): string
    {
        return $this->nickName;
    }

    public function addGamePoints(string $game, float $points): GamePlayerScoringInterface
    {
        $this->gamePoints[$game] = $points;

        return $this;
    }

    public function getGamePoints(): array
    {
        return $this->gamePoints;
    }

    public function getTotalPoints(): float
    {
        return array_reduce($this->gamePoints, function ($accum, $points) {
            return $accum + $points;
        }, 0.0);
    }

}
