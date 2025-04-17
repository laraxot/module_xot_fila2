<?php

declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Support\Str;
use samdark\sitemap\Sitemap;
use TightenCo\Jigsaw\Jigsaw;

class GenerateSitemap
{
    protected $exclude = [
        '/assets/*',
        '*/favicon.ico',
        '*/404',
    ];

    public function handle(Jigsaw $jigsaw): void
    {
        $baseUrl = $jigsaw->getConfig('baseUrl');

        if (! $baseUrl) {
            echo "\nTo generate a sitemap.xml file, please specify a 'baseUrl' in config.php.\n\n";

            return;
        }

        $sitemap = new Sitemap($jigsaw->getDestinationPath().'/sitemap.xml');

        collect($jigsaw->getOutputPaths())
<<<<<<< HEAD
            ->reject(
                function ($path) {
                    return $this->isExcluded($path);
                }
            )->each(
                function ($path) use ($baseUrl, $sitemap): void {
                    $sitemap->addItem(rtrim($baseUrl, '/').$path, time(), Sitemap::DAILY);
                }
            );
=======
            ->reject(function ($path) {
                return $this->isExcluded($path);
            })->each(
                function ($path) use ($baseUrl, $sitemap) {
                    $sitemap->addItem(rtrim($baseUrl, '/').$path, time(), Sitemap::DAILY);
                });
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
        $sitemap->write();
    }

    public function isExcluded($path)
    {
        return Str::is($this->exclude, $path);
    }
}
