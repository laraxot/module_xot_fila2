<?php
/**
 * @see https://medium.com/technology-hits/how-to-import-a-csv-excel-file-in-laravel-d50f93b98aa4
 */

declare(strict_types=1);

namespace Modules\Xot\Services;

use Illuminate\Support\Collection;

use function Safe\file;

/**
 * Class CSVService.
 */
final class CSVService
{
    private static ?self $instance = null;
    

    public function __construct()
    {
        // ---
        // require_once __DIR__.'/vendor/autoload.php';
    }

    /**
     * Undocumented function.
     */
    public static function getInstance(): self
    {
        if (!self::$instance instanceof \Modules\Xot\Services\CSVService) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Undocumented function.
     */
    public static function make(): self
    {
        return static::getInstance();
    }

    /**
     * Undocumented function.
     */
    public static function toArray(string $filename): array
    {
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        // if (false === $lines) {
        //    throw new \Exception('['.__LINE__.']['.class_basename(__CLASS__).']');
        // }
        $csv = [];
        foreach ($lines as $key => $value) {
            $csv[$key] = str_getcsv($value);
        }

        return $csv;
    }
}
