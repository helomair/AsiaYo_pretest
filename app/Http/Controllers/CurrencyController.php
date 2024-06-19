<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyExchangeRequest;
use App\Services\CurrencyExchangeService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function __construct(
        private CurrencyExchangeService $exchangeService
    ) {}

    public function exchange(CurrencyExchangeRequest $request) {
        $exchangeResult = $this->exchangeService->exchange(
            $request->source,
            $request->target,
            $request->amount
        );

        if ( is_string($exchangeResult) )
            return ['msg' => $exchangeResult, 'amount' => null];

        return ['msg' => 'success', 'amount' => number_format($exchangeResult, 2)];
    }
}
