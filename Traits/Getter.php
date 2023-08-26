<?php

declare(strict_types=1);

namespace Modules\Xot\Traits;

use function Safe\preg_match;

/**
 * Trait Getter.
 */
trait Getter
{
    /**
     * __merge function.
     */
    public static function __merge(string $index, array $value): array
    {
        $tmp = self::__getStatic($index);
        if (! \is_array($tmp)) {
            $tmp = [];
        }
        $tmp = array_merge($tmp, $value);
        self::__setStatic($index, $tmp);

        return $tmp;
    }

    /**
     * __getStatic function.
     */
    public static function __getStatic(string $index): mixed
    {
        if (isset(self::$vars[$index])) {
            return self::$vars[$index];
        }

        $params = [];
        $func = 'get_'.$index;
        $ris = self::$func($params);
        // dd(get_called_class());//XRA\Extend\Services\ThemeService
        // dd(class_basename(get_called_class()));//ThemeService
        $class = static::class;
        // *
        if ('' === $ris && isset($class::$config_name)) {
            $config_name = $class::$config_name;
            $ris = config($config_name.'.'.$index);
        }
        // */
        self::__setStatic($index, $ris);

        return $ris;
    }

    // end __set

    public static function __setStatic(string $index, mixed $value): void
    {
        // echo '<br/>SET ['.get_class($this).']['.$index.']['.round(memory_get_usage()/(1024*1024),2).' MB]';
        self::$vars[$index] = $value;
    }

    // end __set

    public static function __concatBeforeStatic(string $index, string $value): void
    {
        $tmp = self::__getStatic($index);
        $tmp = $value.$tmp;
        self::__setStatic($index, $tmp);
    }

    // * //se lo togli non funziona piu' le funzioni del themeservice

    public static function __callStatic(string $method, array $args): mixed
    {
        if (preg_match('/^([gs]et)([A-Z])(.*)$/', $method, $match)) {
            $reflector = new \ReflectionClass(self::class);
            $property = mb_strtolower($match[2]).$match[3];
            if ($reflector->hasProperty($property)) {
                $property = $reflector->getProperty($property);
                switch ($match[1]) {
                    case 'get':
                        return $property->getValue();
                    case 'set':
                        return $property->setValue($args[0]);
                }
            } else {
                throw new \InvalidArgumentException("Property {$property} doesn't exist");
            }
        }
    }

    // */

    public function __isset(string $index): bool
    {
        return isset($this->vars[$index]);
    }

    public function __concat(string $index, string $value): void
    {
        $tmp = $this->__get($index);
        $tmp .= $value;
        $this->__set($index, $tmp);
    }

    /**
     * set undefined vars.
     */
    public function __set(string $index, string $value): void
    {
        // echo '<br/>SET ['.get_class($this).']['.$index.']['.round(memory_get_usage()/(1024*1024),2).' MB]';
        $this->vars[$index] = $value;
    }

    public function __get(string $index): mixed
    {
        if (isset($this->vars[$index])) {
            return $this->vars[$index];
        }

        return null;
    }

    public function __concatBefore(string $index, string $value): void
    {
        $tmp = $this->__get($index);
        $tmp = $value.$tmp;
        $this->__set($index, $tmp);
    }

    public function __getVars(array $params = []): mixed
    {
        $vars = $this->vars;
        $vars['smarty'] = '';
        unset($vars['smarty']);

        return $vars;
    }
}
