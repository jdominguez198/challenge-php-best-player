<?php

require_once __DIR__ . '/vendor/autoload.php';

use ChallengeBestPlayer\App;

$options = [
    'inputFolder' => 'challenge-csv-files',
];

if (isset($argv[1]) && !empty($argv[1])) {
    $options['inputFolder'] = $argv[1];
}

$app = new App();
$app->execute($options);
