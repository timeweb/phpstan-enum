# Enum class reflection extension for PHPStan

[![Packagist Version](https://img.shields.io/packagist/v/timeweb/phpstan-enum)](https://packagist.org/packages/timeweb/phpstan-enum)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/timeweb/phpstan-enum/CI)

* [PHPStan](https://phpstan.org/)
* [PHP Enum](https://github.com/myclabs/php-enum)

This extension defines dynamic methods for `MyCLabs\Enum\Enum` subclasses.

## Usage

To use this extension, require it with [Composer](https://getcomposer.org)

```bash
composer require --dev timeweb/phpstan-enum
```

If you use [PHPStan extension installer](https://github.com/phpstan/extension-installer), this extension is registered on `composer install` automatically.

Otherwise, include `extension.neon` in your project's PHPStan config:

```yaml
includes:
    - vendor/timeweb/phpstan-enum/extension.neon
```

## Install for Local Development

### With docker

```bash
git clone git@github.com:timeweb/phpstan-enum.git
cd phpstan-enum
make docker-build
make install
make phpunit
```

### Without docker (localy installed actual version of php, composer, etc)

```bash
git clone git@github.com:timeweb/phpstan-enum.git
cd phpstan-enum
make install
make phpunit
```
