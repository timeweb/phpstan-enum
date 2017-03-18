# Enum class reflection extension for PHPStan

* [PHPStan](https://github.com/phpstan/phpstan)
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
