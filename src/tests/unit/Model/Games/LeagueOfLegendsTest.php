<?php

declare(strict_types=1);

use ChallengeBestPlayer\Model\Games\LeagueOfLegends;
use PHPUnit\Framework\TestCase;

class LeagueOfLegendsTest extends TestCase {

    public function testConstructorWorksAsExpected(): void
    {
        $data = [
            LeagueOfLegends::KEY_NAME => 'Random Player #01',
            LeagueOfLegends::KEY_NICK_NAME => 'random_player_01',
            LeagueOfLegends::KEY_TEAM => 'Random Team',
            LeagueOfLegends::KEY_WINNER => false,
            LeagueOfLegends::KEY_POSITION => LeagueOfLegends::POSITION_TOP,
            LeagueOfLegends::KEY_KILLS => 10,
            LeagueOfLegends::KEY_DEATHS => 1,
            LeagueOfLegends::KEY_ASSISTS => 2,
            LeagueOfLegends::KEY_DAMAGE_DEAL => 100,
            LeagueOfLegends::KEY_HEAL_DEAL => 50
        ];

        $model = new LeagueOfLegends($data);

        $this->assertEquals($data[LeagueOfLegends::KEY_NAME], $model->getName());
        $this->assertEquals($data[LeagueOfLegends::KEY_NICK_NAME], $model->getNickName());
        $this->assertEquals($data[LeagueOfLegends::KEY_TEAM], $model->getTeam());
        $this->assertEquals($data[LeagueOfLegends::KEY_WINNER], $model->isWinner());
        $this->assertEquals($data[LeagueOfLegends::KEY_POSITION], $model->getPosition());
        $this->assertEquals($data[LeagueOfLegends::KEY_KILLS], $model->getKills());
        $this->assertEquals($data[LeagueOfLegends::KEY_DEATHS], $model->getDeaths());
        $this->assertEquals($data[LeagueOfLegends::KEY_ASSISTS], $model->getAssists());
        $this->assertEquals($data[LeagueOfLegends::KEY_DAMAGE_DEAL], $model->getDamageDeal());
        $this->assertEquals($data[LeagueOfLegends::KEY_HEAL_DEAL], $model->getHealDeal());
    }

    public function testPointsAreCalculatedCorrectly(): void
    {
        $data = [
            LeagueOfLegends::KEY_NAME => 'Random Player #01',
            LeagueOfLegends::KEY_NICK_NAME => 'random_player_01',
            LeagueOfLegends::KEY_TEAM => 'Random Team',
            LeagueOfLegends::KEY_WINNER => false,
            LeagueOfLegends::KEY_POSITION => LeagueOfLegends::POSITION_TOP,
            LeagueOfLegends::KEY_KILLS => 10,
            LeagueOfLegends::KEY_DEATHS => 1,
            LeagueOfLegends::KEY_ASSISTS => 2,
            LeagueOfLegends::KEY_DAMAGE_DEAL => 100,
            LeagueOfLegends::KEY_HEAL_DEAL => 50
        ];
        // ( Kills + Assists ) / Deaths
        // + DamageDeal * PositionDamageFactorMultiplier
        // + HealDeal + PositionHealFactorMultiplier
        $expectedPoints = (10 + 2) / 1 + 100 * 0.03 + 50 * 0.01; // 15.50

        $model = new LeagueOfLegends($data);

        $this->assertEquals($expectedPoints, $model->getPoints());
    }

    public function testWinnerTeamHas10ExtraPoints(): void
    {
        $winner = $loser = [
            LeagueOfLegends::KEY_NAME => 'Random Player #02',
            LeagueOfLegends::KEY_NICK_NAME => 'random_player_02',
            LeagueOfLegends::KEY_TEAM => 'Winner Team',
            LeagueOfLegends::KEY_WINNER => true,
            LeagueOfLegends::KEY_POSITION => LeagueOfLegends::POSITION_TOP,
            LeagueOfLegends::KEY_KILLS => 10,
            LeagueOfLegends::KEY_DEATHS => 1,
            LeagueOfLegends::KEY_ASSISTS => 0,
            LeagueOfLegends::KEY_DAMAGE_DEAL => 0,
            LeagueOfLegends::KEY_HEAL_DEAL => 0
        ];
        $loser[LeagueOfLegends::KEY_WINNER] = false;

        $modelWinner = new LeagueOfLegends($winner);
        $modelLoser = new LeagueOfLegends($loser);

        $this->assertEquals(10, $modelWinner->getPoints() - $modelLoser->getPoints());
    }
}
