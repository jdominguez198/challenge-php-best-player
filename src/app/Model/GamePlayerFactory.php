<?php

declare(strict_types=1);

namespace ChallengeBestPlayer\Model;

use ChallengeBestPlayer\Api\GamePlayerInterface;
use ChallengeBestPlayer\Model\Games\LeagueOfLegends;
use ChallengeBestPlayer\Model\Games\Valorant;

class GamePlayerFactory {
    protected array $modelMappings = [
      'LEAGUE OF LEGENDS' => LeagueOfLegends::class,
      'VALORANT' => Valorant::class,
    ];

    /**
     * @throws \Exception
     */
    public function create(string $model, array $data = []): GamePlayerInterface
    {
        if (!array_key_exists($model, $this->modelMappings)) {
            throw new \Exception(sprintf('Can\'t create Model. Game "%s" not found!', $model));
        }

        /** @var GamePlayerInterface $className */
        $className = $this->modelMappings[$model];
        $classProperties = $className::$keyProperties;

        if (count($data) !== count($classProperties)) {
            throw new \Exception(sprintf('Required number of properties for "%s" are not matching', $model));
        }

        $reduction = array_reduce($classProperties, function ($output, $item) use ($data) {
            $output['data'][$item] = $data[$output['index']];
            $output['index']++;

            return $output;
        }, [ 'data' => [], 'index' => 0 ]);

        return new $className($reduction['data']);
    }
}
