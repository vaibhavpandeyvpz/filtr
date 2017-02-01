# vaibhavpandeyvpz/filtr
Simple and fluent input validation for [PHP](http://www.php.net/) >= 5.3.

[![Build status][build-status-image]][build-status-url]
[![Code Coverage][code-coverage-image]][code-coverage-url]
[![Latest Version][latest-version-image]][latest-version-url]
[![Downloads][downloads-image]][downloads-url]
[![PHP Version][php-version-image]][php-version-url]
[![License][license-image]][license-url]

[![SensioLabsInsight][insights-image]][insights-url]

Preview (झलक)
-----
```php
<?php

$v = new Filtr\Validator();
$v->required('email')->isEmailAddress();
$v->required('password')->isNotBlank()->isHavingLength(8, 32);
$v->key('remember_me')->isTrue();

$result = $v->validate([
    'email' => 'contact@vaibhavpandey.com',
    'password' => 'not-much-secret',
]);

if ($result->valid()) {
    // ... proceed
} else {
    echo implode('<br>', $result->errors());
}
```

Documentation
-------
Detailed installation and usage instructions can be found in the [Wiki](https://github.com/vaibhavpandeyvpz/filtr/wiki).

License
-------
See [LICENSE.md][license-url] file.

[build-status-image]: https://img.shields.io/travis/vaibhavpandeyvpz/filtr.svg?style=flat-square
[build-status-url]: https://travis-ci.org/vaibhavpandeyvpz/filtr
[code-coverage-image]: https://img.shields.io/codecov/c/github/vaibhavpandeyvpz/filtr.svg?style=flat-square
[code-coverage-url]: https://codecov.io/gh/vaibhavpandeyvpz/filtr
[latest-version-image]: https://img.shields.io/github/release/vaibhavpandeyvpz/filtr.svg?style=flat-square
[latest-version-url]: https://github.com/vaibhavpandeyvpz/filtr/releases
[downloads-image]: https://img.shields.io/packagist/dt/vaibhavpandeyvpz/filtr.svg?style=flat-square
[downloads-url]: https://packagist.org/packages/vaibhavpandeyvpz/filtr
[php-version-image]: http://img.shields.io/badge/php-5.3+-8892be.svg?style=flat-square
[php-version-url]: https://packagist.org/packages/vaibhavpandeyvpz/filtr
[license-image]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[license-url]: LICENSE.md
[insights-image]: https://insight.sensiolabs.com/projects/27f8a2b7-8496-4073-acab-89cb55ce29d0/small.png
[insights-url]: https://insight.sensiolabs.com/projects/27f8a2b7-8496-4073-acab-89cb55ce29d0
