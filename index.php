<?php
include("database.php");
include("CurrencyAPI.php");
include("CurrencyApiSaver.php");

// Utworzenie obiektu CurrencyAPI
$currencyAPI = new CurrencyAPI();

// Pobranie kursów wymiany z API
$exchangeRates = $currencyAPI->getExchangeRates();

// Utworzenie obiektu CurrencyApiSaver z połączeniem PDO
$currencyApiSaver = new CurrencyApiSaver($pdo);

// Wywołanie metody do zapisu danych kursów wymiany do bazy danych
$currencyApiSaver->saveExchangeRates($exchangeRates);

// Pobranie danych z bazy danych
$stmt = $pdo->query("SELECT * FROM exchangerates");
$exchangeRatesFromDB = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exchange Rates</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50vw;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
<h1>Exchange Rates</h1>
<table>
    <tr>
        <th>Currency Name</th>
        <th>Price</th>
    </tr>
    <?php foreach ($exchangeRatesFromDB as $rate): ?>
        <tr>
            <td><?php echo $rate['currency_name']; ?></td>
            <td><?php echo $rate['price']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
