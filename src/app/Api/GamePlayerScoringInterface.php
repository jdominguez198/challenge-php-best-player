<?php

namespace ChallengeBestPlayer\Api;

interface GamePlayerScoringInterface {
    public function setName(string $name): GamePlayerScoringInterface;
    public function getName(): string;
    public function setNickName(string $nickName): GamePlayerScoringInterface;
    public function getNickName(): string;
    public function addGamePoints(string $game, float $points): GamePlayerScoringInterface;
    public function getGamePoints(): array;
    public function getTotalPoints(): float;
}
