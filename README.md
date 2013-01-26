ResqueEnqueuer
==============

A library that lets you enqueue Resque jobs from a PHP application.

Requirements
------------

- php >= 5.3.3 (>= 5.4 in order to be able to run the tests)
- phpredis

Installation
------------

Create a composer.json file with the following content:

``` json
{
    "require": {
        "italiansubs/resque-enqueuer": "0.1.*"
    }
}
```

Then run

``` bash
$ curl -s https://getcomposer.org/installer | php
$ php composer.phar install
```

You should now have ResqueEnqueuer installed inside your vendor folder: *vendor/italiansubs/resque-enqueuer*

And an handy autoload file to include in you project: *vendor/autoload.php*

How to use
----------

``` php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use ResqueEnqueuer\Enqueuer;

$enq = new Enqueuer(); // $redisHost, $redisPort, $redisDb, $resqueBaseKeyName

$enq->enqueue('queue_name', 'job_name', array('id_user' => 100, 'other_param' => 'foo'));
```

Testing
-------

The library is fully tested with PHPUnit.

Go to the base library folder and install the dev dependencies with composer, and then run the phpunit test suite

``` bash
$ composer --dev install
$ ./vendor/bin/phpunit --colors test
```

Thanks
------

Many thanks to the great folks that developed and are contributing to the absolutely awesome tool that is Resque!

Also props to my friend and colleague [Matteo Giachino](https://github.com/matteosister) that pushed me to open source
my first project and from whom I pretty much copied this readme structure.
