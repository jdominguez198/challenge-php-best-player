<?php

declare(strict_types=1);

namespace ChallengeBestPlayer\Service;

class CsvImporter {
    /**
     * @throws \Exception
     */
    public function loadFile (string $file): array
    {
        if (!file_exists($file)) {
            throw new \Exception(sprintf('File "%s" not found!', $file));
        }

        return array_map(function ($content) {
            return str_getcsv($content, ';');
        }, file($file));
    }
}
