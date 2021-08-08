<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Utils/PascalCaseString.php';

use ChallengeBestPlayer\App;

function processParameters (array $parameters = []): array {
    // Remove first argument, it's the script name
    array_shift($parameters);
    $options = [];

    foreach ($parameters as $parameter) {
        [ $key, $value ] = explode('=', $parameter);
        if ($value === '') {
            continue;
        }

        $cleanKey = str_replace('--', '', trim($key));
        $options[toPascalCase($cleanKey)] = $value;
    }

    return $options;
}

$app = new App();
$app->execute(processParameters($argv));
