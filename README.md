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
## Getting all your mailchimp lists
$client = new \Classy\MailchimpClient('dc834647d7f8a38c86b25dd4fdeff6f7-us2'); // use your mailchimp API key here
$lists = $client->getData('/lists');
```
