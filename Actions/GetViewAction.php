<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Illuminate\Support\Str;
use Modules\Xot\Services\FileService;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class GetViewAction
{
    use QueueableAction;

    /**
     * PER ORA FUNZIONA SOLO CON LIVEWIRE.
     */
    public function execute(string $tpl = '', string $file0 = ''): string
    {
        if ('' == $file0) {
            $backtrace = debug_backtrace();
            $file0 = FileService::fixpath($backtrace[0]['file'] ?? '');
        }
<<<<<<< HEAD

=======
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
        $file0 = Str::after($file0, base_path());
        $arr = explode(DIRECTORY_SEPARATOR, $file0);

        if ('' == $arr[0]) {
            $arr = array_slice($arr, 1);
            $arr = array_values($arr);
        }

        $mod = $arr[1];
        $tmp = array_slice($arr, 3);

        $tmp = collect($tmp)->map(
<<<<<<< HEAD
            static function ($item) {
                $item = str_replace('.php', '', $item);

                return Str::slug(Str::snake($item));
=======
            function ($item) {
                $item = str_replace('.php', '', $item);
                $item = Str::slug(Str::snake($item));

                return $item;
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
            }
        )->implode('.');

        $view = Str::lower($mod).'::'.$tmp;
        if ('' != $tpl) {
            $view .= '.'.$tpl;
        }

        // if (inAdmin()) {
        if (Str::contains($view, '::panels.actions.')) {
            $to = '::'.(inAdmin() ? 'admin.' : '').'home.acts.';
            $view = Str::replace('::panels.actions.', $to, $view);
            $view = Str::replace('-action', '', $view);
        }
<<<<<<< HEAD

=======
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
        // }
        Assert::string($view);
        if (! view()->exists($view)) {
            throw new \Exception('View ['.$view.'] not found');
        }

        return $view;
    }
}
