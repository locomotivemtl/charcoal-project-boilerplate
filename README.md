Charcoal Project Boilerplate
============================

The goal of this project is to provide a fully working "boilerplate" (empty _skeleton_ project) using the Charcoal framework.

It can also optionally set up the [Locomotive Boilerplate](https://github.com/locomotivemtl/locomotive-boilerplate) for the frontend.

# Table of Content

- [How to Install](#how-to-install)
    + [1. Installing boilerplate](#1-installing-boilerplate)
    + [2. Test your installation](#2-test-your-installation)
    + [3. Set up a database storage](#3-set-up-a-database-storage)
    + [4. Set the project name](#4-set-the-project-name)
    + [5. Set up `charcoal-admin`](#5-set-up-charcoal-admin)
    + [6. (Optional) Install `locomotive-boilerplate`](#6-optional-install-locomotive-boilerplate)
- [Going further](#going-further)
    + More config customizations
    + Creating a custom template
    + Using objects
    + Customizing the backend
- [Dependencies and requirements](#dependencies-and-requirements)
    + [The charcoal modules](#the-charcoal-modules)
        - [Status matrix](#status-matrix)
- [What's inside this Boilerplate](#whats-inside-this-boilerplate)
- [Development](#development)
    + [Development dependencies](#development-dependencies)
    + [Continuous Integration](#continuous-integration)
    + [Coding Style](#coding-style)
    + [Authors](#authors)

# Intended scope

Although it is fully ready to use, this boilerplate is still incomplete. 
It does not _yet_ showcase all of the Charcoal features and therefore require a lot of manual tinkering for options.

Here is a short "mission statement" of what is expected to be accomplished with this project:

- A fully automated setup process.
    - Optionally install `locomotive-boilerplate` for the frontend.
- Translation (l10n) fully working with `charcoal-translator`.
    - Default data also provided in english and french.
    - ...and spanish and more...
- A working "backend" with `charcoal-admin`.
    - User set up automatically.
    - With a default configuration that allows to manage CMS objects (sections, news, events, blogs, locations, etc.)
    - Permission system working and enabled.
    - Notification system working and enabled.
    - Revisioning system working and enabled.
    - Media library working and enabled.
    - Built-in help (doc) system working and enabled.
- A few default, common templates (mustache) built-in.
    - Home page, with a few options and widgets (like carousel) or similar.
    - News list / news details, with attachment support.
    - Calendar (event list) with ajax options / event details, with attachment support.
    - Blog / article details, with attachment support and options to enable comments, and ajax actions
    - Contact, with a contact form that saves to a database and send a confirmation email depending to category options, with ajax actions.
    - Map, with locations by categories.
- Metadata 100% fully working on every pages and for every objects.
    - Use objects' metadata information, which all are editable in `charcoal-admin`.
- Provide an optimized set of SEO features.
- Search enabled
    - Results returned for all types of cms objects (sections, news, events, blogs, locations, etc.)
    - Used keywords, which all are editable in `charcoal-admin`.
    - Also search in attachments.
    - Auto-complete enabled and working.
- 100% tested with PHPUnit.

# How to Install

To start a Charcoal project with this Boilerplate, simply:

## 1. **Installing boilerplate**

Charcoal uses the Composer `create-project` command to install the boilerplate:

```shell
★ composer create-project --prefer-dist locomotivemtl/charcoal-project-boilerplate acme
```

Replace "acme" with the desired directory name for your new project.

> **About the Document Root**
>
> 👉 The project should *not* be cloned directly in a web-accessible directory. 
> The web server should be configured to serve the `www/` folder directly (or through a symlink). 
> The other folders (`vendor/`, `src/`, `templates/`, `metadata/`, `config/`, etc.) should therefore not be available from the web server (kept outside the document root).


## 2. **Test your installation**

A quick server can be started using the PHP builtin server:

```shell
★ cd www
★ php -S localhost:8080
```

Point your browser to `http://localhost:8080/` and you should see the boilerplate's default home page.

![Boilerplate homepage](docs/images/boilerplate-home.png)

How to change the default page and add routes/templates is explained later in this README. 

> Hint: the recommended way is from the admin, by adding pages (sections).

## 3. **Set up a database storage**

The next step requires a custom configuration file. 
It is recommended to use `config/config.local.json` and making sure it is not committed to source control:

```shell
★ cp config/config.sample.json config/config.local.json
```

Then edit the `config/config.local.json` file with this information.

If your project does not require any database storage, use a database in memory such as SQLite by adding the following to the `config/config.local.json` file:

```json
{
    "databases": {
        "default": {
            "type": "sqlite",
            "database": ":memory:"
        }
    },
    "default_database": "default"
}
```

If your project uses MySQL, create an empty database and ensure a SQL user has the proper permissions for this database. Then add the following to the `config/config.local.json` file:

```json
{
    "databases": {
        "default": {
            "type": "mysql",
            "hostname": "127.0.0.1",
            "database": "foobar",
            "username": "foo_bar",
            "password": "F00$BâR123"
        }
    },
    "default_database": "default"
}
```

## 4. **Set the project name**

By default, the project is named "Acme" and namespaced under `App` and is autoloaded by Composer using the [PSR-4 autoloading standard](https://www.php-fig.org/psr/psr-4/).

There are a few occurrences of "Acme" in the boilerplate:

- [config/admin.json](config/admin.json): See `admin.title`.
- [config/config.json](config/config.json): See `project_name`.

You should also change the name of the Composer package:

- [composer.json](composer.json): See `name`.

## 5. **Set up charcoal-admin**

A quick-and-dirty script is provided to install charcoal-admin automatically:

```shell
★ sh ./build/scripts/install-charcoal-admin.sh
```

Point your browser to http://localhost:8080/admin and you should see the Charcoal's admin login screen.

![Admin login](docs/images/admin-login.png)

The next step to customize the _backend_ is to configure the main menu, as well as the various admin options. 
See the `config/admin.json` file for details. 

> Refer to the `charcoal-admin` help for more information.


## 6. **(Optional) Install `locomotive-boilerplate`)**

Another quick-and-dirty script is provided to install the locomotive frontend, from its github repository.

```shell
★ sh ./build/scripts/install-locomotive-boilerplate.sh
```

> For more information about the `locomotive-boilerplate` frontend module: 
> visit [https://github.com/locomotivemtl/locomotive-boilerplate](https://github.com/locomotivemtl/locomotive-boilerplate)


# Dependencies and Requirements

- [`PHP 7.1+`](http://php.net)
    + `ext-json`
    + `ext-pdo`
    + `ext-spl`
    + `ext-mbstring`

## External libraries

Most Charcoal features are built on top of proven, open-source technologies:

- **Composer** (Deployment and auto-loading)
- **Slim** (PSR-7 App Framework)
- **FastRoute** (Router)
- **Pimple** (DI Container, from symfony)
- **Mustache** (Templating Engine)
  - Optionally supports **Twig**, from symfony
- **PDO / MySQL** (Database Storage)
- **Stash** (PSR-6 Cache)
- **CLImate** (Terminal Utility, from the php league)
- **Flysystem** (File system abstraction, from the php league)
- **Symfony Translation** (Localization Tools)
- **Laminas ACL** (Permissions Management)
- **PHPmailer** (Email Transport)
- **Monolog** (PSR-3 Logger)
- **PHPUnit** (Unit Testing)
- **APIGen** (API Documentation)
- **PHP Code Sniffer** (Coding Standards)
- **jQuery** (Javascript Framework)
- **Bootstrap** (CSS Framework)
- **TinyMCE** (HTML Editor)
- **elFinder** (File Manager)
- **Github** (Source control)
- **Travis** (Continuous Integration)

## The Charcoal modules

- [charcoal-admin](https://github.com/locomotivemtl/charcoal-admin)
    + The backend, or control panel.
- [charcoal-app](https://github.com/locomotivemtl/charcoal-app)
    + App components based on Slim.
- [charcoal-attachment](https://github.com/locomotivemtl/charcoal-attachment)
    + Additional attachments to content objects.
- [charcoal-cms](https://github.com/locomotivemtl/charcoal-cms)
    + CMS objects (Section, News, Events, etc.)
- [charcoal-config](https://github.com/locomotivemtl/charcoal-config)
    + Base configuration system.
- [charcoal-core](https://github.com/locomotivemtl/charcoal-core)
    + Core objects, Model, Source.
- [charcoal-email](https://github.com/locomotivemtl/charcoal-email)
    + Email utilities, based on phpmailer.
- [charcoal-factory](https://github.com/locomotivemtl/charcoal-factory)
    + Dynamic objects creation.
- [charcoal-image](https://github.com/locomotivemtl/charcoal-image)
    + Image manipulation and effects.
- [charcoal-object](https://github.com/locomotivemtl/charcoal-object)
    + Object definition (Content and UserData; based on Model), behaviors and tools.
- [charcoal-property](https://github.com/locomotivemtl/charcoal-property)
    + Metadata's properties.
- [charcoal-translator](https://github.com/locomotivemtl/charcoal-translator)
    + Translation utilities, based on Symfony.
- [charcoal-ui](https://github.com/locomotivemtl/charcoal-ui)
    + Ui objects (Form, Menu, Dashboard, Layout, etc.)
- [charcoal-user](https://github.com/locomotivemtl/charcoal-user)
    + User definition, authentication and authorization (based on Laminas ACL).
- [charcoal-validator](https://github.com/locomotivemtl/chracoal-validator)
    + Data validation.
- [charcoal-view](https://github.com/locomotivemtl/charcoal-view)
    + View renderer. (mustache, twig, etc.)

### Status matrix

| Module                   | Version | Travis | Scrutinizer | Insights | Coveralls | PHPDoc | ApiGen |
| ------------------------ | ------- | ------ | ----------- | -------- | --------- | ------ | ------ |
| **admin**       | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-admin.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-admin.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-admin) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-admin/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-admin/?branch=master) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/00402be5-f8bb-4279-89b8-3e1e3248178a/mini.png)](https://insight.sensiolabs.com/projects/00402be5-f8bb-4279-89b8-3e1e3248178a) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-admin/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-admin?branch=master)  | [PHPDoc](http://locomotivemtl.github.io/charcoal-admin/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-admin/apigen/master/) |
| **app**         | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-app.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-app.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-app) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-app/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-app/?branch=master) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/533b5796-7e69-42a7-a046-71342146308a/mini.png)](https://insight.sensiolabs.com/projects/533b5796-7e69-42a7-a046-71342146308a) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-app/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-app?branch=master) | [PHPDoc](http://locomotivemtl.github.io/charcoal-app/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-app/apigen/master/) |
| **attachment**  | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-attachment.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-attachment.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-attachment) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-attachment/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-attachment/?branch=master) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/09876d95-da9d-4c23-896f-904be3368c99/mini.png)](https://insight.sensiolabs.com/projects/09876d95-da9d-4c23-896f-904be3368c99) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-attachment/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-attachment?branch=master) | [PHPDoc](http://locomotivemtl.github.io/charcoal-attachment/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-attachment/apigen/master/) |
| **cms**         | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-cms.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-cms.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-cms) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-cms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-cms/?branch=master) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/44d8d264-207b-417d-bcbd-dd52274fc201/mini.png)](https://insight.sensiolabs.com/projects/44d8d264-207b-417d-bcbd-dd52274fc201) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-cms/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-cms?branch=master)  | [PHPDoc](http://locomotivemtl.github.io/charcoal-cms/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-cms/apigen/master/) |
| **config**      | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-config.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-config.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-config) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-config/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-config/?branch=master) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/27ad205f-4208-4fa6-9dcf-534b3a1c0aaa/mini.png)](https://insight.sensiolabs.com/projects/27ad205f-4208-4fa6-9dcf-534b3a1c0aaa) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-config/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-config?branch=master)  | [PHPDoc](http://locomotivemtl.github.io/charcoal-config/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-config/apigen/master/) |
| **core**        | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-core.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-core.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-core) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-core/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-core/?branch=master) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/ab15f6b0-2063-445e-81d7-2575b919b0ab/mini.png)](https://insight.sensiolabs.com/projects/ab15f6b0-2063-445e-81d7-2575b919b0ab) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-core/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-core?branch=master) | [PHPDoc](http://locomotivemtl.github.io/charcoal-core/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-core/apigen/master/) |
| **email**       | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-email.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-email.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-email) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-email/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-email/?branch=master) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/54058388-3b5d-47e3-8185-f001232d31f7/mini.png)](https://insight.sensiolabs.com/projects/54058388-3b5d-47e3-8185-f001232d31f7) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-email/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-email?branch=master) | [PHPDoc](http://locomotivemtl.github.io/charcoal-email/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-email/apigen/master/) |
| **factory**     | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-factory.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-factory.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-factory) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-factory/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-factory/?branch=master) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/0aec930b-d696-415a-b4ef-a15c1a56509e/mini.png)](https://insight.sensiolabs.com/projects/0aec930b-d696-415a-b4ef-a15c1a56509e) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-factory/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-factory?branch=master)  | [PHPDoc](http://locomotivemtl.github.io/charcoal-factory/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-factory/apigen/master/) |
| **image**       | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-image.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-image.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-image) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-image/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-image/?branch=master) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/87c9621d-3b2e-4e71-a42f-e69ebca4672e/mini.png)](https://insight.sensiolabs.com/projects/87c9621d-3b2e-4e71-a42f-e69ebca4672e) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-image/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-image?branch=master)  | [PHPDoc](http://locomotivemtl.github.io/charcoal-image/docs/master/) |  [ApiGen](http://locomotivemtl.github.io/charcoal-image/apigen/master/) |
| **object**      | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-object.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-object.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-object) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-object/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-object/?branch=master) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/ef771c49-8c05-448b-a112-069737b380dc/mini.png)](https://insight.sensiolabs.com/projects/ef771c49-8c05-448b-a112-069737b380dc) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-property/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-property?branch=master) | [PHPDoc](http://locomotivemtl.github.io/charcoal-object/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-object/apigen/master/) |
| **presenter**    | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-presenter.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-presenter.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-property) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-presenter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-presenter/?branch=master) | - | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-presenter/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-presenter?branch=master) | [PHPDoc](http://locomotivemtl.github.io/charcoal-presenter/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-presenter/apigen/master/) |
| **property**    | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-property.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-property.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-property) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-property/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-property/?branch=master) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/f3bdff38-c300-4207-8342-da002e64a6e1/mini.png)](https://insight.sensiolabs.com/projects/f3bdff38-c300-4207-8342-da002e64a6e1) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-property/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-property?branch=master) | [PHPDoc](http://locomotivemtl.github.io/charcoal-property/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-property/apigen/master/) |
| **queue**    | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-queue.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-queue.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-queue) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-queue/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-queue/?branch=master) | - | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-queue/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-queue?branch=master) | [PHPDoc](http://locomotivemtl.github.io/charcoal-queue/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-queue/apigen/master/) |
| **translator**  | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-translator.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-translator.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-translator) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-translator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-translator/?branch=master) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/2758c820-e73a-4d0e-b746-552a3e3a92fa/mini.png)](https://insight.sensiolabs.com/projects/2758c820-e73a-4d0e-b746-552a3e3a92fa) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-translator/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-translator?branch=master)  | [PHPDoc](http://locomotivemtl.github.io/charcoal-translator/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-translator/apigen/master/) |
| **ui**          | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-ui.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-ui.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-ui) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-ui/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-ui/?branch=master) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/ad5d1699-07cc-45b5-9ba4-9b3b45f677e0/mini.png)](https://insight.sensiolabs.com/projects/ad5d1699-07cc-45b5-9ba4-9b3b45f677e0) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-ui/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-ui?branch=master)  | [PHPDoc](http://locomotivemtl.github.io/charcoal-ui/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-ui/apigen/master/) |
| **user**        | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-user.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-user.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-user) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-user/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-user/?branch=master) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/5b05fad5-5e2d-41d3-acd3-12822b354892/mini.png)](https://insight.sensiolabs.com/projects/5b05fad5-5e2d-41d3-acd3-12822b354892) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-ui/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-ui?branch=master)  | [PHPDoc](http://locomotivemtl.github.io/charcoal-user/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-user/apigen/master/) |
| **validator**        | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-validator.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-validator.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-view) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-validator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-vialidator/?branch=master) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/5c21a1cf-9b21-41c8-82a8-90fbad808a20/mini.png)](https://insight.sensiolabs.com/projects/5c21a1cf-9b21-41c8-82a8-90fbad808a20) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-validator/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-validator?branch=master)  | [PHPDoc](http://locomotivemtl.github.io/charcoal-validator/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-validator/apigen/master/) |
| **view**        | ![version](https://img.shields.io/github/tag/locomotivemtl/charcoal-view.svg?style=flat&label=release) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-view.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-view) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-view/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-view/?branch=master) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/396d2f06-82ba-4c79-b8cc-762f1e8bda29/mini.png)](https://insight.sensiolabs.com/projects/396d2f06-82ba-4c79-b8cc-762f1e8bda29) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-view/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-view?branch=master)  | [PHPDoc](http://locomotivemtl.github.io/charcoal-view/docs/master/) | [ApiGen](http://locomotivemtl.github.io/charcoal-view/apigen/master/) |


# What's inside this Boilerplate?

Like all Charcoal projects / modules, the main components are:

- **Autoloader**
    - Provided by Composer.
- **Config**
    - As JSON or PHP files in the [`config/`](config/) directory.
    - Use [`locomotivemtl/charcoal-config`](https://github.com/locomotivemtl/charcoal-config)
- **Front Controller**
    - See [`www/.htaccess`](www/.htaccess) and [`www/index.php`](www/index.php) for details.
    - Route dispatcher
        - See [`config/routes.json`](config/routes.json) for route configuration.
- **Script Controller (Charoal Binary)**
    - Installed from `charcoal-app` as `vendor/bin/charcoal`.
    - Many useful scripts are provided with the `charcoal-admin` module.
- **PHP scripts**
    - PSR-1, PSR2 and PSR-4 compliant scripts are located in [`src/`](src/)
    - There are typically 3 types of controllers:
        - _Templates_
        - _Actions_
        - _Scripts_
    - ... 2 types of object
        - Objects based on _Content_
        - Objects based on _UserData_
    - ... and all other types of scripts (services, helpers, configs, factories, etc.)
- **Assets**
    - Assets are files required to be on the webserver root
    - Scripts, in `src/scripts/` and compiled in `www/assets/scripts/`
    - Styles , with Sass in `src/styles/` and compiled CSS in `www/assets/styles/`
    - Images, in `www/assets/images/`


# Development

To install the development environment:

```shell
★ composer install --prefer-source
```

To run the scripts (phplint, phpcs and phpunit):

```shell
★ composer test
```

## Development dependencies

- `phpunit/phpunit`
- `squizlabs/php_codesniffer`
- `satooshi/php-coveralls`

## Continuous Integration

| Service | Badge | Description |
| ------- | ----- | ----------- |
| [Travis](https://travis-ci.org/locomotivemtl/charcoal-project-boilerplate) | [![Build Status](https://travis-ci.org/locomotivemtl/charcoal-project-boilerplate.svg?branch=master)](https://travis-ci.org/locomotivemtl/charcoal-project-boilerplate) | Runs code sniff check and unit tests. Auto-generates API documentation. |
| [Scrutinizer](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-project-boilerplate/) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-project-boilerplate/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/locomotivemtl/charcoal-project-boilerplate/?branch=master) | Code quality checker. Also validates API documentation quality. |
| [Coveralls](https://coveralls.io/github/locomotivemtl/charcoal-project-boilerplate) | [![Coverage Status](https://coveralls.io/repos/github/locomotivemtl/charcoal-project-boilerplate/badge.svg?branch=master)](https://coveralls.io/github/locomotivemtl/charcoal-project-boilerplate?branch=master) | Unit Tests code coverage. |
| [Sensiolabs](https://insight.sensiolabs.com/projects/533b5796-7e69-42a7-a046-71342146308a) | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/533b5796-7e69-42a7-a046-71342146308a/mini.png)](https://insight.sensiolabs.com/projects/533b5796-7e69-42a7-a046-71342146308a) | Another code quality checker, focused on PHP. |

## Coding Style

The charcoal-project-boilerplate module follows the Charcoal coding-style:

- [_PSR-1_](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md)
- [_PSR-2_](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
- [_PSR-4_](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md), autoloading is therefore provided by _Composer_.
- [_phpDocumentor_](http://phpdoc.org/) comments.
- Read the [phpcs.xml](phpcs.xml) file for all the details on code style.

> Coding style validation / enforcement can be performed with `composer phpcs`. An auto-fixer is also available with `composer phpcbf`.

## Authors

- [Locomotive, a Montreal Web agency](https://locomotive.ca)
