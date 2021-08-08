<?php

declare(strict_types=1);

namespace ChallengeBestPlayer\Api;

interface GamePlayerInterface {
    public function getName();
    public function getNickName();
    public function getTeam();
    public function getPoints();
}
