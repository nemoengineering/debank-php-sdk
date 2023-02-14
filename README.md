# DeBank PHP SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nemo/debank-php-sdk.svg?style=flat-square)](https://packagist.org/packages/nemo/debank-php-sdk)
[![Tests](https://img.shields.io/github/actions/workflow/status/nemo/debank-php-sdk/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/nemo/debank-php-sdk/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/nemo/debank-php-sdk.svg?style=flat-square)](https://packagist.org/packages/nemo/debank-php-sdk)

An object-oriented and typed PHP client for DeBank API.

## Installation

You can install the package via composer:

```bash
composer require nemo/debank-php-sdk
```

## Usage

```php
$client = new Nemo\DeBank();
echo $client->user()->getTokenList('0xaBc3...');
```

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
