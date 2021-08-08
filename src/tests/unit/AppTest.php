<?php

declare(strict_types=1);

use ChallengeBestPlayer\App;
use ChallengeBestPlayer\Service\DataSource;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase {

    protected function setUp(): void
    {
    }

    public function testApplicationThrowsExceptionIfDataSourceTriggerException(): void
    {
        $mockDataSource = $this->createMock(DataSource::class);
        $mockDataSource
            ->expects($this->once())
            ->method('load')
            ->willThrowException(new \Exception());
        $application = new App(
            $mockDataSource,
            null,
            null
        );
        // Avoid warnings in PHPUnit due to output messages
        $this->setOutputCallback(function() {});

        try {
            $application->execute();
            $this->fail('Exception was not thrown!');
        } catch (\Exception $e) {
            $this->assertEquals(App::ERROR_PROCESSING_FILES, $e->getMessage());
        }
    }

    public function testApplicationThrowsExceptionIfDataSourceReturnEmptyFileSet(): void
    {
        $mockDataSource = $this->createMock(DataSource::class);
        $mockDataSource
            ->expects($this->once())
            ->method('load')
            ->willReturn([]);
        $application = new App(
            $mockDataSource,
            null,
            null
        );
        // Avoid warnings in PHPUnit due to output messages
        $this->setOutputCallback(function() {});

        try {
            $application->execute();
            $this->fail('Exception was not thrown!');
        } catch (\Exception $e) {
            $this->assertEquals(App::ERROR_NO_PLAYERS, $e->getMessage());
        }
    }

    public function testApplicationThrowsExceptionIfDataSourceReturnErrors(): void
    {
        $mockDataSource = $this->createMock(DataSource::class);
        $mockDataSource
            ->expects($this->once())
            ->method('load')
            ->willReturn([
                [
                    [ 'RANDOM' ],
                    [ 'WHATEVER', 'WHATEVER', 'WHATEVER' ]
                ]
            ]);
        $application = new App(
            $mockDataSource,
            null,
            null
        );
        // Avoid warnings in PHPUnit due to output messages
        $this->setOutputCallback(function() {});

        try {
            $application->execute();
            $this->fail('Exception was not thrown!');
        } catch (\Exception $e) {
            $this->assertEquals(App::ERROR_WRONG_FORMAT_FILES, $e->getMessage());
        }
    }

    public function testApplicationThrowsNoExceptionIfDataSourceReturnRightData(): void
    {
        $mockDataSource = $this->createMock(DataSource::class);
        $mockDataSource
            ->expects($this->once())
            ->method('load')
            ->willReturn([
                [
                    [ 'VALORANT' ],
                    [ 'WHATEVER', 'WHATEVER', 'WHATEVER', '10', '2' ]
                ]
            ]);
        $application = new App(
            $mockDataSource,
            null,
            null
        );
        // Avoid warnings in PHPUnit due to output messages
        $this->setOutputCallback(function() {});

        $application->execute();

        $this->isTrue();
    }
}
