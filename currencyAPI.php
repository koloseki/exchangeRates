<?php

//This file contains the CurrencyAPI class, which allows retrieving exchange rate data from the National Bank of Poland (NBP) API.

class CurrencyAPI{
    public $apiUrl = "https://api.nbp.pl";

    public function getExchangeRates(){


        $urlA = $this->apiUrl . "/api/exchangerates/tables/A";
        $responseA = file_get_contents($urlA);
        $dataA = json_decode($responseA, true);

        $urlB = $this->apiUrl . "/api/exchangerates/tables/B";
        $responseB = file_get_contents($urlB);
        $dataB = json_decode($responseB, true);

        //merge the data into one array
        $combinedData = array_merge($dataA, $dataB);

        return $combinedData;
    }
}