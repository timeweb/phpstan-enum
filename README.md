# Enum class reflection extension for PHPStan

[![Build Status](https://github.com/timeweb/phpstan-enum/actions/workflows/ci.yml/badge.svg)](https://actions-badge.atrox.dev/timeweb/phpstan-enum/goto?ref=master)
[![License](https://poser.pugx.org/timeweb/phpstan-enum/license)](https://packagist.org/packages/timeweb/phpstan-enum)
[![Latest Stable Version](https://poser.pugx.org/timeweb/phpstan-enum/v/stable)](https://packagist.org/packages/timeweb/phpstan-enum)
[![Latest Unstable Version](https://poser.pugx.org/timeweb/phpstan-enum/v/unstable)](https://packagist.org/packages/timeweb/phpstan-enum)

- [PHPStan](https://phpstan.org/)
- [PHP Enum](https://github.com/myclabs/php-enum)

This extension defines dynamic methods for `MyCLabs\Enum\Enum` subclasses.

## Usage

To use this extension, require it with [Composer](https://getcomposer.org)

```bash
composer require --dev timeweb/phpstan-enum
```

If you also install [phpstan/extension-installer](https://github.com/phpstan/extension-installer) then you're all set!

### Manual installation

If you don't want to use `phpstan/extension-installer`, include extension.neon in your project's PHPStan config:

```neon
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
