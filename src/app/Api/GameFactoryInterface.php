<?php

declare(strict_types=1);

namespace ChallengeBestPlayer\Api;

use ChallengeBestPlayer\Model\AbstractGame;

interface GameFactoryInterface {
    /**
     * @param array $data
     * @return AbstractGame
     */
    public function create(array $data): AbstractGame;
}
