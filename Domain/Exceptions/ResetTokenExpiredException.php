<?php
declare(strict_types=1);

final class ResetTokenExpiredException extends RuntimeException
{
    public static function becauseTokenHasExpired(): self
    {
        return new self('El enlace de recuperación ha expirado. Por favor solicita uno nuevo.');
    }
}
