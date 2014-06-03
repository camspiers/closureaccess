# Closure Access

The closure access trait brings JavaScript-like functionality to your objects in the following ways:

* Public methods on objects can be accessed as properties e.g. $obj->methodName
* Closures added to objects can be executed like public methods e.g. $obj->closureProp()

No claims are made as to whether you should use this library, it is provided more as a proof of concept.

## Installation (with composer)

	composer require camspiers/closureaccess:dev-master

## Performance

* Accessing public methods as properties e.g. $obj->methodName (return Closure)
 * `~2.1x` slower
* Closures added to objects can be executed like public methods e.g. $obj->closureProp()
 * `~3.1x` slower

## Usage

```php

class A {
    use Camspiers\ClosureAccess;
    public function hello()
    {
        return "Hello";
    }
}

function run($fn) {
    return $fn();
}

$a = new A;

// an example of accessing a public method via properties and passing it around
echo run($a->hello), ', World';

// an example of executing a closure property as a method
$a->world = function () {
    return "World";
};

echo 'Hello, ', $a->world();
```
