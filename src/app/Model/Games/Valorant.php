<?php

declare(strict_types=1);

namespace ChallengeBestPlayer\Model\Games;

use ChallengeBestPlayer\Model\AbstractGamePlayer;

class Valorant extends AbstractGamePlayer {
    const GAME_NAME = 'VALORANT';

    public static array $keyProperties = [
        self::KEY_NAME,
        self::KEY_NICK_NAME,
        self::KEY_TEAM,
        self::KEY_KILLS,
        self::KEY_DEATHS,
    ];

    public function getGame(): string
    {
        return self::GAME_NAME;
    }

    public function getPoints(): float
    {
        return $this->getDeaths() === 0 ? 0 : $this->getKills() / $this->getDeaths();
    }
}
