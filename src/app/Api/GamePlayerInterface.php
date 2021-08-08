<?php

declare(strict_types=1);

namespace ChallengeBestPlayer\Api;

interface GamePlayerInterface {
    const KEY_NAME = 'name';
    const KEY_NICK_NAME = 'nickName';
    const KEY_TEAM = 'team';
    const KEY_KILLS = 'kills';
    const KEY_DEATHS = 'deaths';

    public function getGame(): string;
    public function getName(): string;
    public function getNickName(): string;
    public function getTeam(): string;
    public function getKills(): int;
    public function getDeaths(): int;
    public function getPoints(): float;
}
