<?php

declare(strict_types=1);

use ChallengeBestPlayer\Service\CsvImporter;
use ChallengeBestPlayer\Service\DataSource;
use PHPUnit\Framework\TestCase;

class DataSourceTest extends TestCase {

    public function testThrowsExceptionIfSourceDirectoryDoesNotExists(): void
    {
        $mockCsvImporter = $this->createMock(CsvImporter::class);
        $options = [
            'sourceDirectory' => '/tmp/incorrect-random-directory-12345/',
            'inputFolder' => '',
        ];
        $dataSource = new DataSource($mockCsvImporter);
        $exceptionMessage = sprintf(
            DataSource::ERROR_DIRECTORY_NOT_FOUND,
            $options['sourceDirectory']
        );

        try {
            $dataSource->load($options);
            $this->fail('Exception was not thrown!');
        } catch (\Exception $e) {
            $this->assertEquals($exceptionMessage, $e->getMessage());
        }
    }

    public function testMockFilesAreProcessedSuccessfully(): void
    {
        $mockCsvImporter = $this->createMock(CsvImporter::class);
        $mockCsvImporter
            ->expects($this->any())
            ->method('loadFile')
            ->willReturn([]);
        $dataSource = new DataSource($mockCsvImporter);
        // Look in /tmp dir. I don't care what files are there
        $options = [
            'sourceDirectory' => sys_get_temp_dir(),
            'inputFolder' => ''
        ];

        $result = $dataSource->load($options);

        $this->assertIsArray($result);
    }
}
