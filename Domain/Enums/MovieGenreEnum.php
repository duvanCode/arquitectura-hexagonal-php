<?php
require_once __DIR__ . '/../Exceptions/InvalidMovieTitleException.php';

class MovieGenreEnum
{
    const ACCION         = 'ACCION';
    const COMEDIA        = 'COMEDIA';
    const DRAMA          = 'DRAMA';
    const TERROR         = 'TERROR';
    const CIENCIA_FICCION = 'CIENCIA_FICCION';
    const ROMANCE        = 'ROMANCE';
    const ANIMACION      = 'ANIMACION';
    const DOCUMENTAL     = 'DOCUMENTAL';
    const THRILLER       = 'THRILLER';
    const FANTASIA       = 'FANTASIA';
    const AVENTURA       = 'AVENTURA';
    const MISTERIO       = 'MISTERIO';

    public static function values(): array
    {
        return array(
            self::ACCION, self::COMEDIA, self::DRAMA, self::TERROR,
            self::CIENCIA_FICCION, self::ROMANCE, self::ANIMACION,
            self::DOCUMENTAL, self::THRILLER, self::FANTASIA,
            self::AVENTURA, self::MISTERIO,
        );
    }

    public static function isValid($value): bool
    {
        return in_array($value, self::values(), true);
    }

    public static function ensureIsValid($value): void
    {
        if (!self::isValid($value)) {
            throw new InvalidArgumentException('El género ' . $value . ' no es un género válido.');
        }
    }
}
