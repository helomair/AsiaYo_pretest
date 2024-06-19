<?php

namespace Tests\Feature;

use App\Enum\CurrencyEnum;
use App\Services\CurrencyExchangeService;
use App\StaticDatas\CurrencyExchangeRate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyExchangeServiceTest extends TestCase
{
    private CurrencyExchangeService $service;

    private string $source;
    private string $target;
    private string|int $amount;

    public function setUp(): void {
        parent::setUp();

        $this->service = $this->app->make('App\Services\CurrencyExchangeService');

        // Default values
        $this->source = CurrencyEnum::TWD->value;
        $this->target = CurrencyEnum::JPY->value;
        $this->amount = 1525;
    }

    public function test_Success() {
    # Arrange
        $exchangeRate = new CurrencyExchangeRate;

        $expectResult = round( $this->amount * $exchangeRate->rate[$this->source][$this->target], 2 );

    # Act
        $result = $this->service->exchange($this->source, $this->target, $this->amount);

    # Assert
        $this->assertIsFloat($result);
        $this->assertEquals($expectResult, $result);
    }



    public function test_GivenSourceInvalid() {
    # Arrange
        $this->source = "EUR";
    # Act
        $result = $this->service->exchange($this->source, $this->target, $this->amount);

    # Assert
        $this->assertIsString($result);
        $this->assertEquals(__('responses.currency_invalid', ['currency' => $this->source]), $result);
    }

    public function test_GivenTargetInvalid() {
    # Arrange
        $this->target = "EUR";
    # Act
        $result = $this->service->exchange($this->source, $this->target, $this->amount);

    # Assert
        $this->assertIsString($result);
        $this->assertEquals(__('responses.currency_invalid', ['currency' => $this->target]), $result);
    }



    public function test_GivenAmountHasThousandthsComma_Correct() {
    # Arrange
        $this->amount = "1,231,525.2222";

        $exchangeRate = new CurrencyExchangeRate;
        $amount = round( floatval( str_replace(',', '', $this->amount) ), 2 );
        $expectResult = round( $amount * $exchangeRate->rate[$this->source][$this->target], 2 );
    # Act
        $result = $this->service->exchange($this->source, $this->target, $this->amount);

    # Assert
        $this->assertIsFloat($result);
        $this->assertEquals($expectResult, $result);
    }

    public function test_GivenAmountHasThousandthsComma_Wrong() {
    # Arrange
        $this->amount = "1,2315,25.2222";

    # Act
        $result = $this->service->exchange($this->source, $this->target, $this->amount);

    # Assert
        $this->assertIsString($result);
        $this->assertEquals(__('responses.amount_string_invalid', ['amount' => $this->amount]), $result);
    }

    public function test_GivenAmountNotNumeric_AddCharInFrontOfNumericString() {
    # Arrange
        $this->amount = "S1123.222222";
    # Act
        $result = $this->service->exchange($this->source, $this->target, $this->amount);

    # Assert
        $this->assertIsString($result);
        $this->assertEquals(__('responses.amount_string_invalid', ['amount' => $this->amount]), $result);
    }

    public function test_GivenAmountNotNumeric_StringWithoutAnyDigits() {
    # Arrange
        $this->amount = "AS%T**#$*";
    # Act
        $result = $this->service->exchange($this->source, $this->target, $this->amount);

    # Assert
        $this->assertIsString($result);
        $this->assertEquals(__('responses.amount_string_invalid', ['amount' => $this->amount]), $result);
    }

    public function test_GivenAmount_HasDecimalBiggerThanTwo() {
    # Arrange
        $this->amount = "1,231,525.2222";

        $exchangeRate = new CurrencyExchangeRate;
        $amount = round( floatval( str_replace(',', '', $this->amount) ), 2 );
        $expectResult = round( $amount * $exchangeRate->rate[$this->source][$this->target], 2 );

    # Act
        $result = $this->service->exchange($this->source, $this->target, $this->amount);

    # Assert
        $this->assertIsFloat($result);
        $this->assertEquals($expectResult, $result);
    }

    public function test_GivenAmount_NotHaveDecimal_ThousandthsComma() {
    # Arrange
        $this->amount = "1,231,525";

        $exchangeRate = new CurrencyExchangeRate;
        $amount = round( floatval( str_replace(',', '', $this->amount) ), 2 );
        $expectResult = round( $amount * $exchangeRate->rate[$this->source][$this->target], 2 );

    # Act
        $result = $this->service->exchange($this->source, $this->target, $this->amount);

    # Assert
        $this->assertIsFloat($result);
        $this->assertEquals($expectResult, $result);
    }
}
