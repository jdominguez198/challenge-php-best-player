<?php

declare(strict_types=1);

use ChallengeBestPlayer\Model\Games\Valorant;
use PHPUnit\Framework\TestCase;

class ValorantTest extends TestCase {

    public function testConstructorWorksAsExpected(): void
    {
        $data = [
            Valorant::KEY_NAME => 'Random Player #01',
            Valorant::KEY_NICK_NAME => 'random_player_01',
            Valorant::KEY_TEAM => 'Random Team',
            Valorant::KEY_KILLS => 10,
            Valorant::KEY_DEATHS => 1,
        ];

        $model = new Valorant($data);

        $this->assertEquals($data[Valorant::KEY_NAME], $model->getName());
        $this->assertEquals($data[Valorant::KEY_NICK_NAME], $model->getNickName());
        $this->assertEquals($data[Valorant::KEY_TEAM], $model->getTeam());
        $this->assertEquals($data[Valorant::KEY_KILLS], $model->getKills());
        $this->assertEquals($data[Valorant::KEY_DEATHS], $model->getDeaths());
    }

    public function testPointsAreCalculatedCorrectly(): void
    {
        $data = [
            Valorant::KEY_NAME => 'Random Player #01',
            Valorant::KEY_NICK_NAME => 'random_player_01',
            Valorant::KEY_TEAM => 'Random Team',
            Valorant::KEY_KILLS => 10,
            Valorant::KEY_DEATHS => 1,
        ];

        $model = new Valorant($data);

        $this->assertEquals(10, $model->getPoints());
    }

    public function testPointsAreZeroIfDeathsAreZero(): void
    {
        $data = [
            Valorant::KEY_NAME => 'Random Player #01',
            Valorant::KEY_NICK_NAME => 'random_player_01',
            Valorant::KEY_TEAM => 'Random Team',
            Valorant::KEY_KILLS => 10,
            Valorant::KEY_DEATHS => 0,
        ];

        $model = new Valorant($data);

        $this->assertEquals(0, $model->getPoints());
    }

}
