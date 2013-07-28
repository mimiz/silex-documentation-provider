Silex Documentation Provider
============================

[![Build Status](https://travis-ci.org/mimiz/silex-documentation-provider.png)](https://travis-ci.org/mimiz/silex-documentation-provider)

 This Provider allows you to create a project documentation folder where you will be able to write all the documentation
 needed for developpers, for example describe the .htaccess file, or describe the directory structure, or even some
 development rules.

 **NOTE** : This is still in development and there's no stable release ...

Installation
------------

Install the silex-documentation-provider using [composer](http://getcomposer.org/).  This project uses [sematic versioning](http://semver.org/).

```json
{
    "require": {
        "mimiz/silex-documention-provider": "~0.0.1"
    }
}
```

 Then you'll need to choose a renderer, currently this support : [Textile](http://en.wikipedia.org/wiki/Textile_(markup_language), [Markdown](http://en.wikipedia.org/wiki/Markdown), or plain text.

 So if you want to use [Markdown](http://en.wikipedia.org/wiki/Markdown) Syntax, you will need to add the [Markdown](http://en.wikipedia.org/wiki/Markdown) Dependency in your **composer.json** file


```json
{
    "require": {
        "mimiz/silex-documention-provider": "~0.0.1",
        "michelf/php-markdown": "1.3"
    }
}
```

 And here is the **composer.json** file if you want to use [Textile](http://en.wikipedia.org/wiki/Textile_(markup_language)

```json
{
    "require": {
        "mimiz/silex-documention-provider": "~0.0.1",
        "netcarver/textile": "v3.5.1"
    }
}
```


Usage
-----

```php
$app->register(new \Mimiz\Silex\Provider\DocumentationProvider(), array(
    "documentation.dir" => __DIR__."/../documentation",
    "documentation.url" => '/doc',
    "documentation.extension" => 'md',
    "documentation.home"=>'index',
    "documentation.syntax"=>'markdown',
    "documentation.title"=>'My Documentation',
    "documentation.styles" => array('/components/bootstrap/css/bootstrap.min.css'),
    "documentation.scripts" => array('/components/jquery/jquery.min.js','/components/bootstrap/js/bootstrap.min.js')
));
```

### Parameters


 * __documentation.dir__
    > Path to the directory that contains your documentation files

 * __documentation.url__
    > The base URL of your documentation

 * __documentation.extension__
    > The file extension you used for documentation files

 * __documentation.home__
    > The name of the Home page, this will be used for each subdirectories

 * __documentation.syntax__
    > The syntax you want to use
    > Available : markdown,textile, plain

 * __documentation.title__
    > The title of the documentation Page (only for HTML Renderers like textile or markdown)

 * __documentation.styles__

    > An array of css urls to add to your documentations

    ```php
    array('/components/bootstrap/css/bootstrap.min.css')
    ```

 * __documentation.scripts__
    > An array of js urls to add to your documentations

    ```php
    array('/components/jsquery/jquery.min.js', '/components/bootstrap/js/bootstrap.min.js')
    ```

License
-------

This software is licensed under [MIT](http://rgoyard.mit-license.org/)