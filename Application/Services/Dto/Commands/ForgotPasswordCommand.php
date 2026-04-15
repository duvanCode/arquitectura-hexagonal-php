<?php
declare(strict_types=1);

final class ForgotPasswordCommand
{
    private string $email;
    private string $baseUrl;

    public function __construct(string $email, string $baseUrl)
    {
        $this->email   = trim(strtolower($email));
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function getEmail(): string   { return $this->email; }
    public function getBaseUrl(): string { return $this->baseUrl; }
}
