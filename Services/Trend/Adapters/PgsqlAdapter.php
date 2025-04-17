<?php

declare(strict_types=1);

namespace Modules\Xot\Services\Trend\Adapters;

class PgsqlAdapter extends AbstractAdapter
{
    public function format(string $column, string $interval): string
    {
        $format = match ($interval) {
            'minute' => 'YYYY-MM-DD HH24:MI:00',
            'hour' => 'YYYY-MM-DD HH24:00:00',
            'day' => 'YYYY-MM-DD',
            'month' => 'YYYY-MM',
            'year' => 'YYYY',
            default => throw new \Error('Invalid interval.'),
        };

<<<<<<< HEAD
        return sprintf('to_char(%s, \'%s\')', $column, $format);
=======
        return "to_char({$column}, '{$format}')";
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }
}
