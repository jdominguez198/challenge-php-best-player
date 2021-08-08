<?php

declare(strict_types=1);

use ChallengeBestPlayer\Service\CsvImporter;
use PHPUnit\Framework\TestCase;

class CsvImportTest extends TestCase {

    const MOCK_FILE_OK = '/tmp/challenge-php-best-player-mock.csv';
    const MOCK_FILE_ERROR = '/tmp/challenge-php-best-player-error.csv';

    protected CsvImporter $csvImporter;

    protected function setUp(): void
    {
        $this->csvImporter = new CsvImporter();
        file_put_contents(self::MOCK_FILE_OK, '');
    }

    public function testCanLoadFile(): void
    {
        $filePath = self::MOCK_FILE_OK;

        $file = $this->csvImporter->loadFile($filePath);

        $this->assertIsArray($file);
    }

    public function testThrowExceptionIfFileDoesNotExists(): void
    {
        $filePath = self::MOCK_FILE_ERROR;
        $exceptionMessage = sprintf('File "%s" not found!', $filePath);

        try {
            $file = $this->csvImporter->loadFile($filePath);
            $this->fail('Exception was not thrown!');
        } catch (\Exception $e) {
            $this->assertEquals($exceptionMessage, $e->getMessage());
        }
    }
}
