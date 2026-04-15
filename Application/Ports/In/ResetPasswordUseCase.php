<?php
declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/ResetPasswordCommand.php';

interface ResetPasswordUseCase
{
    public function execute(ResetPasswordCommand $command): void;
}
