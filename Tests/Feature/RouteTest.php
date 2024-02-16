<?php

declare(strict_types=1);

/**
 * https://devdojo.com/devdojo/simple-laravel-route-testing.
 */

namespace Modules\Xot\Tests\Feature;

use Illuminate\Support\Facades\App;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * A basic test example.
<<<<<<< HEAD
     */
    #[Test]
    public function routes(): void
=======
     *
     * @return void
     *
     * @test
     */
    public function routes()
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        // dddx('/'.App::getlocale().'/home');

        $appURL = env('APP_URL');

        $urls = [
            '/',
            // '/'.App::getlocale().'/',
            // '/home',
            // '/'.App::getlocale().'/home', //questo url mi da errore
        ];

        echo PHP_EOL;

        foreach ($urls as $url) {
            $response = $this->get($url);
            if (200 !== $response->status()) {
                echo $appURL.$url.' (FAILED) did not return a 200.';
                static::assertTrue(false);
            } else {
                echo $appURL.$url.' (success ?)';
                static::assertTrue(true);
            }

            echo PHP_EOL;
        }
    }
}
