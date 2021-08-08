<?php

namespace ChallengeBestPlayer\Api;

interface GameFactoryInterface {
    /**
     * @param array $data
     * @return GamePlayerInterface
     */
    public function create(array $data): GamePlayerInterface;
}
