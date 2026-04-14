<?php
require_once __DIR__ . '/../Exceptions/InvalidUserPasswordException.php';

class UserPassword
{
    private $value;

    public function __construct($value)
    {
        $normalized = trim((string) $value);
        if ($normalized === '') {
            throw InvalidUserPasswordException::becauseValueIsEmpty();
        }
        if (strlen($normalized) < 8) {
            throw InvalidUserPasswordException::becauseLengthIsTooShort(8);
        }
        $this->value = $normalized;
    }

    public static function fromHash(string $hash): self
    {
        if (trim($hash) === '') {
            throw InvalidUserPasswordException::becauseValueIsEmpty();
        }
        // Se asigna directamente sin validar longitud mínima: un hash bcrypt mide 60 chars
        $instance = new self($hash);
        return $instance;
    }

    public static function fromPlainText(string $plain): self
    {
        $normalized = trim($plain);
        if ($normalized === '') {
            throw InvalidUserPasswordException::becauseValueIsEmpty();
        }
        if (strlen($normalized) < 8) {
            throw InvalidUserPasswordException::becauseLengthIsTooShort(8);
        }
        // El hash de bcrypt supera los 8 chars, por lo que pasa la validación del constructor
        return new self(password_hash($normalized, PASSWORD_BCRYPT));
    }

    public function verifyPlain(string $plain): bool
    {
        return password_verify($plain, $this->value);
    }

    public function value() { return $this->value; }
    public function equals(UserPassword $other) { return $this->value === $other->value(); }
    public function __toString() { return $this->value; }
}
