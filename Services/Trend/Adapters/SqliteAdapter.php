<?php

declare(strict_types=1);

namespace Modules\Xot\Services\Trend\Adapters;

class SqliteAdapter extends AbstractAdapter
{
    public function format(string $column, string $interval): string
    {
        $format = match ($interval) {
            'minute' => '%Y-%m-%d %H:%M:00',
            'hour' => '%Y-%m-%d %H:00',
            'day' => '%Y-%m-%d',
            'month' => '%Y-%m',
            'year' => '%Y',
            default => throw new \Error('Invalid interval.'),
        };

<<<<<<< HEAD
        return sprintf('strftime(\'%s\', %s)', $format, $column);
=======
        return "strftime('{$format}', {$column})";
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }
}
