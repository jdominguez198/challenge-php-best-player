<?php

declare(strict_types=1);

namespace ChallengeBestPlayer\Service;

class DataSource {
    const KEY_SOURCE_DIRECTORY = 'sourceDirectory';
    const KEY_INPUT_FOLDER = 'inputFolder';
    const KEY_CSV_SEPARATOR = 'csvSeparator';

    const ERROR_DIRECTORY_NOT_FOUND = 'Directory "%s" does not exists!';

    protected CsvImporter $csvImporter;

    protected array $options = [
        self::KEY_SOURCE_DIRECTORY => __DIR__ . '/../../input/',
        self::KEY_INPUT_FOLDER => 'challenge-csv-files',
        self::KEY_CSV_SEPARATOR => ';',
    ];

    public function __construct(CsvImporter $csvImporter = null)
    {
        $this->csvImporter = $csvImporter ?? new CsvImporter();
    }

    /**
     * @throws \Exception
     */
    public function load(array $newOptions = []): array
    {
        $this->loadOptions($newOptions);

        return $this->processFiles($this->getFilePaths());
    }

    /**
     * @param array $newOptions
     */
    protected function loadOptions(array $newOptions = []): void
    {
        foreach (array_keys($this->options) as $optionKey) {
            $this->options[$optionKey] = $newOptions[$optionKey] ?? $this->options[$optionKey];
        }
    }

    /**
     * @return string
     */
    protected function getSourceDirectoryPath(): string
    {
        return sprintf(
            '%s%s',
            $this->options[self::KEY_SOURCE_DIRECTORY],
            $this->options[self::KEY_INPUT_FOLDER]
        );
    }

    /**
     * @throws \Exception
     */
    protected function getFilePaths(): array
    {
        $directoryPath = $this->getSourceDirectoryPath();

        if (!is_dir($directoryPath)) {
            throw new \Exception(sprintf(self::ERROR_DIRECTORY_NOT_FOUND, $directoryPath));
        }

        return array_filter(scandir($directoryPath), function ($item) use ($directoryPath) {
            return
                !is_dir(sprintf('%s/%s', $directoryPath, $item)) &&
                pathinfo($item, PATHINFO_EXTENSION) === 'csv'
                ;
        });
    }

    /**
     * @throws \Exception
     */
    protected function processFiles(array $files): array
    {
        $directoryPath = $this->getSourceDirectoryPath();

        return array_map(function ($file) use ($directoryPath) {
            return $this->csvImporter->loadFile(
                sprintf('%s/%s', $directoryPath, $file),
                $this->options[self::KEY_CSV_SEPARATOR]
            );
        }, $files);
    }
}
