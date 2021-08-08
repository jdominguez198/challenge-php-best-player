<?php

declare(strict_types=1);

namespace ChallengeBestPlayer\Model;

use ChallengeBestPlayer\Api\GamePlayerInterface;

class BestPlayer {
    protected array $players = [];

    public function execute(array $gamePlayers): array
    {
        $this->populatePlayers($gamePlayers);

        return $this->findBestPlayer();
    }

    protected function populatePlayers(array $players): void
    {
        foreach ($players as $player) {
            /** @var GamePlayerInterface $player */
            if (!array_key_exists($player->getNickName(), $this->players)) {
                $this->players[$player->getNickName()] = [
                    'name' => $player->getName(),
                    'team' => $player->getTeam(),
                    'points' => [],
                    'total' => 0.0
                ];
            }

            $playerPoints = $player->getPoints();
            $this->players[$player->getNickName()]['points'][$player->getGame()] = $playerPoints;
            $this->players[$player->getNickName()]['total'] += $playerPoints;
        }
    }

    protected function findBestPlayer(): array
    {
        $clonePlayers = $this->players;
        usort($clonePlayers, function ($playerA, $playerB) {
            return $playerB['total'] - $playerA['total'];
        });

        return $clonePlayers[0];
    }
}
