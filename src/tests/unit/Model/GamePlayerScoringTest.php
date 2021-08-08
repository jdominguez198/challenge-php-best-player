<?php

declare(strict_types=1);

use ChallengeBestPlayer\Model\GamePlayerScoring;
use PHPUnit\Framework\TestCase;

class GamePlayerScoringTest extends TestCase {

    public function testTotalPointsCalculationIsCorrect(): void
    {
        $playerScore = new GamePlayerScoring();

        $playerScore
            ->addGamePoints('FIRST_GAME', 100)
            ->addGamePoints('SECOND_GAME', 70)
            ->addGamePoints('THIRD_GAME', 30);

        $this->assertEquals(200, $playerScore->getTotalPoints());
    }
}
