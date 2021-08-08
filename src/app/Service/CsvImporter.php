<?php

declare(strict_types=1);

namespace ChallengeBestPlayer\Service;

class CsvImporter {
    /**
     * @throws \Exception
     */
    public function loadFile (string $file, $separator = null): array
    {
        if (!file_exists($file)) {
            throw new \Exception(sprintf('File "%s" not found!', $file));
        }

        return array_map(function ($content) use ($separator) {
            return str_getcsv($content, $separator);
        }, file($file));
    }
}
