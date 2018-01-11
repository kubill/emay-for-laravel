EmaySMS
=====
亿美短信接口轮子

Installation
------------

Install using composer:

```bash
composer require kubill/emay-for-laravel
```

Laravel version < 5.5 (optional)
------------------

Add the service provider in `config/app.php`:

```php
Kubill\Emay\EmayServiceProvider::class,
```

And add the Agent alias to `config/app.php`:

```php
'Emay' => Kubill\Emay\Facades\Emay::class,
```

Basic Usage
-----------

Start by creating an `Emay` instance (or use the `Emay` Facade if you are using Laravel):

```php
use Kubill\Emay\Emay;

$emay = new Emay();
$emay->send(138xxxxxxxx,'hello world');
```

## License

Laravel User Agent is licensed under [The MIT License (MIT)](LICENSE).
