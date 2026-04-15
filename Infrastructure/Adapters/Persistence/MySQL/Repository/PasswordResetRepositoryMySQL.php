<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../../../Application/Ports/Out/SavePasswordResetPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/FindPasswordResetPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/InvalidatePasswordResetPort.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/PasswordResetData.php';

final class PasswordResetRepositoryMySQL implements
    SavePasswordResetPort,
    FindPasswordResetPort,
    InvalidatePasswordResetPort
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function savePasswordReset(string $token, string $email, string $expiresAt): void
    {
        // Eliminar tokens previos del mismo correo para evitar acumulación
        $this->pdo
            ->prepare('DELETE FROM password_resets WHERE email = :email')
            ->execute(array(':email' => $email));

        $stmt = $this->pdo->prepare(
            'INSERT INTO password_resets (token, email, expires_at, used, created_at)
             VALUES (:token, :email, :expires_at, 0, NOW())'
        );
        $stmt->execute(array(
            ':token'      => $token,
            ':email'      => $email,
            ':expires_at' => $expiresAt,
        ));
    }

    public function findByToken(string $token): ?PasswordResetData
    {
        $stmt = $this->pdo->prepare(
            'SELECT token, email, expires_at, used
               FROM password_resets
              WHERE token = :token
              LIMIT 1'
        );
        $stmt->execute(array(':token' => $token));
        $row = $stmt->fetch();

        if ($row === false) {
            return null;
        }

        return new PasswordResetData(
            (string)  $row['token'],
            (string)  $row['email'],
            (string)  $row['expires_at'],
            (bool)    $row['used']
        );
    }

    public function invalidateToken(string $token): void
    {
        $this->pdo
            ->prepare('UPDATE password_resets SET used = 1 WHERE token = :token')
            ->execute(array(':token' => $token));
    }
}
