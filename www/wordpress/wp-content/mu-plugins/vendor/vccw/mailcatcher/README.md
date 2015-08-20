# vccw/mailcatcher

[![Build Status](https://travis-ci.org/megumi-wp-composer/wp-disable-upgrade-notice.svg?branch=master)](https://travis-ci.org/vccw-team/mailcatcher) [![Latest Stable Version](https://poser.pugx.org/vccw/mailcatcher/v/stable.svg)](https://packagist.org/packages/vccw/mailcatcher) [![Total Downloads](https://poser.pugx.org/vccw/mailcatcher/downloads.svg)](https://packagist.org/packages/vccw/mailcatcher) [![Latest Unstable Version](https://poser.pugx.org/vccw/mailcatcher/v/unstable.svg)](https://packagist.org/packages/vccw/mailcatcher) [![License](https://poser.pugx.org/vccw/mailcatcher/license.svg)](https://packagist.org/packages/vccw/mailcatcher)

Re-routes all WordPress emails to Mailcatcher.

http://mailcatcher.me/


## How to use

### Place a plugin into mu-plugins

Place a plugins into `wp-content/mu-plugins` like following.

```
<?php
/*
Plugin Name: mu-plugin for example.com
*/

require_once dirname( __FILE__ ) . '/vendor/autoload.php';
```

### Create a composer.json

Create and place a composer.json into `wp-content/mu-plugins`.

```
{
    "name": "mu-plugins",
    "authors": [
        {
            "name": "John Smith",
            "email": "john@example.com"
        }
    ],
    "require": {
        "vccw/mailcatcher": "*"
    }
}
```

### Install libraries

Then run a `composer` command.

```
$ composer install
```

## How to development

```
$ git clone git@github.com:vccw-team/mailcatcher.git
$ cd mailcatche
$ composer install
```

### Running a PHPUnit

After you run a `composer install`, then run `phpunit`.

```
$ phpunit
```
