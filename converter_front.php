<?php

declare(strict_types=1);

require 'currency_converter.php';

$currency = new Currency();

$amount = $_POST['amount'] ?? 0;
$ccy_to_convert_from = $_POST['currency_to_convert_from'] ?? '';
$ccy_to_convert_to = $_POST['currency_to_convert_to'] ?? '';
?>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
              crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                crossorigin="anonymous"></script>
        <title>Currency Converter</title>
    </head>
    <div class="container">
        <form action="converter_front.php" method="post">
            <fieldset>
                <legend>Currency converter</legend>
                <label>
                    Select currency to convert from:
                    <select class="form-select" name="currency_to_convert_from">
                        <?php
                        $desiredCurrencies = ['UZS', 'USD', 'RUB', 'EUR', 'KZS', 'TRY', 'AED', 'SAR', 'GBP', 'MYR', 'CHF'];
                        $limit = 0;
                        foreach ($currency->customCurrencies() as $currencyName => $rate) {
                            if (in_array($currencyName, $desiredCurrencies)) {
                                echo "<option value='$currencyName'>$currencyName</option>";
                                $limit++;
                                if ($limit == 10) break;
                            }
                        } ?>
                    </select>
                </label>
                <div class="mb-3">
                    <label for="amount" class="form-label">Enter amount:</label>
                    <input type="text" id="amount" class="form-control" name="amount">
                </div>

                <label>
                    Select currency to convert to:
                    <select class="form-select" name="currency_to_convert_to">
                        <?php
                        $limit = 0;
                        foreach ($currency->customCurrencies() as $currencyName => $rate) {
                            if (in_array($currencyName, $desiredCurrencies)) {
                                echo "<option value='$currencyName'>$currencyName</option>";
                                $limit++;
                                if ($limit == 10) break;
                            }
                        } ?>
                    </select>
                </label>
                <div class="mb-3">
                    <label for="amount" class="form-label"><?php echo $_POST['currency_to_convert_to'] ?? '' ?></label>
                    <input type="text" id="amount" class="form-control" value="<?php
                    if ($amount){
                        echo $currency->exchange((float) $amount, $ccy_to_convert_from, $ccy_to_convert_to);
                    }
                    ?>">
                </div>
                <button type="submit" class="btn btn-primary">Exchange</button>
            </fieldset>
        </form>
    </div>
<?php