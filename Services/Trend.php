<?php

declare(strict_types=1);

namespace Modules\Xot\Services;

use Carbon\CarbonPeriod;
use Error;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Xot\Datas\TrendData;
use Modules\Xot\Services\Trend\Adapters\MySqlAdapter;
use Modules\Xot\Services\Trend\Adapters\PgsqlAdapter;
use Modules\Xot\Services\Trend\Adapters\SqliteAdapter;

class Trend
{
    public string $interval;

    public Carbon $start;

    public Carbon $end;

    public string $dateColumn = 'created_at';

    public string $dateAlias = 'date';

    public function __construct(public Builder $builder)
    {
    }

    public static function query(Builder $builder): self
    {
        return new self($builder);
    }

    public static function model(string $model): self
    {
        return new self($model::query());
    }

    public function between(Carbon $start, Carbon $end): self
    {
        $this->start = $start;
        $this->end = $end;

        return $this;
    }

    public function interval(string $interval): self
    {
        $this->interval = $interval;

        return $this;
    }

    public function perMinute(): self
    {
        return $this->interval('minute');
    }

    public function perHour(): self
    {
        return $this->interval('hour');
    }

    public function perDay(): self
    {
        return $this->interval('day');
    }

    public function perMonth(): self
    {
        return $this->interval('month');
    }

    public function perYear(): self
    {
        return $this->interval('year');
    }

    public function dateColumn(string $column): self
    {
        $this->dateColumn = $column;

        return $this;
    }

    public function dateAlias(string $alias): self
    {
        $this->dateAlias = $alias;

        return $this;
    }

    public function aggregate(string $column, string $aggregate): Collection
    {
        $values = $this->builder
            ->toBase()
<<<<<<< HEAD
            ->selectRaw(
                "
                {$this->getSqlDate()} as {$this->dateAlias},
                {$aggregate}({$column}) as aggregate
            "
            )
=======
            ->selectRaw("
                {$this->getSqlDate()} as {$this->dateAlias},
                {$aggregate}({$column}) as aggregate
            ")
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
            ->whereBetween($this->dateColumn, [$this->start, $this->end])
            ->groupBy($this->dateAlias)
            ->orderBy($this->dateAlias)
            ->get();

        return $this->mapValuesToDates($values);
    }

    public function average(string $column): Collection
    {
        return $this->aggregate($column, 'avg');
    }

    public function min(string $column): Collection
    {
        return $this->aggregate($column, 'min');
    }

    public function max(string $column): Collection
    {
        return $this->aggregate($column, 'max');
    }

    public function sum(string $column): Collection
    {
        return $this->aggregate($column, 'sum');
    }

    public function count(string $column = '*'): Collection
    {
        return $this->aggregate($column, 'count');
    }

    public function mapValuesToDates(Collection $values): Collection
    {
        /*
        $values = $values->map(fn ($value) => new TrendValue(
            date: $value->{$this->dateAlias},
            aggregate: $value->aggregate,
        ));

        $placeholders = $this->getDatePeriod()->map(
            fn (Carbon $date) => new TrendValue(
                date: $date->format($this->getCarbonDateFormat()),
                aggregate: 0,
            )
        );
        */

        // Cannot access property $aggregate on mixed.
<<<<<<< HEAD
        $values = $values->map(
            fn ($value): TrendData => TrendData::from(
                [
                    'date' => $value->{$this->dateAlias},
                    'aggregate' => $value->aggregate,
                ]
            )
        );
=======
        $values = $values->map(fn ($value) => TrendData::from([
            'date' => $value->{$this->dateAlias},
            'aggregate' => $value->aggregate,
        ]
        ));
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a

        // Parameter #1 $callback of method Illuminate\Support\Collection<(int|string),mixed>::map()
        // expects callable(mixed, (int|string)): Modules\Xot\Datas\TrendData,
        // Closure(Illuminate\Support\Carbon): Modules\Xot\Datas\TrendData given
        $placeholders = $this->getDatePeriod()
            ->map(
<<<<<<< HEAD
                fn (Carbon $carbon): TrendData => TrendData::from(
                    [
                        'date' => $carbon->format($this->getCarbonDateFormat()),
                        'aggregate' => 0,
                    ]
=======
                fn (Carbon $date) => TrendData::from([
                    'date' => $date->format($this->getCarbonDateFormat()),
                    'aggregate' => 0,
                ]
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
                )
            );

        return $values
            ->merge($placeholders)
            ->unique('date')
            ->sort()
            ->flatten();
    }

<<<<<<< HEAD
    private function getDatePeriod(): Collection
=======
    protected function getDatePeriod(): Collection
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        /*
        160    Unable to resolve the template type TKey in call to function collect
         💡 See: https://phpstan.org/blog/solving-phpstan-error-unable-to-resolve-template-type
        161    Parameter #1 $value of function collect expects
         Illuminate\Contracts\Support\Arrayable<(int|string),
         Carbon\CarbonInterface|null>|iterable<(int|string),
         Carbon\CarbonInterface|null>|null, Carbon\CarbonPeriod given.
         */
        return collect(
            CarbonPeriod::between(
                $this->start,
                $this->end,
<<<<<<< HEAD
            )->interval('1 '.$this->interval)
        );
    }

    private function getSqlDate(): string
=======
            )->interval("1 {$this->interval}")
        );
    }

    protected function getSqlDate(): string
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        // Call to an undefined method Illuminate\Database\ConnectionInterface::getDriverName(
        $adapter = match ($this->builder->getConnection()->getDriverName()) {
            'mysql' => new MySqlAdapter(),
            'sqlite' => new SqliteAdapter(),
            'pgsql' => new PgsqlAdapter(),
            default => throw new \Error('Unsupported database driver.'),
        };

        return $adapter->format($this->dateColumn, $this->interval);
    }

<<<<<<< HEAD
    private function getCarbonDateFormat(): string
=======
    protected function getCarbonDateFormat(): string
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return match ($this->interval) {
            'minute' => 'Y-m-d H:i:00',
            'hour' => 'Y-m-d H:00',
            'day' => 'Y-m-d',
            'month' => 'Y-m',
            'year' => 'Y',
            default => throw new \Error('Invalid interval.'),
        };
    }
}
