<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use Cknow\Money\Money;

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
<<<<<<< HEAD
    public function getPriceCurrencyAttribute($value): Money
=======
    /**
     * @return \Cknow\Money\Money
     */
    public function getPriceCurrencyAttribute($value)
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return @money($this->price, $this->currency);
    }

<<<<<<< HEAD
    public function getPriceCompleteCurrencyAttribute($value): Money
=======
    /**
     * @return \Cknow\Money\Money
     */
    public function getPriceCompleteCurrencyAttribute($value)
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return @money($this->price_complete, $this->currency);
    }

<<<<<<< HEAD
    public function getSubtotalCurrencyAttribute($value): Money
=======
    /**
     * @return \Cknow\Money\Money
     */
    public function getSubtotalCurrencyAttribute($value)
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        $value = $this->qty > 0 ? $this->qty * $this->price : $this->price;

        return @money($value, $this->currency);
    }

    public function getCurrency(float $number): Money
    {
        return @money($number, $this->currency);
    }
}
