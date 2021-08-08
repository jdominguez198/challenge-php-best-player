<?php

declare(strict_types=1);

namespace ChallengeBestPlayer;

use ChallengeBestPlayer\Model\GamePlayerFactory;
use ChallengeBestPlayer\Service\BestPlayerCalculator;
use ChallengeBestPlayer\Service\DataSource;

class App {
    const ERROR_PROCESSING_FILES = 'Error processing files';
    const ERROR_WRONG_FORMAT_FILES = 'Error wrong files format';
    const ERROR_NO_PLAYERS = 'Error empty file sets';

    protected DataSource $dataSource;
    protected GamePlayerFactory $playerFactory;
    protected BestPlayerCalculator $bestPlayerCalculator;

    public function __construct(
        DataSource $dataSource = null,
        GamePlayerFactory $gamePlayerFactory = null,
        BestPlayerCalculator $bestPlayerCalculator = null
    )
    {
        $this->dataSource = $dataSource ?? new DataSource();
        $this->playerFactory = $gamePlayerFactory ?? new GamePlayerFactory();
        $this->bestPlayerCalculator = $bestPlayerCalculator ?? new BestPlayerCalculator();
    }

    /**
     * @param array $options
     */
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
            throw new \RuntimeException(self::ERROR_PROCESSING_FILES);
        }

        if (count($fileSets) === 0) {
            throw new \RuntimeException(self::ERROR_NO_PLAYERS);
        }

        $playerStats = $this->populatePlayerStats($fileSets);

        if (count($playerStats['errors']) > 0) {
            $this->printErrors($playerStats['errors']);

            throw new \RuntimeException(self::ERROR_WRONG_FORMAT_FILES);
        }

        $this->printBestPlayer($playerStats['stats']);

        echo PHP_EOL;
    }

    /**
     * @param array $content
     * @return array
     */
    protected function populatePlayerStats(array $content): array
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

    /**
     * @param array $errors
     */
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

    /**
     * @param array $playerStats
     */
    protected function printBestPlayer(array $playerStats): void
    {
        echo sprintf('Best e-Sport Player:%s%s', PHP_EOL, PHP_EOL);

        $bestPlayer = $this->bestPlayerCalculator->execute($playerStats);
        echo sprintf(
            'Player "%s (%s)" is the WINNER with "%s" points:%s',
            $bestPlayer->getName(),
            $bestPlayer->getNickName(),
            $bestPlayer->getTotalPoints(),
            PHP_EOL
        );
        foreach ($bestPlayer->getGamePoints() as $game => $points) {
            echo sprintf(
                '- Points in "%s": %s%s',
                $game,
                $points,
                PHP_EOL
            );
        }

        echo PHP_EOL;
    }
}
