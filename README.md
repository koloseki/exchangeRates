# exchangeRates
A very simple exchange calculator done in php 


## How its working 
   1. The application sends a request to the NBP (Narodowy Bank Polski) API to fetch the latest exchange rates for various currencies. The retrieved data is then saved to the database for future use.
   2.  On the main page, the current currency values are displayed in a table, based on the exchange rates obtained from the API and stored in the database. This provides users with the most up-to-date currency values.
   3.  When the user enters a value to be converted and selects the source and target currencies, the application retrieves the respective exchange rates from the database.
   4.  Using the retrieved exchange rates, the application performs the currency conversion calculation and displays the converted value on a separate page. This conversion action is also recorded in the database for future reference.
   5.  Underneath the converted value, the last 5 conversion actions (including the source currency, source value, target currency, and converted value) are displayed from the database. This allows users to see their recent conversion history.

By fetching the exchange rates from the NBP API, saving them to the database, and performing conversions based on the stored rates, the application ensures accurate and real-time currency conversions. The conversion history provides users with a convenient way to track their past transactions.

author Dawid Żychowski
