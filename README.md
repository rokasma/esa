# Esa

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rokasma/esa.svg?style=flat-square)](https://packagist.org/packages/rokasma/esa)
[![Total Downloads](https://img.shields.io/packagist/dt/rokasma/esa.svg?style=flat-square)](https://packagist.org/packages/rokasma/esa)

Laravel ESA plugin let's you post data to smartsheet and send emails.

## Installation

You can install the package via composer:

```bash
composer require rokasma/esa
```

## Prerequisites

* Laravel 7
* Laravel 8

## Usage

Publish config file and enter API Key into it.
``` php
php artisan vendor:publish --provider="Rokasma\Esa\EsaServiceProvider" --tag="config"
```

* Then posting sheet-id is required as first.
* Post your json data to /esa route. 

Example post request:
```
[
    {
        "sheet-id": "123456789"
    },
    {
        "column": {
            "title": "My Title",
            "value": "foo"
        }
    },
    {
        "column": {
            "title": "My Title 2",
            "value": "bar"
        }
    }
]
```
### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Rokas Martusevičius](https://github.com/rokasma)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.