# Enum class reflection extension for PHPStan

[![Build Status](https://travis-ci.org/timeweb/phpstan-enum.svg?branch=master)](https://travis-ci.org/timeweb/phpstan-enum)

* [PHPStan](https://phpstan.org/)
* [PHP Enum](https://github.com/myclabs/php-enum)

This extension defines dynamic methods for `MyCLabs\Enum\Enum` subclasses.

## Usage

To use this extension, require it with [Composer](https://getcomposer.org)

```
composer require --dev timeweb/phpstan-enum
```

And include extension.neon in your project's PHPStan config

```
includes:
  - vendor/timeweb/phpstan-enum/extension.neon
```
