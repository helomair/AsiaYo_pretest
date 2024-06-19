<?php

namespace App\StaticDatas;

use App\Enum\CurrencyEnum;

class CurrencyExchangeRate {
    public readonly array $rate;

    public function __construct() {
        $this->rate = [
            CurrencyEnum::TWD->value => [
                CurrencyEnum::TWD->value => 1,
                CurrencyEnum::JPY->value => 3.669,
                CurrencyEnum::USD->value => 0.03281,
            ],
    
            CurrencyEnum::JPY->value => [
                CurrencyEnum::TWD->value => 0.26956,
                CurrencyEnum::JPY->value => 1,
                CurrencyEnum::USD->value => 0.00885,
            ],
    
            CurrencyEnum::USD->value => [
                CurrencyEnum::TWD->value => 30.444,
                CurrencyEnum::JPY->value => 111.801,
                CurrencyEnum::USD->value => 1,
            ]
        ];
    }
}