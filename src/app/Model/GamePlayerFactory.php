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

        $modelData = array_reduce($data, function($output, $item) use ($data, $classProperties) {
            $index = array_search($item, $data);
            $output[$classProperties[$index]] = $item;

            return $output;
        }, []);

        return new $className($modelData);
    }
}
