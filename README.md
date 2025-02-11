# Shopify Laravel Template

## Requirements
1. PHP 8.2+
2. <a href="https://getcomposer.org/">Composer</a>
3. <a href="https://nodejs.org/en">Node.js</a>


## Instructions
Instructions for installation and additional features of the template can be found here https://github.com/gnikyt/laravel-shopify/wiki.

## Fixes
1. Fixed authorization issue - overwritten middleware from library with fix here app/Http/Middleware/VerifyShopify.php
2. The library is designed to use Shopify Admin API only, to use other Shopify APIs overwritten middleware app/Http/Middleware/AuthRequest.php which is extended by app/Http/Middleware/AuthPaymentRequest.php where you can change which API to access, example use with Shopify Payments API app/Services/Shopify/ShopifyService.php
3. Added Laravel 11 support

## Features
- Made a service to work with different Shopify APIs, which can be modified for different APIs and using different authorization app/Services/Shopify/ShopifyService.php example of use:
```
$result = $shopifyService->byStore($shop)->paymentApi()->graph(
   'mutation paymentSessionResolve( $id: ID!, $networkTransactionId: String )
              { paymentSessionResolve(id: $id, networkTransactionId: $networkTransactionId) 
              { userErrors { field message } paymentSession { nextAction 
              { action context { ... on PaymentSessionActionsRedirect { redirectUrl } } } } } } } }',
   ['id' => $payment->payment_id, 'networkTransactionId' => strval($payment->id)]
);
```
- An example of getting a session token can be seen here resources/views/welcome.blade.php:104:
```
$store = Auth::user();
$store->getSessionContext()->getSessionToken()->toNative()
```
