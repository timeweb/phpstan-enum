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

And include extension.neon in your project's PHPStan config

```yaml
includes:
  - vendor/timeweb/phpstan-enum/extension.neon
```
