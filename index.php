<?php
// Import necessary files
include("database.php");
include("currencyAPI.php");
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
    <script src="main.js" defer></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>



<h1>Exchange calculator</h1>

<div class="border rounded shadow-lg border-dark-25 p-3 w-50">
    <form action="convert.php" method="post" class="d-flex flex-column align-items-center ">
            <div class="d-flex flex-row align-items-center justify-content-sm-around">
                <div class="flex-column p-3">
                    <label for="amount" class="amount_label">Amount:</label>
                    <input type="number" id="amount" name="amount" min="1" step="0.01" class="form-control"  onkeypress="validate(event)" required>
                </div>

                <div class="d-flex flex-column justify-content-center w-25 ">
                    <label for="source_currency" class="w-75">From:</label>
                    <select   id="source_currency" name="source_currency" class="btn w-100 text-left border-dark dropdown-toggle shadow-sm pointer" data-bs-toggle="dropdown"  required>
                            <?php foreach ($exchangeRatesFromDB as $rate): ?>
                            <option value="<?php echo $rate['currency_code']; ?>" class="dropdown-item">
                                <?php echo $rate['currency_code']; ?>
                                <p>  - <?php echo $rate['currency_name']; ?></p>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="d-flex flex-column  justify-content-center w-25">
                    <label for="target_currency">To:</label>
                    <select   id="target_currency" name="target_currency" class="btn w-100 text-left border-dark dropdown-toggle shadow-sm pointer" data-bs-toggle="dropdown"  required>
                        <?php foreach ($exchangeRatesFromDB as $rate): ?>
                            <option class="btn pointer" value="<?php echo $rate['currency_code']; ?>">
                                <?php echo $rate['currency_code']; ?>
                                <div class="text-black-50 bg-danger">  - <?php echo $rate['currency_name']; ?></div>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
        </div>

        <div class="w-100 d-flex justify-content-xl-between mt-4">
            <button type="button" class="btn" onclick="dialog.showModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-receipt-cutoff" viewBox="0 0 16 16">
                    <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"/>
                    <path d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z"/>
                </svg>
            </button>
            <button class="btn btn-primary w-25" type="submit">Convert</button>
        </div>
    </form>
</div>

<dialog class="p-0">
    <h1 class="p-2">Exchange Rates</h1>
    <div class="currencyValueLive">


        <table class="table">
            <tr class="sticky-top bg-light">
                <th>Currency Code</th>
                <th>Currency Name</th>
                <th>Price(PLN)</th>
            </tr>
            <?php foreach ($exchangeRatesFromDB as $rate): ?>
                <tr>
                    <td><?php echo $rate['currency_code']; ?></td>
                    <td><?php echo $rate['currency_name']; ?></td>
                    <td><?php echo $rate['price']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</dialog>

</body>
</html>
