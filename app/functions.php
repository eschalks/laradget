<?php
namespace App;


/**
 * @template T
 *
 * @param class-string<T> $type
 * @param mixed $object
 *
 * @return T
 */
function expect(string $type, mixed $object)
{
    \Assert\Assertion::isInstanceOf($object, $type);
    return $object;
}
