<?php

declare(strict_types=1);

use ChallengeBestPlayer\Api\GamePlayerInterface;
use PHPUnit\Framework\TestCase;

class GamePlayerFactoryTest extends TestCase {

    public function testFactoryCanCreateKnownModel(): void
    {
        $modelName = 'VALORANT';
        $data = [
            GamePlayerInterface::KEY_NAME => 'Random Player #01',
            GamePlayerInterface::KEY_NICK_NAME => 'random_player_01',
            GamePlayerInterface::KEY_TEAM => 'Random Team',
            GamePlayerInterface::KEY_KILLS => 10,
            GamePlayerInterface::KEY_DEATHS => 1,
        ];
        $factory = new \ChallengeBestPlayer\Model\GamePlayerFactory();

        $model = $factory->create($modelName, $data);

        $this->assertEquals($modelName, $model->getGame());
    }

    public function testFactoryCantCreateUnknownModel(): void
    {
        $modelName = 'RANDOM_UNKNOWN_GAME';
        $data = [
            GamePlayerInterface::KEY_NAME => 'Random Player #01',
            GamePlayerInterface::KEY_NICK_NAME => 'random_player_01',
            GamePlayerInterface::KEY_TEAM => 'Random Team',
            GamePlayerInterface::KEY_KILLS => 10,
            GamePlayerInterface::KEY_DEATHS => 1,
        ];
        $factory = new \ChallengeBestPlayer\Model\GamePlayerFactory();
        $expectedExceptionMessage = sprintf('Can\'t create Model. Game "%s" not found!', $modelName);

        try {
            $model = $factory->create($modelName, $data);
            $this->fail('Exception not thrown!');
        } catch (\Exception $e) {
            $this->assertEquals($expectedExceptionMessage, $e->getMessage());
        }
    }
}
