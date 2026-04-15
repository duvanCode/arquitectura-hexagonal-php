<?php
class InvalidMovieIdException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty()
    {
        return new self('El ID de la película no puede estar vacío.');
    }
}
