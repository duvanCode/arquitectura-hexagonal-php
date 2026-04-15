<?php
class InvalidMovieDirectorException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty()
    {
        return new self('El director de la película no puede estar vacío.');
    }
}
