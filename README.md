# GraphQL utilities

[![Build Status](https://travis-ci.org/oligus/graphql-utils.svg?branch=master)](https://travis-ci.org/oligus/graphql-utils)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Codecov.io](https://codecov.io/gh/oligus/graphql-utils/branch/master/graphs/badge.svg)](https://codecov.io/gh/oligus/graphql-utils)

Utils for use with [webonyx/graphql-php](https://github.com/webonyx/graphql-php)

## Type Registry

Scalars are exposed as static methods of GraphQLUtils\TypeRegistry class:

```php

<?php
use GraphQLUtils\TypeRegistry;

// Built-in Scalar types (wrapped from graphql):
TypeRegistry::string();     // String type
TypeRegistry::int();        // Int type
TypeRegistry::float();      // Float type
TypeRegistry::boolean();    // Boolean type
TypeRegistry::id();         // ID type

// Custom Scalar types:
TypeRegistry::uuid();       // UUID type
TypeRegistry::date();       // Date type
TypeRegistry::dateTime();   // DateTime (Atom) type
```

## Custom Types

#### UUID Type

`TypeRegistry::uuid()`

Validates and returns a UUID object of type [ramsey/uuid](https://github.com/ramsey/uuid)

#### Date Type

`TypeRegistry::date($format)`

Validates and returns a `DateTime` object according to format of your own choosing. 
You can only initialize the date type with format once. Initializing the date with a spcific format e.g.`TypeRegistry::date('d/m/Y')`
will mean all subsequent requests will be in the same format.

Default format: `Y-m-d`

#### Date Time Type

Date time in `ATOM` format, RFC3339.

Format: `Y-m-d\TH:i:sP`

#### Money Type

`TypeRegistry::money()`

Validates and returns instance of Money ([moneyphp/money](https://github.com/moneyphp/money)), a PHP implementation of the Money pattern.

