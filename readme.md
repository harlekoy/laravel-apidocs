# API Docs

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

<p align="center">
<img src="https://user-images.githubusercontent.com/10015302/49337278-10868980-f64c-11e8-9bfe-29dc1c582911.png">
</p>

## Requirements

- Laravel 5.5 and above

## Installation

Via Composer

``` bash
$ composer require harlekoy/apidocs
```

After installing API Docs, publish its assets, and migration file using the `apidocs:install` Artisan command.

``` bash
$ php artisan apidocs:install
```

## Updating API Docs

When updating, you should re-publish API Docs's assets:

## Reread API routes from Laravel `route:list`

```
php artisan apidocs:routes
```

When updating, you should re-publish API Docs's assets:

``` bash
$ php artisan apidocs:publish
```

## Usage

Access your API documentation in you browser
```
/apidocs/list
```
> If you don't have any local server running in your machine, run this command first in you command line tool `php artisan serve` then it generate this `http://127.0.0.1:8000`. Now you can access the path with that hostname `http://127.0.0.1:8000/apidocs/list` enjoy using it 😄.

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email me@harlekoy.com instead of using the issue tracker.

## Credits

- [Harlequin Doyon][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/harlekoy/apidocs.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/harlekoy/apidocs.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/harlekoy/apidocs/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/harlekoy/apidocs
[link-downloads]: https://packagist.org/packages/harlekoy/apidocs
[link-travis]: https://travis-ci.org/harlekoy/apidocs
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/harlekoy
[link-contributors]: ../../contributors]