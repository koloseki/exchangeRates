<?php

class CurrencyApiSaver {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function saveExchangeRates($exchangeRates) {
        foreach ($exchangeRates as $table) {
            foreach ($table['rates'] as $rate) {
                $currencyCode = $rate['code'];
                $currencyName = $rate['currency'];
                $currencyPrice = $rate['mid'];

                // Sprawdź, czy rekord już istnieje w bazie danych
                $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM exchangerates WHERE currency_code = ?");
                $stmt->execute([$currencyCode]);
                $count = $stmt->fetchColumn();

                if ($count > 0) {
                    // Rekord istnieje, usuń go z bazy danych
                    $deleteStmt = $this->pdo->prepare("DELETE FROM exchangerates WHERE currency_code = ?");
                    $deleteStmt->execute([$currencyCode]);

                    // Dodaje nowy rekord z API
                    $stmt = $this->pdo->prepare("INSERT INTO exchangerates (currency_code, currency_name, price) VALUES (?, ?, ?)");
                    $stmt->execute([$currencyCode, $currencyName, $currencyPrice]);
                } else {
                    // Wstaw, tylko jeśli rekord nie istnieje
                    $stmt = $this->pdo->prepare("INSERT INTO exchangerates (currency_code, currency_name, price) VALUES (?, ?, ?)");
                    $stmt->execute([$currencyCode, $currencyName, $currencyPrice]);
                }

            }
        }

    }
}
