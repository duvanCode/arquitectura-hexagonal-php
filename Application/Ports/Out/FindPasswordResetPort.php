<?php
declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/PasswordResetData.php';

interface FindPasswordResetPort
{
    public function findByToken(string $token): ?PasswordResetData;
}
