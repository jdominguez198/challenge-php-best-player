<?php

declare(strict_types=1);

interface GamePlayerInterface {
    public function getName();
    public function getNickName();
    public function getTeam();
    public function getPoints();
}
