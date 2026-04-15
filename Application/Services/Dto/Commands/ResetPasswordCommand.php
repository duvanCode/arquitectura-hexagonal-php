<?php
declare(strict_types=1);

final class ResetPasswordCommand
{
    private string $token;
    private string $password;
    private string $passwordConfirmation;

    public function __construct(
        string $token,
        string $password,
        string $passwordConfirmation
    ) {
        $this->token                = trim($token);
        $this->password             = $password;
        $this->passwordConfirmation = $passwordConfirmation;
    }

    public function getToken(): string                { return $this->token; }
    public function getPassword(): string             { return $this->password; }
    public function getPasswordConfirmation(): string { return $this->passwordConfirmation; }
}
