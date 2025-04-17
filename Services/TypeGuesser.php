<?php

declare(strict_types=1);

namespace Modules\Xot\Services;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class TypeGuesser
{
<<<<<<< HEAD
    private static string $default = 'word';
=======
    /**
     * @var string
     */
    protected static $default = 'word';
    /**
     * @var Faker
     */
    protected $generator;
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a

    /**
     * Create a new TypeGuesser instance.
     */
    public function __construct(private readonly Faker $generator)
    {
    }

    /**
     * @param int|null $size Length of field, if known
     */
    public function guess(string $name, Type $type, int $size = null): string
    {
        $name = Str::of($name)->lower();

        if ($name->endsWith('_id')) {
            return 'integer';
        }

        $name = $name->replace('_', '')->__toString();

        if (self::$default !== $typeNameGuess = $this->guessBasedOnName($name, $size)) {
            return $typeNameGuess;
        }

        if ($this->hasNativeResolverFor($name)) {
            return $name;
        }

        return $this->guessBasedOnType($type, $size);
    }

    /**
     * Check if faker instance has a native resolver for the given property.
     *
     * @param string $property
     */
    private function hasNativeResolverFor($property): bool
    {
        try {
            $this->generator->getFormatter($property);
        } catch (\InvalidArgumentException) {
            return false;
        }

        return true;
    }

    /**
     * Try to guess the right faker method for the given type.
     *
     * @return string
     */
    private function guessBasedOnType(Type $type, ?int $size)
    {
        $typeName = $type->getName();

<<<<<<< HEAD
        return match ($typeName) {
            Types::BOOLEAN => 'boolean',
            Types::BIGINT, Types::INTEGER, Types::SMALLINT => 'randomNumber'.($size ? sprintf('(%s)', $size) : ''),
            Types::DATE_MUTABLE, Types::DATE_IMMUTABLE => 'date',
            Types::DATETIME_MUTABLE, Types::DATETIME_IMMUTABLE => 'dateTime',
            Types::DECIMAL, Types::FLOAT => 'randomFloat'.($size ? sprintf('(%s)', $size) : ''),
            Types::TEXT => 'text',
            Types::TIME_MUTABLE, Types::TIME_IMMUTABLE => 'time',
            default => self::$default,
        };
=======
        switch ($typeName) {
            case Types::BOOLEAN:
                return 'boolean';
            case Types::BIGINT:
            case Types::INTEGER:
            case Types::SMALLINT:
                return 'randomNumber'.($size ? "({$size})" : '');
            case Types::DATE_MUTABLE:
            case Types::DATE_IMMUTABLE:
                return 'date';
            case Types::DATETIME_MUTABLE:
            case Types::DATETIME_IMMUTABLE:
                return 'dateTime';
            case Types::DECIMAL:
            case Types::FLOAT:
                return 'randomFloat'.($size ? "({$size})" : '');
            case Types::TEXT:
                return 'text';
            case Types::TIME_MUTABLE:
            case Types::TIME_IMMUTABLE:
                return 'time';
            default:
                return self::$default;
        }
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }

    /**
     * Predicts county type by locale.
     */
    private function predictCountyType(): string
    {
        if ('en_US' === $this->generator->locale) {
            return "sprintf('%s County', \$faker->city)";
        }

        return 'state';
    }

    /**
     * Predicts country code based on $size.
     */
    private function predictCountryType(?int $size): string
    {
        return match ($size) {
            2 => 'countryCode',
            3 => 'countryISOAlpha3',
            5, 6 => 'locale',
            default => 'country',
        };
    }

    /**
     * Predicts type of title by $size.
     */
    private function predictTitleType(?int $size): string
    {
        if (null === $size || $size <= 10) {
            return 'title';
        }

        return 'sentence';
    }

    /**
     * Get type guess.
     *
<<<<<<< HEAD
     * @param string $name
     *
     * @return string
     */
    private function guessBasedOnName($name, int $size = null)
    {
        return match ($name) {
            'login' => 'userName',
            'emailaddress' => 'email',
            'phone', 'telephone', 'telnumber' => 'phoneNumber',
            'town' => 'city',
            'zipcode' => 'postcode',
            'county' => $this->predictCountyType(),
            'country' => $this->predictCountryType($size),
            'currency' => 'currencyCode',
            'website' => 'url',
            'companyname', 'employer' => 'company',
            'title' => $this->predictTitleType($size),
            default => self::$default,
        };
=======
     * @param string   $name
     * @param int|null $size
     *
     * @return string
     */
    private function guessBasedOnName($name, $size = null)
    {
        switch ($name) {
            case 'login':
                return 'userName';
            case 'emailaddress':
                return 'email';
            case 'phone':
            case 'telephone':
            case 'telnumber':
                return 'phoneNumber';
            case 'town':
                return 'city';
            case 'zipcode':
                return 'postcode';
            case 'county':
                return $this->predictCountyType();
            case 'country':
                // Parameter #1 $size of method Modules\Xot\Services\TypeGuesser::predictCountryType() expects int, int|null  given.
                return $this->predictCountryType($size);
            case 'currency':
                return 'currencyCode';
            case 'website':
                return 'url';
            case 'companyname':
            case 'employer':
                return 'company';
            case 'title':
                // 91     Parameter #1 $size of method Modules\Xot\Services\TypeGuesser::predictTitleType() expects int, int|null   given.
                return $this->predictTitleType($size);
            default:
                return self::$default;
        }
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }
}
