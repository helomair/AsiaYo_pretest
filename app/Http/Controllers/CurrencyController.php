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
        $result = $this->exchangeService->exchange(
            $request->source,
            $request->target,
            $request->amount
        );

        print_r($result);
    }
}
