<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

// use Laravel\Scout\Searchable;

// ----- models------

// ---- services -----
// use Modules\Cms\Services\PanelService;

// ------ traits ---

/**
 * Modules\Food\Models\Traits\HasPriceTrait.
 *
 * @property string $currency
 * @property float  $price
 * @property string $price_complete
 * @property int    $qty
 */
trait HasPriceTrait
{
    public function getPriceCurrencyAttribute($value): \Cknow\Money\Money
    {
        return @money($this->price, $this->currency);
    }

    public function getPriceCompleteCurrencyAttribute($value): \Cknow\Money\Money
    {
        return @money($this->price_complete, $this->currency);
    }

    public function getSubtotalCurrencyAttribute($value): \Cknow\Money\Money
    {
        if ($this->qty > 0) {
            $value = $this->qty * $this->price;
        } else {
            $value = $this->price;
        }

        return @money($value, $this->currency);
    }

    public function getCurrency(float $number): \Cknow\Money\Money
    {
        return @money($number, $this->currency);
    }
}
