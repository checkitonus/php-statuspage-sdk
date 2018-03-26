StatusPage API
=================

[![CheckItOn.Us Logo](https://www.checkiton.us/img/mono-logo.png)](https://www.checkiton.us)

[![Build Status](https://travis-ci.org/checkitonus/php-statuspage-sdk.svg?branch=master)](https://travis-ci.org/checkitonus/php-statuspage-sdk)

Easy to use StatusPage API implementation.

# Installation

```
$ composer require checkitonus/statuspage-sdk
```

```
{
    "require": {
        "checkitonus/statuspage-api": "master"
    }
}
```

Then, in your PHP file, all you need to do is require the autoloader:

```php
require_once 'vendor/autoload.php';

use CheckItOnUs\StatusPage\Server;

$server = new Server([
    'api_key' => 'API-KEY',
    'base_url' => 'https://api.statuspage.io/v1/pages'
]);

// Should return your first component
echo $server->components()->first()->toApi();
```

# API Components

Once installed, you will have access to several objects all of which will hit the API and retrieve the data as needed.

Please Note: Although all of these samples are using the `Component` class, they are available for the following objects:

* CheckItOnUs\StatusPage\Component
* CheckItOnUs\StatusPage\Incident

```php
require_once 'vendor/autoload.php';

use CheckItOnUs\StatusPage\Server;
use CheckItOnUs\StatusPage\Component;

$server = new Server([
    'api_key' => 'API-KEY',
]);

// Find a component based on the name
$component = Component::on($server)->findByName('API');

// Find a component based on the ID
$component = Component::on($server)->findById(1);

// Find all components
Component::on($server)->all();
```

## CRUD Operations

### Creation

```php
require_once 'vendor/autoload.php';

use CheckItOnUs\StatusPage\Server;
use CheckItOnUs\StatusPage\Component;

$server = new Server([
    'api_key' => 'API-KEY',
]);

// Fluent API
$component = (new Component($server))
                ->setName('Name Here')
                ->setStatus(Component::OPERATIONAL)
                ->create();
```

### Update

```php
require_once 'vendor/autoload.php';

use CheckItOnUs\StatusPage\Server;
use CheckItOnUs\StatusPage\Component;

$server = new Server([
    'api_key' => 'API-KEY',
]);

// Fluent API
Component::on($server)
    ->findById(1)
    ->setName('Name Here')
    ->setStatus(Component::OPERATIONAL)
    ->update();
```

### Delete

```php
require_once 'vendor/autoload.php';

use CheckItOnUs\StatusPage\Server;
use CheckItOnUs\StatusPage\Component;

$server = new Server([
    'api_key' => 'API-KEY',
]);

// Fluent API
Component::on($server)
    ->findById(1)
    ->delete();
```
