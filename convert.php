<?php
require_once 'database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['amount'], $_POST['source_currency'], $_POST['target_currency'])) {
    $amount = $_POST['amount'];
    $sourceCurrency = $_POST['source_currency'];
    $targetCurrency = $_POST['target_currency'];

    // Fetch exchange rates for the source and target currencies and their codes from the database
    $stmt = $pdo->prepare("SELECT currency_code, price FROM exchangerates WHERE currency_code = :source_currency OR currency_code = :target_currency");
    $stmt->execute(['source_currency' => $sourceCurrency, 'target_currency' => $targetCurrency]);
    $exchangeRates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sourceRate = null;
    $targetRate = null;

    foreach ($exchangeRates as $rate) {
        if ($rate['currency_code'] === $sourceCurrency) {
            $sourceRate = $rate['price'];
        } elseif ($rate['currency_code'] === $targetCurrency) {
            $targetRate = $rate['price'];
        }
    }


    if (count($exchangeRates) === 2) {

        // Perform currency conversion
        $result = $amount * ($sourceRate / $targetRate);

        $formattedResult = number_format($result, 7);

        // Save conversion data to the database
        $stmt = $pdo->prepare("INSERT INTO exchange_history (from_value,from_name,to_name,to_value) VALUES (?, ?, ?, ?)");
        if (!$stmt->execute([$amount, $sourceCurrency, $targetCurrency, $result])) {
            $errorInfo = $stmt->errorInfo();
            echo "Błąd zapisu do bazy danych: " . $errorInfo[2];
        }

    }
}

// Fetch recent conversion history
$stmt = $pdo->query("SELECT * FROM exchange_history ORDER BY id DESC LIMIT 5");
$history = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Currency Conversion</title>
    <link rel="stylesheet" href="styles/convert_style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<h1>Currency Conversion</h1>

<div class="resultContainer mb-4">
    <?php if (isset($formattedResult)): ?>
        <h3 class="result ">Result: <?php echo $formattedResult; ?></h3>
    <?php endif; ?>
</div>

<div class="history">
    <h2>Latest Conversions</h2>
    <table>
        <tr>
            <th>Amount</th>
            <th>Source Currency</th>
            <th>Target Currency</th>
            <th>Result</th>
        </tr>
        <?php foreach ($history as $conversion): ?>
            <tr>
                <td><?php echo $conversion['from_value']; ?></td>
                <td><?php echo $conversion['from_name']; ?></td>
                <td><?php echo $conversion['to_name']; ?></td>
                <td><?php echo $conversion['to_value']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<button class=" btn btn-primary p-2 mt-3" onclick="window.history.back()">Go Back</button>
</body>
</html>
