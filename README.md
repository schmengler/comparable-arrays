# Comparable-Arrays

[![Author](http://img.shields.io/badge/author-@fschmengler-blue.svg?style=flat-square)](https://twitter.com/fschmengler)
[![Latest Version](https://img.shields.io/packagist/v/sgh/comparable-arrays.svg)](https://packagist.org/packages/sgh/comparable-arrays)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/schmengler/comparable-arrays/master.svg?style=flat-square)](https://travis-ci.org/schmengler/comparable-fileystem)

This package provides Comparators for arrays and objects that implement the SPL `ArrayAccess` interface.
They can be used with the sorting and comparing tools in the [Comparable](https://github.com/schmengler/Comparator-Tools) package.

## Requirements

The package requires PHP 5.4 or later and the Comparable package in version 1.0 or later.

## Install

Via Composer

``` bash
$ composer require sgh/comparable-arrays
```

## Usage

The following comparators are available:

- `KeyComparator`: Use array item with specific key for comparison
- `MultiKeyComparator`: The same, but with the option to sort by multiple keys (i.e. fall back in case of equality)

You can use all the methods in `\SGH\Comparable\SortFunctions` and `\SGH\Comparable\SetFunctions` with the comparators.

### KeyComparator Example

``` php
use SGH\Comparable\SortFunctions;
use SGH\Comparable\Comparator\StringComparator;
use SGH\Comparable\Arrays\Comparator\KeyComparator;

$arrayOfBooks = array(
    [ 'title' => 'Design Patterns', 'author' => 'Gang of Four', 'year' => 1995 ],
    [ 'title' => 'Clean Code', 'author' => 'Uncle Bob', 'year' => 2008 ],
    [ 'title' => 'Refactoring', 'author' => 'Martin Fowler', 'year' => 1999 ],
    [ 'title' => 'Patterns of Enterprise Application Architecture', 'autor' => 'Martin Fowler', 'year' => 2002 ],
);

// Sort the array of books by year:
SortFunctions::sort($arrayOfBooks, new KeyComparator('year'));

// Sort the array of books by title:
SortFunctions::sort($arrayOfBooks, new KeyComparator('title', new StringComparator));
```

The default comparator used to compare the array items is `NumericComparator`, which compares any scalar values and treats
them as numbers. To sort by title we needed to specify the comparator explicitly.

If you prefer, you can also use the factory method `::callback()` to retrieve a comparison callback, that can be used 
in any function that expects a user defined comparison callback:

    usort($arrayOfBooks, KeyComparator::callback('title', new StringComparator));

### MultiKeyComparator Example

``` php
use SGH\Comparable\SortFunctions;
use SGH\Comparable\Comparator\ReverseComparator;
use SGH\Comparable\Comparator\StringComparator;
use SGH\Comparable\Arrays\Comparator\MultiKeyComparator;

$arrayOfBooks = array(
    [ 'title' => 'Design Patterns', 'author' => 'Gang of Four', 'year' => 1995 ],
    [ 'title' => 'Clean Code', 'author' => 'Uncle Bob', 'year' => 2008 ],
    [ 'title' => 'Refactoring', 'author' => 'Martin Fowler', 'year' => 1999 ],
    [ 'title' => 'Patterns of Enterprise Application Architecture', 'autor' => 'Martin Fowler', 'year' => 2002 ],
);

// Sort the array of books by author, then by year, descending:
SortFunctions::sort($arrayOfBooks, new MultiKeyComparator([
	'author' => new StringComparator,
	'year'   => new ReverseComparator(new NumericComparator)
]));
```

### Configuration

Both, `KeyComparator` and `MultiKeyComparator` accept arrays and objects that implement `ArrayAccess` as parameters.
This default behavior can be changed such that they only accept arrays:

``` php
$comparator->setAcceptArrayAccessObject(false);
```

By default array keys must exist to compare their values. Both comparators have a non-strict mode, where missing items
are treated as smaller than everything else. Two missing items are treated as equal.

``` php
$comparator->setStrict(false);
```

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email fschmengler@sgh-it.eu instead of using the issue tracker.

## Credits

- Fabian Schmengler(https://github.com/schmengler)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.