<?php

declare(strict_types=1);

namespace ChallengeBestPlayer\Model\Games;

use ChallengeBestPlayer\Model\AbstractGamePlayer;

class Valorant extends AbstractGamePlayer {
    public static array $keyProperties = [
        self::KEY_NAME,
        self::KEY_NICK_NAME,
        self::KEY_TEAM,
        self::KEY_KILLS,
        self::KEY_DEATHS,
    ];

    public function getGame(): string
    {
        return 'VALORANT';
    }

    public function getPoints(): float
    {
        if ($this->getDeaths() === 0) {
            return 0.0;
        }

        return $this->getKills() / $this->getDeaths();
    }
}
