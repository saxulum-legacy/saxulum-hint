# saxulum-hint

[![Build Status](https://api.travis-ci.org/saxulum/saxulum-hint.png?branch=master)](https://travis-ci.org/saxulum/saxulum-hint)
[![Total Downloads](https://poser.pugx.org/saxulum/saxulum-hint/downloads.png)](https://packagist.org/packages/saxulum/saxulum-hint)
[![Latest Stable Version](https://poser.pugx.org/saxulum/saxulum-hint/v/stable.png)](https://packagist.org/packages/saxulum/saxulum-hint)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/saxulum/saxulum-hint/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/saxulum/saxulum-hint/?branch=master)

## Features

 * Hint scalars, arrays and objects


## Requirements

 * PHP 5.3+


## Installation

Through [Composer](http://getcomposer.org) as [saxulum/saxulum-hint][1].


## Usage

#### Without a hint

``` {.php}
Hint::validate(false) // true
Hint::validate(true) // true
Hint::validate(1) // true
Hint::validate(1.0) // true
Hint::validate('1.0') // true
Hint::validate('test') // true
Hint::validate(array()) // true
Hint::validate(new \stdClass) // true
```

#### Hint boolean

``` {.php}
Hint::validate(null, Hint::BOOL) // true
Hint::validate(true, Hint::BOOL) // true
Hint::validate(null, Hint::BOOL, false) // false
```

#### Hint int

``` {.php}
Hint::validate(null, Hint::INT) // true
Hint::validate(1, Hint::INT) // true
Hint::validate(null, Hint::INT, false) // false
```

#### Hint float

``` {.php}
Hint::validate(null, Hint::FLOAT) // true
Hint::validate(1.0, Hint::FLOAT) // true
Hint::validate(null, Hint::FLOAT, false) // false
```

#### Hint numeric

``` {.php}
Hint::validate(null, Hint::NUMERIC) // true
Hint::validate('1.0', Hint::NUMERIC) // true
Hint::validate(null, Hint::NUMERIC, false) // false
```

#### Hint string

``` {.php}
Hint::validate(null, Hint::STRING) // true
Hint::validate('name', Hint::STRING) // true
Hint::validate(null, Hint::STRING, false) // false
```

#### Hint array

``` {.php}
Hint::validate(null, Hint::ARR) // false
Hint::validate(array, Hint::ARR) // true
Hint::validate(null, Hint::ARR, true) // true
```

#### Hint object

``` {.php}
Hint::validate(null, '\stdClass') // false
Hint::validate(new \stdClass, '\stdClass') // true
Hint::validate(null, '\stdClass', true) // true
```

#### Hint array/collection values
``` {.php}
Hint::validate(array(), Hint::BOOL . '[]') // true
Hint::validate(array(true, false), Hint::BOOL . '[]') // true
Hint::validate(array(true, null), Hint::BOOL . '[]') // true
Hint::validate(array('\stdClass', '\stdClass'), '\stdClass[]') // true
Hint::validate(array('\stdClass', null), '\stdClass[]') // false
Hint::validate(array('\stdClass', null), '\stdClass[]', true) // true
Hint::validate(array('\stdClass', 'test'), '\stdClass[]', true) // false
```


## Copyright

* Dominik Zogg <dominik.zogg@gmail.com>


[1]: https://packagist.org/packages/saxulum/saxulum-hint