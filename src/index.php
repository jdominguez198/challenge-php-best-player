<?php

require_once __DIR__ . '/vendor/autoload.php';

use ChallengeBestPlayer\App;

$options = [
    'sourceDirectory' => empty($_ENV['SOURCE_DIRECTORY']) ? null : $_ENV['SOURCE_DIRECTORY'],
    'inputFolder' => empty($_ENV['INPUT_FOLDER']) ? null : $_ENV['INPUT_FOLDER'],
    'csvSeparator' => empty($_ENV['CSV_SEPARATOR']) ? null : $_ENV['CSV_SEPARATOR'],
];

$app = new App();
$app->execute($options);
