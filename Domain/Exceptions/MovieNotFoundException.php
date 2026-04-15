<?php
class MovieNotFoundException extends DomainException
{
    public static function becauseIdWasNotFound($id)
    {
        return new self('No se encontró una película con el ID: ' . $id);
    }
}
