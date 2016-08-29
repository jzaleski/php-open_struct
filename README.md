# Open_Struct (PHP)

[![Build Status](https://secure.travis-ci.org/jzaleski/php-open_struct.png?branch=master)](http://travis-ci.org/jzaleski/php-open_struct)

A very flexible data-structure (inspired by Ruby's `ostruct` library)

## Requirements

This library requires PHP 5.4+

## Installation

You can easily install `Open_Struct` with the following command:

```
composer [global] require 'jzaleski/php-open_struct=*'
```

## Usage

Creating a new [empty] instance:

```php
$struct = new Open_Struct;
```

Creating a new instance from an array of attributes:

```php
$struct = new Open_Struct(['foo' => 1, 'bar' => ['biz' => 2]]);
```

Dereferencing a top-level value:

```php
$value = $struct->foo;
```

Getting a top-level value by index/key:

```php
$value = $struct['foo'];
```

Dereferencing a nested value:

```php
$nested_value = $struct->bar->biz;
```

Getting a nested value by index/key:

```php
$nested_value = $struct['bar']['biz'];
```

Setting a top-level value:

```php
$struct->foo = 2;
```

Setting a top-level value by index/key:

```php
$struct['foo'] = 2;
```

Setting a nested value:

```php
$struct->bar->biz = 3;
```

Setting a nested value by index/key:

```php
$struct['bar']['biz'] = 3;
```

Unsetting a top-level value:

```php
unset($struct->foo);
```

Unsetting a top-level value by index/key:

```php
unset($struct['foo']);
```

Checking for the existence of a key:

```php
isset($struct->foo);
```

Checking for the existence of a key by index/key:

```php
isset($struct['foo']);
```

Advanced usage:
---

Setting a callback value (this is useful for scenarios where you want to derive or lazy-load a property):

```php
$dao = new Items_DAO;

$struct = new Open_Struct(['items' => function() use ($dao) { return $dao->get_items(); }]);

$struct->items;
```

## Contributing

1. Fork it ( http://github.com/jzaleski/php-open_struct/fork )
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request
