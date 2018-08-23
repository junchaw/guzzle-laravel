# guzzle-laravel

[![Total Downloads](https://poser.pugx.org/wbswjc/guzzle-laravel/downloads)](https://packagist.org/packages/wbswjc/guzzle-laravel)

Customized guzzle client.

提供了 3 个方法, 用于发起请求并尝试使用 'json_decode()' 对响应数据进行解析.

请求失败或响应无法正确解析时会抛出异常.

使用了 Laravel Facade, 如果想在 Laravel 框架外使用, 请自己改造.
