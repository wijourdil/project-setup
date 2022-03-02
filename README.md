[![Latest Version on Packagist](https://img.shields.io/packagist/v/wijourdil/project-setup.svg?style=flat)](https://packagist.org/packages/wijourdil/project-setup)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/wijourdil/project-setup/tests?label=tests&style=flat)](https://github.com/wijourdil/project-setup/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/wijourdil/project-setup.svg?style=flat)](https://packagist.org/packages/wijourdil/project-setup)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/wijourdil/project-setup)
![Packagist License](https://img.shields.io/packagist/l/wijourdil/project-setup)
[![gitmoji.dev](https://img.shields.io/badge/gitmoji-%20😜%20😍-FFDD67.svg?style=flat)](https://gitmoji.dev)

# 🪄 Laravel / Lumen project setup

Setup a new Laravel / Lumen project by installing and configuring all necessary packages.

## Installation

```shell
composer require wijourdil/project-setup --dev
```

### Laravel

Nothing to do,the package will be discovered automatically.

### Lumen

Register the package service provider in your `bootstrap/app.php` file:
```php
if ($app->environment() !== 'production') {
    $app->register(\Wijourdil\ProjectSetup\ProjectSetupServiceProvider::class);
}
```

## Usage

```shell
php artisan project-setup:run
```

### See all available options:
```shell
php artisan project-setup:run -h
```
