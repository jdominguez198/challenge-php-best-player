<?php

declare(strict_types=1);

namespace ChallengeBestPlayer\Model\Games;

use ChallengeBestPlayer\Model\AbstractGamePlayer;

class LeagueOfLegends extends AbstractGamePlayer {
    const KEY_WINNER = 'winner';
    const KEY_POSITION = 'position';
    const KEY_ASSISTS = 'assists';
    const KEY_DAMAGE_DEAL = 'damageDeal';
    const KEY_HEAL_DEAL = 'healDeal';

    const POSITION_TOP = 'T';
    const POSITION_BOTTOM = 'B';
    const POSITION_MID = 'M';
    const POSITION_JUNGLE = 'J';
    const POSITION_SUPPORT = 'S';

    public static array $keyProperties = [
        self::KEY_NAME,
        self::KEY_NICK_NAME,
        self::KEY_TEAM,
        self::KEY_WINNER,
        self::KEY_POSITION,
        self::KEY_KILLS,
        self::KEY_DEATHS,
        self::KEY_ASSISTS,
        self::KEY_DAMAGE_DEAL,
        self::KEY_HEAL_DEAL,
    ];

    protected array $damageDealMapping = [
        self::POSITION_TOP => 0.03,
        self::POSITION_BOTTOM => 0.03,
        self::POSITION_MID => 0.03,
        self::POSITION_JUNGLE => 0.02,
        self::POSITION_SUPPORT => 0.01,
    ];

    protected array $healDealMapping = [
        self::POSITION_TOP => 0.01,
        self::POSITION_BOTTOM => 0.01,
        self::POSITION_MID => 0.01,
        self::POSITION_JUNGLE => 0.02,
        self::POSITION_SUPPORT => 0.03,
    ];

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->data[self::KEY_WINNER] = (bool) $data[self::KEY_WINNER] ?? null;
        $this->data[self::KEY_POSITION] = $data[self::KEY_POSITION] ?? null;
        $this->data[self::KEY_ASSISTS] = (int) $data[self::KEY_ASSISTS] ?? 0;
        $this->data[self::KEY_DAMAGE_DEAL] = (int) $data[self::KEY_DAMAGE_DEAL] ?? 0;
        $this->data[self::KEY_HEAL_DEAL] = (int) $data[self::KEY_HEAL_DEAL] ?? 0;
    }

    public function getGame(): string
    {
        return 'LEAGUE OF LEGENDS';
    }

    public function isWinner(): bool
    {
        return $this->data[self::KEY_WINNER];
    }

    public function getPosition(): string
    {
        return $this->data[self::KEY_POSITION];
    }

    public function getAssists(): int
    {
        return $this->data[self::KEY_ASSISTS];
    }

    public function getDamageDeal(): int
    {
        return $this->data[self::KEY_DAMAGE_DEAL];
    }

    public function getHealDeal(): int
    {
        return $this->data[self::KEY_HEAL_DEAL];
    }

    public function getDamageDealCalculated(): float
    {
        if (!array_key_exists($this->getPosition(), $this->damageDealMapping)) {
            return 0.0;
        }

        return $this->getDamageDeal() * $this->damageDealMapping[$this->getPosition()];
    }

    public function getHealDealCalculated(): float
    {
        if (!array_key_exists($this->getPosition(), $this->healDealMapping)) {
            return 0.0;
        }

        return $this->getHealDeal() * $this->healDealMapping[$this->getPosition()];
    }

    public function getPoints(): float
    {
        if ($this->getDeaths() === 0) {
            return 0.0;
        }

        $kdaPoints = ($this->getKills() + $this->getAssists()) / $this->getDeaths();
        $damagePoints = $this->getDamageDealCalculated();
        $healPoints = $this->getHealDealCalculated();
        $teamWinnerPoints = $this->isWinner() ? 10 : 0;

        return $kdaPoints + $damagePoints + $healPoints + $teamWinnerPoints;
    }
}
