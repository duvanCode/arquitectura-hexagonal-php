<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/ResetPasswordUseCase.php';
require_once __DIR__ . '/../Ports/Out/FindPasswordResetPort.php';
require_once __DIR__ . '/../Ports/Out/InvalidatePasswordResetPort.php';
require_once __DIR__ . '/../Ports/Out/GetUserByEmailPort.php';
require_once __DIR__ . '/../Ports/Out/UpdateUserPort.php';
require_once __DIR__ . '/../../Domain/Exceptions/InvalidResetTokenException.php';
require_once __DIR__ . '/../../Domain/Exceptions/ResetTokenExpiredException.php';
require_once __DIR__ . '/../../Domain/ValueObjects/UserPassword.php';
require_once __DIR__ . '/../../Domain/ValueObjects/UserEmail.php';

final class ResetPasswordService implements ResetPasswordUseCase
{
    private FindPasswordResetPort      $findPasswordResetPort;
    private InvalidatePasswordResetPort $invalidatePasswordResetPort;
    private GetUserByEmailPort         $getUserByEmailPort;
    private UpdateUserPort             $updateUserPort;

    public function __construct(
        FindPasswordResetPort       $findPasswordResetPort,
        InvalidatePasswordResetPort $invalidatePasswordResetPort,
        GetUserByEmailPort          $getUserByEmailPort,
        UpdateUserPort              $updateUserPort
    ) {
        $this->findPasswordResetPort       = $findPasswordResetPort;
        $this->invalidatePasswordResetPort = $invalidatePasswordResetPort;
        $this->getUserByEmailPort          = $getUserByEmailPort;
        $this->updateUserPort              = $updateUserPort;
    }

    public function execute(ResetPasswordCommand $command): void
    {
        if ($command->getPassword() !== $command->getPasswordConfirmation()) {
            throw InvalidResetTokenException::becausePasswordsDoNotMatch();
        }

        $resetData = $this->findPasswordResetPort->findByToken($command->getToken());

        if ($resetData === null || $resetData->isUsed()) {
            throw InvalidResetTokenException::becauseTokenNotFound();
        }

        if ($resetData->isExpired()) {
            throw ResetTokenExpiredException::becauseTokenHasExpired();
        }

        $user = $this->getUserByEmailPort->getByEmail(new UserEmail($resetData->email()));
        if ($user === null) {
            throw InvalidResetTokenException::becauseTokenNotFound();
        }

        $newPassword  = UserPassword::fromPlainText($command->getPassword());
        $updatedUser  = $user->changePassword($newPassword);

        $this->updateUserPort->update($updatedUser);
        $this->invalidatePasswordResetPort->invalidateToken($command->getToken());
    }
}
