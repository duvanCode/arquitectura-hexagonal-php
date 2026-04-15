<?php
declare(strict_types=1);

final class InvalidResetTokenException extends RuntimeException
{
    public static function becauseTokenNotFound(): self
    {
        return new self('El enlace de recuperación no es válido o ya fue utilizado.');
    }

    public static function becausePasswordsDoNotMatch(): self
    {
        return new self('Las contraseñas no coinciden.');
    }
}
