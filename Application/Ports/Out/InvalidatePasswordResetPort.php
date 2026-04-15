<?php
declare(strict_types=1);

interface InvalidatePasswordResetPort
{
    public function invalidateToken(string $token): void;
}
