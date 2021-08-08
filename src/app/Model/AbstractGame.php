<?php

declare(strict_types=1);

namespace ChallengeBestPlayer\Model;

use ChallengeBestPlayer\Api\GamePlayerInterface;

abstract class AbstractGame implements GamePlayerInterface
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = [
            'name' => $data['name'] ?? null,
            'nickName' => $data['nickName'] ?? null,
            'team' => $data['team'] ?? null,
        ];
    }

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getNickName(): string
    {
        return $this->data['nickName'];
    }

    public function getTeam(): string
    {
        return $this->data['team'];
    }

    abstract public function getPoints(): float;
}
