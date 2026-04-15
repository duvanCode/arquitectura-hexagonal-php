<?php
class InvalidMovieDurationException extends InvalidArgumentException
{
    public static function becauseMustBePositive()
    {
        return new self('La duración de la película debe ser un número positivo de minutos.');
    }
}
