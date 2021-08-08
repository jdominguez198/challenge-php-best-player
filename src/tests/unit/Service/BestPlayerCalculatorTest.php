<?php

declare(strict_types=1);

use ChallengeBestPlayer\Model\GamePlayerFactory;
use ChallengeBestPlayer\Service\BestPlayerCalculator;
use PHPUnit\Framework\TestCase;

class BestPlayerCalculatorTest extends TestCase {

    public function testCalculationWorksWithOnePlayer(): void
    {
        $bestPlayerCalculatorService = new BestPlayerCalculator();
        $factoryPlayer = new GamePlayerFactory();
        $randomPlayer = $factoryPlayer->create(
            'VALORANT',
            [
                'Random Player #01',
                'Random Nick #01',
                'Random Team',
                10,
                1
            ]
        );
        $players = [ $randomPlayer ];

        $bestPlayer = $bestPlayerCalculatorService->execute($players);

        $this->assertEquals($bestPlayer->getNickName(), $randomPlayer->getNickName());
    }

    public function testCalculationWorksWithMultiplePlayer(): void
    {
        $bestPlayerCalculatorService = new BestPlayerCalculator();
        $factoryPlayer = new GamePlayerFactory();
        $randomPlayer01 = $factoryPlayer->create(
            'VALORANT',
            [
                'Random Player #01',
                'Random Nick #01',
                'Random Team',
                10,
                1
            ]
        );
        $randomPlayer02 = $factoryPlayer->create(
            'VALORANT',
            [
                'Random Player #02',
                'Random Nick #02',
                'Random Team',
                10,
                2
            ]
        );
        $randomPlayer03 = $factoryPlayer->create(
            'VALORANT',
            [
                'Random Player #03',
                'Random Nick #03',
                'Random Team',
                10,
                5
            ]
        );
        $players = [ $randomPlayer01, $randomPlayer02, $randomPlayer03 ];

        $bestPlayer = $bestPlayerCalculatorService->execute($players);

        $this->assertEquals($bestPlayer->getNickName(), $randomPlayer01->getNickName());
    }

    public function testCalculationWorksWithMultiplePlayerInDifferentGames(): void
    {
        $bestPlayerCalculatorService = new BestPlayerCalculator();
        $factoryPlayer = new GamePlayerFactory();
        $randomPlayer01Game01 = $factoryPlayer->create(
            'VALORANT',
            [
                'Random Player #01',
                'Random Nick #01',
                'Random Team',
                10,
                1,
            ]
        );
        $randomPlayer01Game02 = $factoryPlayer->create(
            'LEAGUE OF LEGENDS',
            [
                'Random Player #01',
                'Random Nick #01',
                'Random Team',
                false,
                'J',
                100,
                5,
                2,
                2000,
                1000,
            ]
        );
        $randomPlayer02Game01 = $factoryPlayer->create(
            'VALORANT',
            [
                'Random Player #02',
                'Random Nick #02',
                'Random Team',
                10,
                2,
            ]
        );
        $randomPlayer02Game02 = $factoryPlayer->create(
            'LEAGUE OF LEGENDS',
            [
                'Random Player #02',
                'Random Nick #02',
                'Random Team',
                true,
                'S',
                10,
                9,
                10,
                5000,
                100,
            ]
        );
        $randomPlayer03Game01 = $factoryPlayer->create(
            'VALORANT',
            [
                'Random Player #03',
                'Random Nick #03',
                'Random Team',
                10,
                5,
            ]
        );
        $randomPlayer03Game02 = $factoryPlayer->create(
            'LEAGUE OF LEGENDS',
            [
                'Random Player #03',
                'Random Nick #03',
                'Random Team',
                false,
                'T',
                100,
                5,
                1,
                3000,
                1000,
            ]
        );
        $players = [
            $randomPlayer01Game01,
            $randomPlayer01Game02,
            $randomPlayer02Game01,
            $randomPlayer02Game02,
            $randomPlayer03Game01,
            $randomPlayer03Game02,
        ];

        $bestPlayer = $bestPlayerCalculatorService->execute($players);

        $this->assertEquals($bestPlayer->getNickName(), $randomPlayer03Game01->getNickName());
    }
}
