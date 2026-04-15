<?php
class InvalidMovieTitleException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty()
    {
        return new self('El título de la película no puede estar vacío.');
    }

    public static function becauseLengthIsTooShort($min)
    {
        return new self('El título de la película debe tener al menos ' . $min . ' caracteres.');
    }
}
