<?php

declare(strict_types=1);

namespace ChallengeBestPlayer\Service;

use ChallengeBestPlayer\Api\GamePlayerScoringInterface;
use ChallengeBestPlayer\Api\GamePlayerInterface;
use ChallengeBestPlayer\Model\GamePlayerScoringScoring;

class BestPlayerCalculator {
    protected array $players = [];

    public function execute(array $gamePlayers): GamePlayerScoringInterface
    {
        $this->summarizePlayerStats($gamePlayers);

        return $this->findBestPlayer();
    }

    protected function summarizePlayerStats(array $players): void
    {
        foreach ($players as $player) {
            /** @var GamePlayerInterface $player */
            if (!array_key_exists($player->getNickName(), $this->players)) {
                $bestPlayerModel = new GamePlayerScoringScoring();

                $this->players[$player->getNickName()] = $bestPlayerModel
                    ->setName($player->getName())
                    ->setNickName($player->getNickName())
                ;
            }

            $playerPoints = $player->getPoints();
            $this->players[$player->getNickName()]->addGamePoints(
                $player->getGame(),
                $player->getPoints()
            );
        }
    }

    protected function findBestPlayer(): GamePlayerScoringInterface
    {
        $clonePlayers = $this->players;
        usort($clonePlayers, function (GamePlayerScoringInterface $playerA, GamePlayerScoringInterface $playerB) {
            return $playerB->getTotalPoints() - $playerA->getTotalPoints();
        });

        return $clonePlayers[0];
    }
}
