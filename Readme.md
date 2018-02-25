# Sauls Components Bundle

[![Build Status](https://travis-ci.org/sauls/components-bundle.svg?branch=master)](https://travis-ci.org/sauls/components-bundle)
[![Packagist](https://img.shields.io/packagist/v/sauls/components-bundle.svg)](https://packagist.org/packages/sauls/components-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/sauls/components-bundle.svg)](https://packagist.org/packages/sauls/components-bundle)
[![Coverage Status](https://img.shields.io/coveralls/github/sauls/components-bundle.svg)](https://coveralls.io/github/sauls/components-bundle?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sauls/components-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sauls/components-bundle/?branch=master)
[![License](https://img.shields.io/github/license/sauls/components-bundle.svg)](https://packagist.org/packages/sauls/components-bundle)

All Sauls components bundle for Symfony framework.

This bundle integrates the following packages:
* [sauls/helpers](https://github.com/sauls/helpers)
* [sauls/widget](https://github.com/sauls/widget)
* [sauls/collections](https://github.com/sauls/collections)
* [sauls/options-resolver](https://github.com/sauls/options-resolver)

## Requirements

PHP >= 7.2

## Installation

### Using composer
```bash
$ composer require sauls/components-bundle
```
> If you are using Symfony flex the bundle will be auto registered.

### Apppend the composer.json file manually
```json
{
    "require": {
        "sauls/components-bundle": "^1.0"
    }
}
```

## Register bundle

If you are using symfony/flex the bundle will be auto registered for  you. Otherwise append your bundles.php file.

```php
return [
    // ...
    new Sauls\Bundle\Components\SaulsComponentsBundle:class => ['all'],
    //...
];

```

## Full configuration

```yaml

sauls_components:
    helpers: ~ # default true
    widgets: ~ # default true
```

## Helpers in twig

```twig

{{ '2018-01-12'|elapsed }}
{{ '2017-12-31'|countdown('2018-01-01') }}
{{ 'weird_string'|camelize }}
{{ 'AnotherWeirdString'|snakeify }}
{% set ms = 'super,duper#string'|multi_split([',', '#']) %}
{{ 'test&nottest=2'|base64_url_encode }}
{{ 'dGVzdCZub3R0ZXN0PTI='|base64_url_decode }}
```

## Widgets support

Create your widget(s)

```php

class MyWidget extends Widget
{
    // Implement methods or add your own logic
}

class MyViewWidget extends ViewWidget
{
    // Implement methods or add your own logic
}

```

Register them to container

```yaml

services:
    MyWidget: 
      tags: ['sauls_widget.widget']
    MyViewWidget: 
      tags: ['sauls_widget.widget']
```

Or if you are using autowire feature, you don't need to do anything it will be added automatically.

## Views

Create your own view(s)

```php
use Sauls\Component\Widget\View\ViewInterface;

class MyView implements ViewInterface
```

Register them to container

```yaml
services:
    MyWiew:
      tags: ['sauls_widget.view']
```

Or if you are using autowire feature, you don't need to do anything it will be added automatically.

## Additional collection type converters

Create your converter(s)

```php
use Sauls\Component\Helper\Operation\TypeOperation\Converter\ConverterInterface;

class IntToStringConverter implements ConverterInterface
{
    // Implement the methods
}
```

Register them to container

```yaml
services:
    IntToStringConverter:
      tags: ['sauls_collection.converter']
```

Or if you are using autowire feature, you don't need to do anything it will be added automatically.

After that you can use your new converter `convert_to(1, 'string')`.
