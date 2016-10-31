# Mailchimp API php client

Simple wrapper around Guzzle Http Client to interact with Mailchimp API v3.0

## Installation

The Mailchimp API php client can be installed with [Composer](https://getcomposer.org/):

```sh
composer require classy-org/mailchimp-api-php-client
```

Be sure you included composer autoloader in your app:

```php
require_once '/path/to/your/project/vendor/autoload.php';
```

## Usage

```php
// Instantiate the client
$client = new \Classy\MailchimpClient('dc834647d7f8a38c86b25dd4fdeff6f7-us2'); // use your mailchimp API key here

// Fetches your mailchimp lists
$httpResponse = $client->get('/lists');
$lists = json_decode($httpResponse->getBody()->getContents());

// Or shorter:
$lists = $client->getData('/lists');
```

## Exception handling

This client is using Guzzle Http client. Exceptions are thrown when the Http response is not a 200 (OK) one:

```php
try {
    $response = $client->get('/lists/e87ab1c34');
} catch (Exception $e) {
    if ($e instanceof \GuzzleHttp\Exception\ConnectException) {
        // there was a networking error
    }

    if ($e instanceof \GuzzleHttp\Exception\ClientException) {
        // Mailchimp API returned a 4xx response.
        $httpStatusCode = $e->getCode();
        if ($httpStatusCode == 404) {
            // resource doesn't exist
        }
        if ($httpStatusCode == 401) {
            // you're unauthorized (api key must be invalid)
        }
        if ($httpStatusCode == 403) {
            // you're not allowed to request this endpoint
        }
        if ($httpStatusCode == 400) {
            // body payload is invalid
        }
        if (...) {
            //
        }

        $bodyResponse = $e->getResponse()->getBody()->getContents();
    }

    if ($e instanceof \GuzzleHttp\Exception\ServerException) {
        // Mailchimp returned a 5xx response, which means they experience technical difficulties.
    }
}
```
