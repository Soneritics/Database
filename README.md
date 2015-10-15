# Soneritics Database #

[![Build Status](https://api.travis-ci.org/Soneritics/Database.svg?branch=master)](https://travis-ci.org/Soneritics/Database)
[![Coverage Status](https://coveralls.io/repos/Soneritics/Database/badge.svg?branch=master)](https://coveralls.io/r/Soneritics/Database?branch=master)
![License](http://img.shields.io/badge/license-MIT-green.svg)

by
* [@Soneritics](https://github.com/Soneritics) - Jordi Jolink


## Introduction ##
> Soon..

## Minimum Requirements ##

- PHP 5.5+
- PDO driver for your respective database (atm only MySQL is supported)

## Supported Databases ##

- MySQL

## Features ##

- Much

### Database querying ###
Database querying is very easy. A few examples can be found in the code below.

```php
// Define the tables we have as Table extends
class Father extends Table {}
class Mother extends Table {}
class Child extends Table {}

// Use the Child table as a base for the queries
$child = new Child;

// Select everything from the children table
$child
    ->select()
    ->execute();

// Join a child with it's parents
$child
    ->select()
    ->leftJoin(new Father, 'Father.id = father_id')
    ->leftJoin(new Mother, 'Mother.id = mother_id')
    ->execute();

// A new child has been born!
$child
    ->insert()
    ->values([
        'firstname' => 'first name',
        'lastname' => 'last name',
        'father_id' => 1,
        'mother_id' => 1
    ])
    ->execute();

// Typo in the baby's name :-)
$child
    ->update()
    ->set('firstname', 'new first name')
    ->where([
        'firstname' => 'first name',
        'lastname' => 'last name'
    ])
    ->execute();

// Typo in the first and lastname of the baby :O
$child
    ->update()
    ->set(['firstname' => 'new first name', 'lastname' => 'new last name'])
    ->where([
        'firstname' => 'first name',
        'lastname' => 'last name'
    ])
    ->execute();

// Selecting with some sorting and limiting
$child
    ->select()
    ->leftJoin(new Father, 'Father.id = father_id')
    ->leftJoin(new Mother, 'Mother.id = mother_id')
    ->orderAsc('lastname')
    ->orderAsc('firstname')
    ->limit(25)
    ->execute();
```

