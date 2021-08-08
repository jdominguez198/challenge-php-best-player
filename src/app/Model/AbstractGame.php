<?php

declare(strict_types=1);

namespace ChallengeBestPlayer\Model;

use ChallengeBestPlayer\Api\GamePlayerInterface;

abstract class AbstractGame implements GamePlayerInterface
{
    protected array $data;

    public static array $keyProperties = [];

    public function __construct(array $data)
    {
        $this->data = [
            self::KEY_NAME => (string) $data[self::KEY_NAME] ?? null,
            self::KEY_NICK_NAME => (string) $data[self::KEY_NICK_NAME] ?? null,
            self::KEY_TEAM => (string) $data[self::KEY_TEAM] ?? null,
            self::KEY_KILLS => (int) $data[self::KEY_KILLS] ?? 0,
            self::KEY_DEATHS => (int) $data[self::KEY_DEATHS] ?? 0,
        ];
    }

    public function getName(): string
    {
        return $this->data[self::KEY_NAME];
    }

    public function getNickName(): string
    {
        return $this->data[self::KEY_NICK_NAME];
    }

    public function getTeam(): string
    {
        return $this->data[self::KEY_TEAM];
    }

    public function getKills(): int
    {
        return $this->data[self::KEY_KILLS];
    }

    public function getDeaths(): int
    {
        return $this->data[self::KEY_DEATHS];
    }

    abstract public function getPoints(): float;
}
