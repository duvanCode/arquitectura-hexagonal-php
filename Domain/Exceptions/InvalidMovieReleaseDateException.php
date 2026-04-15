<?php
class InvalidMovieReleaseDateException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty()
    {
        return new self('La fecha de estreno no puede estar vacía.');
    }

    public static function becauseFormatIsInvalid($date)
    {
        return new self('El formato de la fecha de estreno es inválido: ' . $date . '. Use YYYY-MM-DD.');
    }
}
