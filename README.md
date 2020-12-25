# A PHP composer package for MijnDomeinReseller

[![Latest Version on Packagist](https://img.shields.io/packagist/v/IntVent/mijndomeinreseller.svg?style=flat-square)](https://packagist.org/packages/IntVent/mijndomeinreseller)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/IntVent/mijndomeinreseller/run-tests?label=tests)](https://github.com/IntVent/mijndomeinreseller/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/IntVent/mijndomeinreseller.svg?style=flat-square)](https://packagist.org/packages/IntVent/mijndomeinreseller)

## Installation

You can install the package via composer:

```bash
composer require IntVent/mijndomeinreseller
```

## Usage

``` php
use Intvent\MijnDomeinReseller\Client;

$client = new Client('test', 'test');
$client->get('domain_list');
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email info@intvent.nl instead of using the issue tracker.

## Credits

- [IntVent BV](https://github.com/IntVent)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
