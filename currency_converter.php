<?php

declare(strict_types=1);

class Currency
{
    const CB_URL = "https://cbu.uz/uz/arkhiv-kursov-valyut/json/";

    public function exchange(float|int $amount, $ccy_to_convert_from, $ccy_to_convert_to): float|int
    {
        $exchange = 0;
        $currencies = $this->customCurrencies();
        if ($ccy_to_convert_from === 'UZS') {
            $exchange_rate = $currencies[$ccy_to_convert_to];
            $exchange = $amount / $exchange_rate;
        } elseif ($ccy_to_convert_to == 'UZS') {
            $exchange_rate = $currencies[$ccy_to_convert_from];
            $exchange = $amount * $exchange_rate;
        }
        return $exchange;
    }

    public function getCurrencyInfo()
    {
        $currencyInfo = file_get_contents(self::CB_URL);
        $allInfo = json_decode($currencyInfo, true);
        $allInfo[] = ["Ccy" => "UZS", "Rate" => 1];
        return $allInfo;
    }

    public function customCurrencies(): array
    {
        $currencies        = (array) $this->getCurrencyInfo();
        $orderedCurrencies = [];
        foreach ($currencies as $currency) {
            $orderedCurrencies[$currency['Ccy']] = $currency['Rate'];
        }

        return $orderedCurrencies;
    }
}
$currency = new Currency();
