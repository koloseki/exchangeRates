<?php
// Import necessary files
include("database.php");
include("CurrencyAPI.php");
include("CurrencyAPIsaver.php");

// Create a CurrencyAPI object
$currencyAPI = new CurrencyAPI();

// Get exchange rates from the API
$exchangeRates = $currencyAPI->getExchangeRates();

// Create a CurrencyApiSaver object with PDO connection
$currencyApiSaver = new CurrencyApiSaver($pdo);

// Call the method to save exchange rate data to the database
$currencyApiSaver->saveExchangeRates($exchangeRates);

// Fetch data from the database
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
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<h1>Exchange calculator</h1>

<div class="exchangeForm" >
    <form action="convert.php" method="post">
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" min="1" step="0.01" required>


        <label for="source_currency">Source Currency:</label>
        <select id="source_currency" name="source_currency" required>
            <?php foreach ($exchangeRatesFromDB as $rate): ?>
                <option value="<?php echo $rate['currency_code']; ?>">
                    <?php echo $rate['currency_code']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="target_currency">Target Currency:</label>
        <select id="target_currency" name="target_currency" required>
            <?php foreach ($exchangeRatesFromDB as $rate): ?>
                <option value="<?php echo $rate['currency_code']; ?>">
                    <?php echo $rate['currency_code']; ?>
                </option>
            <?php endforeach; ?>
        </select>



        <button class="convert_button" type="submit">Convert</button>
    </form>
</div>

<div class="wrapper">
    <h1>Exchange Rates</h1>
    <div class="currencyValueLive">

        <table>
            <tr>
                <th>Currency Name</th>
                <th>Price(PLN)</th>
            </tr>
            <?php foreach ($exchangeRatesFromDB as $rate): ?>
                <tr>
                    <td><?php echo $rate['currency_name']; ?></td>
                    <td><?php echo $rate['price']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

</body>
</html>
