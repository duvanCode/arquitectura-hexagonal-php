<?php
class MovieAgeRatingEnum
{
    const ATP        = 'ATP';        // Apta para todo público
    const SIETE      = 'SIETE';      // Mayores de 7 años
    const TRECE      = 'TRECE';      // Mayores de 13 años
    const DIECISEIS  = 'DIECISEIS';  // Mayores de 16 años
    const DIECIOCHO  = 'DIECIOCHO';  // Mayores de 18 años

    public static function values(): array
    {
        return array(self::ATP, self::SIETE, self::TRECE, self::DIECISEIS, self::DIECIOCHO);
    }

    public static function isValid($value): bool
    {
        return in_array($value, self::values(), true);
    }

    public static function ensureIsValid($value): void
    {
        if (!self::isValid($value)) {
            throw new InvalidArgumentException('La clasificación de edad ' . $value . ' no es válida.');
        }
    }
}
