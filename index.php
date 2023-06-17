    <?php
        include("database.php");
        include ("currencyAPI.php");

    $currencyAPI = new CurrencyAPI();
    $exchangeRates = $currencyAPI->getExchangeRates();

    // Iteruj przez kursy wymiany walut
    foreach ($exchangeRates as $table) {
        foreach ($table['rates'] as $rate) {
            $currencyName = $rate['currency'];
            $currencyPrice = $rate['mid'];

            echo "Waluta: " . $currencyName . ", Cena: " . $currencyPrice . "<br>";
        }
    }





    ?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
        <h1>Test</h1>
    </body>
    </html>