# Laravel Migration Snapshot

[![Latest Version on Packagist](https://img.shields.io/packagist/v/always-open/laravel-migration-snapshot.svg?style=flat-square)](https://packagist.org/packages/always-open/laravel-migration-snapshot)
![build](https://github.com/always-open/laravel-migration-snapshot/actions/workflows/php.yml/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/always-open/laravel-migration-snapshot.svg?style=flat-square)](https://packagist.org/packages/always-open/laravel-migration-snapshot)

Simplify and accelerate applying many migrations at once using a flattened dump
of the database schema and migrations, similar in spirit to Rails' `schema.rb`.

Works with the `mysql`, `pgsql`, and `sqlite` database drivers.

Laravel 8+ has `schema:dump` which serves a similar purpose. This package may
still be preferred if one wants the dumping to be automatic after each `migrate`
invocation, old migrations to remain in place, or to also dump data.

## Installation

You can install the package via composer:

``` bash
composer require --dev always-open/laravel-migration-snapshot
```

Database command-line utilities (such as `mysqldump` and `mysql`) must be in the
path where Artisan will be run.

## Configuration

Put `migration-snapshot.php` into `config` with:
``` bash
php artisan vendor:publish --provider="\AlwaysOpen\MigrationSnapshot\ServiceProvider"
```

## Usage

Implicitly migrate as load from an earlier, flattened copy:
``` bash
php artisan migrate
```
(When `migrations` table is empty and migrating a configured environment;
defaults to 'development', 'local', and 'testing'.)

Migrate without loading from, or dumping to, flattened copy:
``` bash
MIGRATION_SNAPSHOT=0  php artisan migrate
```

Update the flattened SQL file:
``` bash
php artisan migrate:dump
```

Load from the flattened SQL file, **dropping** any existing tables and views:
``` bash
php artisan migrate:load
```

### Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Paul R. Rogers](https://github.com/paulrrogers)
- ORIS Intelligence
- PriceSpider (NeuIntel)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
