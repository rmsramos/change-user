# Filament Change User

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rmsramos/change-user.svg?style=flat-square)](https://packagist.org/packages/rmsramos/change-user)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/rmsramos/change-user/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/rmsramos/change-user/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/rmsramos/change-user.svg?style=flat-square)](https://packagist.org/packages/rmsramos/change-user/stats)

Filament plugin to change users without having to leave the panel

<div class="filament-hidden">

![Screenshot of Application Feature](https://raw.githubusercontent.com/rmsramos/change-user/main/arts/cover.png)

</div>

## Supported languages

Change User Plugin is translated for :

-   🇧🇷 Brazilian Portuguese
-   🇺🇸 English
-   🇪🇸 Spanish

## Installation

You can install the package via composer:

```bash
composer require rmsramos/change-user
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="change-user-views"
```

## Usage

In your Panel ServiceProvider (App\Providers\Filament) active the plugin

Add the `Rmsramos\ChangeUser\ChangeUserPlugin` to your panel config

```php
use Rmsramos\ChangeUser\ChangeUserPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            ChangeUserPlugin::make(),
        ]);
}
```

If you would like to prevent certain users from accessing the change user, you should add a `showButton()` callback in the `ChangeUserPlugin` chain.

```php
use Rmsramos\ChangeUser\ChangeUserPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            ChangeUserPlugin::make()
                ->showButton(fn () => auth()->user()->id === 1),
        ]);
}
```

You can swap out the modal heading used by updating the `setModalHeading()`  value.

```php
use Rmsramos\ChangeUser\ChangeUserPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            ChangeUserPlugin::make()
                ->setModalHeading('Another modal heading'),
        ]);
}
```
You can swap out the modal icon used by updating the `setIcon()`  value.

```php
use Rmsramos\ChangeUser\ChangeUserPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            ChangeUserPlugin::make()
                ->setIcon('heroicon-o-finger-print'),
        ]);
}
```

## Full configuration
```php
use Rmsramos\ChangeUser\ChangeUserPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            ChangeUserPlugin::make()
                ->showButton(fn () => auth()->user()->id === 1)
                ->setModalHeading('Another modal heading')
                ->setIcon('heroicon-o-finger-print'),
        ]);
}
```
## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Rômulo Ramos](https://github.com/rmsramos)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
