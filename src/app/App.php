<?php

declare(strict_types=1);

namespace ChallengeBestPlayer;

use ChallengeBestPlayer\Model\BestPlayer;
use ChallengeBestPlayer\Model\GamePlayerFactory;
use ChallengeBestPlayer\Service\DataSource;

class App {
    protected const ERROR_PROCESSING_FILES = 1001;
    protected const ERROR_WRONG_FORMAT_FILES = 1002;

    protected DataSource $dataSource;
    protected GamePlayerFactory $playerFactory;
    protected BestPlayer $bestPlayer;

    public function __construct()
    {
        $this->dataSource = new DataSource();
        $this->playerFactory = new GamePlayerFactory();
        $this->bestPlayer = new BestPlayer();
    }

    public function execute(array $options = []): void
    {
        echo sprintf('%sWelcome to Best e-Sports player Calculator!%s%s', PHP_EOL, PHP_EOL, PHP_EOL);

        $fileSets = [];

        try {
            $fileSets = $this->dataSource->load([
                DataSource::KEY_SOURCE_DIRECTORY => $options['sourceDirectory'] ?? null,
                DataSource::KEY_INPUT_FOLDER => $options['inputFolder'] ?? null,
                DataSource::KEY_CSV_SEPARATOR => $options['csvSeparator'] ?? null,
            ]);
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit(self::ERROR_PROCESSING_FILES);
        }

        $playerStats = $this->buildPlayerStats($fileSets);

        if (count($playerStats['errors']) > 0) {
            $this->printErrors($playerStats['errors']);

            exit(self::ERROR_WRONG_FORMAT_FILES);
        }

        $this->printBestPlayer($playerStats['stats']);

        echo PHP_EOL;
    }

    protected function buildPlayerStats(array $content): array
    {
        $errors = [];
        $playerStats = [];

        foreach ($content as $contentFile) {
            if (count($contentFile[0]) !== 1) {
                continue;
            }

            $firstLine = array_shift($contentFile);
            $game = $firstLine[0];

            foreach ($contentFile as $index => $player) {
                try {
                    $playerStats[] = $this->playerFactory->create($game, $player);;
                } catch (\Exception $e) {
                    $errors[$game][] = sprintf(
                        'Received error when adding row "%s": %s',
                        $index + 1,
                        $e->getMessage()
                    );
                }
            }
        }

        return [
            'stats' => $playerStats,
            'errors' => $errors,
        ];
    }

    protected function printErrors(array $errors): void
    {
        echo sprintf(
            'The Best Player of all games can\'t be calculated due to errors on input files. These are:%s%s',
            PHP_EOL,
            PHP_EOL
        );

        foreach ($errors as $game => $inputErrors) {
            if (count($inputErrors) > 0) {
                echo sprintf(
                    'File stats for game "%s" has following errors: %s%s%s%s',
                    $game,
                    PHP_EOL,
                    implode(PHP_EOL, $inputErrors),
                    PHP_EOL,
                    PHP_EOL
                );
                continue;
            }

            echo sprintf(
                'File stats for game "%s" has correct format.%s',
                $game,
                PHP_EOL
            );
        }
    }

    protected function printBestPlayer(array $playerStats): void
    {
        echo sprintf('Best e-Sport Player:%s%s', PHP_EOL, PHP_EOL);

        $bestPlayer = $this->bestPlayer->execute($playerStats);
        echo sprintf(
            'Player "%s" from team "%s" is the WINNER with "%s" points:%s',
            $bestPlayer['name'],
            $bestPlayer['team'],
            $bestPlayer['total'],
            PHP_EOL
        );
        foreach ($bestPlayer['points'] as $game => $result) {
            echo sprintf(
                '- Points in "%s": %s%s',
                $game,
                $result,
                PHP_EOL
            );
        }

        echo PHP_EOL;
    }
}
