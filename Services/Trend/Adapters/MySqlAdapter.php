<?php

declare(strict_types=1);

namespace Modules\Xot\Services\Trend\Adapters;

class MySqlAdapter extends AbstractAdapter
{
    public function format(string $column, string $interval): string
    {
        $format = match ($interval) {
            'minute' => '%Y-%m-%d %H:%i:00',
            'hour' => '%Y-%m-%d %H:00',
            'day' => '%Y-%m-%d',
            'month' => '%Y-%m',
            'year' => '%Y',
            default => throw new \Error('Invalid interval.'),
        };

<<<<<<< HEAD
        return sprintf('date_format(%s, \'%s\')', $column, $format);
=======
        return "date_format({$column}, '{$format}')";
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }
}
