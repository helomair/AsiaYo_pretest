<?php

namespace App\Services;

use App\Enum\CurrencyEnum;
use App\StaticDatas\CurrencyExchangeRate;

class CurrencyExchangeService {
    public function __construct(
        private CurrencyExchangeRate $currenyExchangeRate
    ) {}

    /**
     * @return string If validation failed.
     * @return float Success
     */
    public function exchange(string $source, string $target, string $amount): string|float {
        if ( empty( CurrencyEnum::tryFrom($source) ) )
            return __('responses.currency_invalid', ['currency' => $source]);
        if ( empty( CurrencyEnum::tryFrom($target) ) )
            return __('responses.currency_invalid', ['currency' => $target]);
        if ( !$this->isAmountStringValid($amount) )
            return __('responses.amount_string_invalid', ['amount' => $amount]);

        $amount = round( floatval( str_replace(',', '', $amount) ), 2 );
        $exchangeRate = $this->currenyExchangeRate->rate[$source][$target];

        $amount *= $exchangeRate;

        return round($amount, 2);
    }

    private function isAmountStringValid(string $amount): bool {
        $checkingRegex = "/(\d)+([\.](\d)+)*/";
        if ( strpos($amount, ',') !== false ) {
            $checkingRegex = "/(\d){1,3}([\,](\d){3})*([\.](\d)+)*/";
        }

        $matches = [];
        preg_match($checkingRegex, $amount, $matches);

        if (empty($matches) || (strlen($matches[0]) !== strlen($amount)))
            return false;

        return true;
    }
}