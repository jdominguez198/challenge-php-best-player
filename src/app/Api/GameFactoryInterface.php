<?php

declare(strict_types=1);

namespace ChallengeBestPlayer\Api;

interface GameFactoryInterface {
    /**
     * @param array $data
     * @return GamePlayerInterface
     */
    public function create(array $data): GamePlayerInterface;
}
