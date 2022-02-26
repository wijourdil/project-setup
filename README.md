# Laravel / Lumen project setup

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
