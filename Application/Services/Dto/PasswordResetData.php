<?php
declare(strict_types=1);

/**
 * Datos del token de recuperación de contraseña.
 * Devuelto por FindPasswordResetPort.
 */
final class PasswordResetData
{
    private string $token;
    private string $email;
    private string $expiresAt;
    private bool   $used;

    public function __construct(
        string $token,
        string $email,
        string $expiresAt,
        bool   $used
    ) {
        $this->token     = $token;
        $this->email     = $email;
        $this->expiresAt = $expiresAt;
        $this->used      = $used;
    }

    public function token(): string { return $this->token; }
    public function email(): string { return $this->email; }

    public function isExpired(): bool
    {
        return new DateTime() > new DateTime($this->expiresAt);
    }

    public function isUsed(): bool
    {
        return $this->used;
    }
}
