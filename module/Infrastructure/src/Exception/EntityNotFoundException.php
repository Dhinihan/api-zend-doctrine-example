<?php

namespace Infrastructure\Exception;

class EntityNotFoundException extends \Exception
{
    public static function fromClassAndIdentifier($class, $id)
    {
        return new self(
            "Entity of class $class with id $id could not be found",
            404
        );
    }
}
