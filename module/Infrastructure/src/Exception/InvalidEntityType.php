<?php

namespace Infrastructure\Exception;

class InvalidEntityType extends \Exception
{
    public static function fromRightAndWrongClass($rightClass, $wrongClass)
    {
        $message = "Entity was expected to be of type $rightClass, but it is $wrongClass";
        return new InvalidEntityType($message, 500);
    }
}
