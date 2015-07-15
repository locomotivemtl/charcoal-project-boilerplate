Charcoal Project Boilerplate
============================

The goal of this project is to provide a fully working "boilerplate" (empty project) using the Charcoal framework.

## How to Install

To start a Charcoal project with this Boilerplate, simply:

1. **Clone the repositoy**
   - `$ git clone https://github.com/locomotivemtl/charcoal-project-boilerplate`
   - The project should be cloned in a web-accessible directory, but with the document root pointing directly to the [`www`](www/) directory.
2. **Rename the boilerplate to your project**
   - `$ php charcoal-cli.php boilerplate/rename`
3. **Set up a database storage**
   - `$ php charcoal-cli.php boilerplate/setup`
4. **Install dependencies**
   - `$ composer install`
   - `$ npm install`
   - `$ bower install`
5. **Build the project**
   - `$ grunt build`

> 👉 The `charcoal-cli` tool is provided to help running various scripts, many of which are provided by the `charcoal-admin` and `charcoal-base` modules.

## Dependencies and Requirements

There are 3 Charcoal modules, installable with Composer, typically used in a Charcoal project. They are:

- [locomotivemtl/charcoal-core](https://github.com/locomotivemtl/charcoal-core)

  The framework classes. (Cache, Model, Metadata, View, Property, source, etc.)
- [locomotivemtl/charcoal-base](https://github.com/locomotivemtl/charcoal-base)

  Base project classes: Assets, Objects, Properties, Templates and Widgets.
- [locomotivemtl/charcoal-admin](https://github.com/locomotivemtl/charcoal-admin)

  The backend module to easily create, edit and manage objects.

> 👉 As of now, those packages are not distributed by Packagist but still installable using Composer by specifiying the repositories. See the [`composer.json`](composer.json) file for details.

Which, in turn, require:

- **PHP** 5.5+
  - with [_PHP Generators_](http://php.net/generators) and the [`password_hash`](http://php.net/password-hash) methods.
  - [`slim`](http://www.slimframework.com/), [`flysystem`](http://flysystem.thephpleague.com/), [`mustache`](https://github.com/bobthecow/mustache.php) (see [`composer.json`](composer.json) for details)
- **MySQL**
  - with [_PDO_](http://php.net/pdo)
  - Other databases are currently not supported
- **Apache**
  - with _mod_rewrite_

## Build System(s)

Charcoal uses:

- [**Composer**](http://getcomposer.org/) is the preferred way of installing Charcoal modules and projects.
- [**Grunt**](http://gruntjs.com/) is used to build the assets from source and also to run various scripts (linters, unit tests) automatically.
  - The CSS is generated with [(lib)Sass](http://sass-lang.com/libsass)
- [**Bower**](http://bower.io/) is used for managing external dependencies.
- [**NPM**](https://npmjs.com/) is needed for Bower and Grunt.

## What's inside this Boilerplate?

Like all Charcoal projects / modules, the main components are:
- **Autoloader**
  - Provided by Composer.
- **Config**
  - As JSON or PHP files in the [`config/``](config/) directory.
- **Front Controller**
  - See [`www/.htaccess`](www/.htaccess) and [`www/index.php`](www/index.php) for details.
  - Also see [`src/Boilerplate/Module.php`](src/Boilerplate/Module.php) for more details.
  - The front controller typically binds `/admin` with the `charcoal-admin` module (although the actual path can be changed in Config)
- **CLI Front Controller**
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

### About the Document Root

The web server should be configured to serve the `www/` folder directly. The other folders (`vendor/`, `src/`, `templates/`, `metadata/`, `config/`, etc.) should therefore not be available from the web server (kept outside the document root).

## Development

### Coding Style

All Charcoal modules follow the same coding style and this boilerplate is no exception. For PHP:

- [_PSR-1_](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md), except for
  - Method names MUST be declared in `snake_case`.
- [_PSR-2_](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md), except for
  - Property names MAY be prefixed with a single, or double, underscore to indicate protected or private visibility;
  - Method names MAY be prefixed with a single, or double, underscore to indicate protected or private visibility.
- [_PSR-4_](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md), autoloading is therefore provided by _Composer_
- [_phpDocumentor_](http://phpdoc.org/)
  - Add DocBlocks for all classes, methods, and functions;
  - For type-hinting, use `boolean` (instead of `bool`), `integer` (instead of `int`), `float` (instead of `double` or `real`);
  - Omit the `@return` tag if the method does not return anything.
- Naming conventions
  - Use `snake_case` for variable, option, parameter, argument, function, and method names;
  - Prefix abstract classes with `Abstract`;
  - Suffix interfaces with `Interface`;
  - Suffix traits with `Trait`;
  - Suffix exceptions with `Exception`;
  - For type-hinting, use `int` (instead of `integer`) and `bool` (instead of `boolean`);
  - For casting, use `int` (instead of `integer`) and `!!` (instead of `bool` or `boolean`);
  - For arrays, use `[]` (instead of `array()`).

Coding styles are  enforced with `grunt phpcs` ([_PHP Code Sniffer_](https://github.com/squizlabs/PHP_CodeSniffer)). The actual ruleset can be found in `phpcs.xml`.

> 👉 To fix minor coding style problems, run `grunt phpcbf` ([_PHP Code Beautifier and Fixer_](https://github.com/squizlabs/PHP_CodeSniffer)). This tool uses the same ruleset as *phpcs* to automatically correct coding standard violations.

The main PHP structure follow the [_PSR-4_](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) standard. Autoloading is therefore provided by _Composer_.

For JavaScript, the following coding style is enforced:

- **TBD**

## Git Hooks

**TBD**

## Continuous Integration

- [Travis](https://travis-ci.org/)
- [Scrutinizer](https://scrutinizer-ci.com/)
- [Code Climate](https://codeclimate.com/)

### Unit Tests

Every class, method, and function should be covered by unit tests. PHP code can be tested with [_PHPUnit_](https://phpunit.de/) and JavaScript code with [_QUnit_](https://qunitjs.com/).
