<?php

namespace App\Services;

use App\Enum\CurrencyEnum;
use App\StaticDatas\CurrencyExchangeRate;

class CurrencyExchangeService {
    public function __construct(
        private CurrencyExchangeRate $currenyExchangeRate
    ) {}

    public function exchange(string $source, string $target, string $amount): string {
        if ( empty( CurrencyEnum::tryFrom($source) ) )
            throw new \Exception( __('responses.currency_invalid', ['currency' => $source]) );
        if ( empty( CurrencyEnum::tryFrom($target) ) )
            throw new \Exception( __('responses.currency_invalid', ['currency' => $target]) );

        $amount = round( floatval( str_replace(',', '', $amount) ), 2 );
        $exchangeRate = $this->currenyExchangeRate->rule[$source][$target];

        $amount *= $exchangeRate;

        return number_format( round($amount, 2), 2 );
    }
}