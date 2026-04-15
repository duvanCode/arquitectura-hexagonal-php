<?php
declare(strict_types=1);

interface SavePasswordResetPort
{
    public function savePasswordReset(string $token, string $email, string $expiresAt): void;
}
