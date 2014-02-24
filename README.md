# Closure Access

The closure access trait brings JavaScript-like functionality to your objects in the following ways:

* Public methods on objects can be accessed as properties e.g. $obj->methodName
* Closures added to objects can be executed like public methods e.g. $obj->closureProp()

No performance testing has been done against this library, and no claims are made as to how practical it is.

## Installation (with composer)

	composer require camspiers/closureaccess:dev-master

## Usage

```php
namespace Camspiers;

class A {
    use ClosureAccess;
    public function hello()
    {
        return "Hello";
    }
}

function exec($fn) {
    return $fn();
}

$a = new A;

// an example of accessing a public method via properties and passing it around
echo exec($a->hello), ', World';

// an example of executing a closure property as a method
$a->world = function () {
    return "World";
};

echo 'Hello, ', $a->world();
```
