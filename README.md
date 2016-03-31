Charcoal Project Boilerplate
============================

The goal of this project is to provide a fully working "boilerplate" (empty project) using the Charcoal framework.

# How to Install

To start a Charcoal project with this Boilerplate, simply:

## 1. **Create / clone the project boilerplate**

```shell
$ composer create-project locomotivemtl/charcoal-project-boilerplate --prefer-source
```

The project should not be cloned directly in a web-accessible directory, but instead with the web document root pointing directly to the [`www`](www/) directory.

## 2. **Rename the boilerplate to your project**

```shell
$ ./vendor/bin/charcoal boilerplate/rename
```

## 3. **Set up a database storage**

```shell
$ ./vendor/bin/charcoal boilerplate/setup
```

## 4. **Set up charcoal-admin**

```shell
$ cd vendor/locomotivemtl/charcoal-admin
$ npm install
$ bower install
$ grunt
$ cd -
```

> 👉 The `./vendor/bin/charcoal` CLI tool, provided by `charcoal-app` is required to run various scripts, many of which are provided by the `charcoal-admin` and `charcoal-base` modules.

## Dependencies and Requirements

- [`PHP 5.5+`](http://php.net)
- [`locomotivemtl/charcoal-app`](https://github.com/locomotivemtl/charcoal-app)

# What's inside this Boilerplate?

Like all Charcoal projects / modules, the main components are:
- **Autoloader**
  - Provided by Composer.
- **Config**
  - As JSON or PHP files in the [`config/``](config/) directory.
- **Front Controller**
  - See [`www/.htaccess`](www/.htaccess) and [`www/index.php`](www/index.php) for details.
  - The front controller typically binds `/admin` with the `charcoal-admin` module (although the actual path can be changed in Config)
- **Script Controller (Charoal Binary)**
  - See [`charcoal-cli.php`](charcoal-cli.php) for details.
- **Objects**
  - Typically extends either `\Charcoal\Object\Content` or `\Charcoal\Object\UserData` (both from `charcoal-base`)
  - Extends `\Charcoal\Model\AbstractModel`, which implements the following interface:
      - `\Charcoal\Model\ModelInterface`
      - `\Charcoal\Core\IndexableInterface`
      - `\Charcoal\Metadata\DescribableInterface`
      - `\Charcoal\Source\StorableInterface`
      - `\Charcoal\Validator\ValidatableInterface`
      - `\Charcoal\View\ViewableInterface`
        - (all from `charcoal-core`)
  - PHP Models in `src/Charcoal/Boilerplate/`
  - JSON metadata in `metadata/charcoal/boilerplate/`
- **Templates**
  - Templates are specialized Model which acts as View / Controller
  - Split in `Templates`, `Widgets` and `PropertyInput`
    - All defined in the `charcoal-base` module
    - All those classes extend `\Charcoal\Model\AbstractModel`
  - PHP Models in `src/Charcoal/Boilerplate/Template/`
  - Mustache views (templates) in `templates/boilerplate/`
  - Optionnally, templates metadata in `metdata/boilerplate/template/`
- **Actions**
  - Actions handle input and provide a response
  - The PHP classes in `src/Charcoal/Boilerplate/Action`
- **Assets**
  - Assets are files required to be on the webserver root
  - Scripts, in `src/scripts/` and compiled in `www/assets/scripts/`
  - Styles , with Sass in `src/styles/` and compiled CSS in `www/assets/styles/`
  - Images, in `www/assets/images/`

## About the Document Root

The web server should be configured to serve the `www/` folder directly. The other folders (`vendor/`, `src/`, `templates/`, `metadata/`, `config/`, etc.) should therefore not be available from the web server (kept outside the document root).


# Development

To install the development environment:

```shell
★ composer install --prefer-source
```

Run the code checkers and unit tests with:

```shell
★ composer test
```

## Development dependencies

- `phpunit/phpunit`
- `squizlabs/php_codesniffer`
- `satooshi/php-coveralls`

## Coding Style

All Charcoal modules follow the same coding style and this boilerplate is no exception.

- [_PSR-1_](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md)
- [_PSR-2_](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
- [_PSR-4_](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md), autoloading is therefore provided by _Composer_.
- [_phpDocumentor_](http://phpdoc.org/) comments.
- Read the [phpcs.xml](phpcs.xml) file for all the details on code style.

> Coding style validation / enforcement can be performed with `composer phpcs`. An auto-fixer is also available with `composer phpcbf`.

