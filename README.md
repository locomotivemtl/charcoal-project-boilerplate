Charcoal Project Boilerplate
============================

The goal of this project is to provide a fully working "boilerplate" (empty project) using the Charcoal framework.

# How to install

To start a Charcoal project with this Boilerplate, simply:

- **Clone the repositoy**
  - `git clone https://github.com/locomotivemtl/charcoal-project-boilerplate`
  - The project should be cloned in a web-accessible directory, but with the document root pointing directly to the [www](www/) folder.
- **Rename the boilerplate to your project**
  - `php charcoal-cli.php boilerplate/rename`
- **Set up a database storage** 
  - `php charcoal-cli.php boilerplate/setup` 
- **Install the various dependencies (composer, npm, bower)**
  - `composer install`
  - `npm install`
  - `bower install`
- **Build the project**
  - `grunt build`

> 👉 The `charcoal-cli` tool is provided to help running various scripts, many of which are provided by the `charcoal-admin` and `charcoal-base` modules.

## Charcoal dependencies

There are 3 Charcoal modules, installable with Composer, typically used in a Charcoal project. They are:
- [locomotivemtl/charcoal-core](https://github.com/locomotivemtl/charcoal-core)
  - The framework classes. (Cache, Model, Metadata, View, Property, source, etc.)
- [locomotivemtl/charcoal-base](https://github.com/locomotivemtl/charcoal-base)
  - Base project classes: Assets, Objects, Properties, Templates and Widgets. 
- [locomotivemtl/charcoal-admin](https://github.com/locomotivemtl/charcoal-admin)
  - The backend module to easily create, edit and manage objects.

> 👉 As of now, those packages are not distributed by Packagist but easily installable by Composer by specifiying the repository. Read the [composer.json](composer.json) file for details.

Which, in turn, require:
- PHP 5.5+
  - Charcoal uses _PHP Generators_ and the `password_hash` methods.
- MySQL (with PDO)
  - Other databases are currently not supported
- Apache with mod_rewrite
- `slim`, `mustache`, `flysystem`
  - See [composer.json](composer.json) for details.

## Build system(s)

`composer` is the preferred way of installing Charcoal.

`grunt` is used to build the assets from source and also run the various scripts (linters, unit tests) automatically.

The external javascript dependencies are managed with `bower`.

The CSS is generated with `sass`.

# What's inside this Boilerplate?

Like all Charcoal projects / modules, the main components are:
- **Autoloader**
  - Provided by Composer.
- **Config**
  - As JSON or PHP files in the [config/](config/) directory.
- **Front Controller**
  - See [www/.htaccess](www/.htaccess) and [www/index.php](www/index.php) for details.
  - Also see [src/Boilerplate/Module.php](src/Boilerplate/Module.php) for more details.
  - The front controller typically binds _/admin_ with the `charcoal-admin` module (although the actual path can be changed in Config)
- **CLI Front Controller**
  - See [charcoal-cli.php](charcoal-cli.php) for details. 
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
  - Styles , with SASS in `src/styles/` and compiled CSS in `www/assets/styles/`
  - Images, in `www/assets/images/`

## About the Document Root

The web server should be configured to serve the `www/` folder directly. The other folders (`vendor/`, `src/`, `templates/`, `metadata/`, `config/`, etc.) should therefore not be available from the web server (kept outside the document root).

# Development

## Coding style

Like `charcoal-core` and other Charcoal modules, this boilerplate use the following coding style for PHP:
- PSR-1, except for the CamelCaps method name rule
  - Charcoal method names are *snake_case*
- PSR-2
- array should be written in short notation (`[]` instead of `array()`)
- Docblocks for `phpdocumentor`

Coding styles are  enforced with `grunt phpcs` (PHP Code Sniffer). The actual ruleset can be found in [phpcs.xml][phpcs.xml].

> 👉 To fix minor coding style problems, run `grunt phpcbf` (PHP Code Beautifier and Fixer). This tool use the same ruleset to try and fix what can be don automatically.

For Javascript, the following coding style is enforced:
- **todo**

## Git Hooks

## Continuous Integration

## Unit tests
