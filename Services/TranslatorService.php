<?php

declare(strict_types=1);

namespace Modules\Xot\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
// ---- services ---
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Translation\Translator as BaseTranslator;

// dddx('leggo');

/**
 * Class TranslatorService.
 */
class TranslatorService extends BaseTranslator
{
    public static function parse(array $params): array
    {
        dddx('a');
        $lang = app()->getLocale();
        extract($params);
        if (! isset($key)) {
            dddx(['err' => 'key is missing']);

            return [];
        }
<<<<<<< HEAD

=======
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
        $translator = app('translator');
        $tmp = $translator->parseKey($key);
        $namespace = $tmp[0];
        $group = $tmp[1];
        $item = $tmp[2];
        $trans = trans();
        $path = collect($trans->getLoader()->namespaces())->flip()->search($namespace);
        $filename = $path.'/'.$lang.'/'.$group.'.php';
        $filename = str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR], $filename);
<<<<<<< HEAD

        $lang_dir = \dirname($filename, 2);

        return [
            'key' => str_replace(['[', ']'], ['.', ''], (string) $key),
=======
        $lang_dir = \dirname($filename, 2);

        return [
            'key' => str_replace(['[', ']'], ['.', ''], $key),
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
            'namespace' => $namespace,
            'group' => $group,
            'ns_group' => $namespace.'::'.$group,
            'item' => $item,
            'filename' => $filename,
            'file_exists' => File::exists($filename),
            'lang_dir' => $lang_dir,
            'dir_exists' => File::exists($lang_dir), // dir without lang
        ];
    }

<<<<<<< HEAD
    public static function store(array $data): void
    {
        $data = collect($data)->map(
            static function ($v, $k) {
=======
    /**
     * @return void
     */
    public static function store(array $data)
    {
        $data = collect($data)->map(
            function ($v, $k) {
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
                $item = self::parse(['key' => $k]);
                $item['value'] = $v;

                return $item;
            }
        )
        // ->dd()
            ->filter(
<<<<<<< HEAD
                fn ($v, $k): bool => $v['dir_exists'] && \strlen((string) $v['lang_dir']) > 3
=======
                function ($v, $k) {
                    return $v['dir_exists'] && \strlen($v['lang_dir']) > 3;
                }
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
            )
            ->groupBy(['ns_group'])  // risparmio salvataggi
            ->all();
        // dddx($data);
        foreach ($data as $ns_group => $data0) {
            $rows = trans($ns_group);

            if (! \is_array($rows)) {
                // dddx($rows);  //---- dovrei leggere il file o controllarlo intanto lo blokko non voglio sovrascrivere
                $rows = [];
            }

<<<<<<< HEAD
            foreach ($data0 as $v) {
=======
            foreach ($data0 as $k => $v) {
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
                $key = Str::after($v['key'], $ns_group.'.');
                Arr::set($rows, $key, $v['value']);
            }

            $data = $rows;
            if (! isset($v)) {
                dddx(['err' => 'v is missing']);

                return;
            }
<<<<<<< HEAD

=======
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
            $filename = $v['filename'];
            // echo '<h3>['.$filename.']</h3>';
            ArrayService::save(['filename' => $filename, 'data' => $data]);
        }
    }

<<<<<<< HEAD
    public static function set(string $key, string $value): void
=======
    /**
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public static function set($key, $value)
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        $lang = app()->getLocale();
        if (trans($key) === $value) {
            return;
        } // non serve salvare

        $translator = app('translator');
        $tmp = $translator->parseKey($key);
        $namespace = $tmp[0];
        $group = $tmp[1];
        $item = $tmp[2];
        $trans = trans();
        $path = collect($trans->getLoader()->namespaces())->flip()->search($namespace);
        $filename = $path.\DIRECTORY_SEPARATOR.$lang.\DIRECTORY_SEPARATOR.$group.'.php';

        $trad = $namespace.'::'.$group;
        $rows = trans($trad);
<<<<<<< HEAD
        $item_keys = explode('.', (string) $item);
        $item_keys = implode('"]["', $item_keys);
        $item_keys = '["'.$item_keys.'"]';

        $str = '$rows'.$item_keys.'="'.$value.'";';
        try {
            eval($str); // fa schifo ma funziona
        } catch (\Exception) {
        }

=======
        $item_keys = explode('.', $item);
        $item_keys = implode('"]["', $item_keys);
        $item_keys = '["'.$item_keys.'"]';
        $str = '$rows'.$item_keys.'="'.$value.'";';
        try {
            eval($str); // fa schifo ma funziona
        } catch (\Exception $e) {
        }
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
        ArrayService::save(['data' => $rows, 'filename' => $filename]);

        Session::flash('status', 'Modifica Eseguita! ['.$filename.']');

        /*

        dddx($rows)



        dddx($item_keys);

        dddx($filename);
        */
    }

    public static function getFilePath(string $key): string
    {
        $lang = app()->getLocale();
        $translator = app('translator');
        [$namespace,$group,$item] = $translator->parseKey($key);
        $trans = trans();
        $path = collect($trans->getLoader()->namespaces())->flip()->search($namespace);
        $file_path = $path.\DIRECTORY_SEPARATOR.$lang.\DIRECTORY_SEPARATOR.$group.'.php';
<<<<<<< HEAD

        return FileService::fixPath($file_path);
=======
        $file_path = FileService::fixPath($file_path);

        return $file_path;
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }

    /**
     * Undocumented function.
<<<<<<< HEAD
     */
    public static function add(string $key, array $data): void
=======
     *
     * @return void
     */
    public static function add(string $key, array $data)
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        $file_path = self::getFilePath($key);
        $original = [];
        if (File::exists($file_path)) {
            $original = File::getRequire($file_path);
            // $original = Lang::get($key, []);
        }

        if (! \is_array($original)) {
            dddx(
                [
                    'message' => 'original is not an array',
                    'file_path' => $file_path,
                    'original' => $original,
                    // 'ori1' => File::getRequire($file_path),
                    'key' => $key,
                    'data' => $data,
                ]
            );
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }
<<<<<<< HEAD

=======
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
        $merged = collect($original)
            ->merge($data)
            ->all();

        if ($original !== $merged) {
            ArrayService::save(['data' => $merged, 'filename' => $file_path]);
            Session::flash('status', 'Modifica Eseguita! ['.$file_path.']');
        }
    }

    /**
     * Undocumented function.
<<<<<<< HEAD
     */
    public static function addMissing(string $key, array $data): void
    {
        $missing = collect($data)
            ->filter(
                static function (string $item) use ($key): bool {
=======
     *
     * @return void
     */
    public static function addMissing(string $key, array $data)
    {
        $missing = collect($data)
            ->filter(
                function ($item) use ($key) {
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
                    $k = $key.'.'.$item;
                    $v = trans($k);

                    return $k === $v;
                }
            )->all();
        $missing = array_combine($missing, $missing);
        self::add($key, $missing);
    }

    public static function getArrayTranslated(string $key, array $data): array
    {
        self::addMissing($key, $data);

<<<<<<< HEAD
        return collect($data)->map(
            static function (string $item) use ($key) {
                $k = $key.'.'.$item;

                return trans($k);
            }
        )->all();
=======
        $data = collect($data)->map(
            function ($item) use ($key) {
                $k = $key.'.'.$item;
                $v = trans($k);

                return $v;
            }
        )->all();

        return $data;
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }

    /**
     * get.
     *
     * @param string      $key
     * @param string|null $locale
     * @param bool        $fallback
     *
     * @return array|string
     */
    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        // backtrace(true);
        // trans parte da xotbasepanel riga 1109 (per ora)
        // superdump([$key, $replace , $locale , $fallback ]);

        // *
        if (null === $locale) {
            $locale = app()->getLocale();
        }
<<<<<<< HEAD

=======
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
        // */
        $translation = parent::get($key, $replace, $locale, $fallback);
        /*
        if ($key == $translation && ! Str::endsWith($key, '.')) {
            dddx(['key' => $key, 'translation' => $translation, 'replace' => $replace, 'locale' => $locale, 'fallback' => $fallback]);
        }
        indennitacondizionilavoro::servizio_esterno_reps.tab.create
        //*/

        // echo '<br>['.$key.']['.$translation.']';
        // $langs=ThemeService::__merge('langs', [$key=>$translation]);
        // $cache_key=Str::slug(req_uri().'_langs');
        // Cache::put($cache_key,$langs);
        // echo '<pre>';print_r($langs);echo '</pre>';
        /*
        if ($translation === $key) {
            Log::warning('Language item could not be found.', [
                'language' => $locale ?? config('app.locale'),
                'id' => $key,
                'url' => config('app.url')
            ]);
        }
        */

        return $translation;
    }

    /**
     * getFromJson.
     *
     * @param string      $key
     * @param string|null $locale
     *
     * @return array|string
     */
    public function getFromJson($key, array $replace = [], $locale = null)
    {
        return $this->get($key, $replace, $locale);
    }
}
