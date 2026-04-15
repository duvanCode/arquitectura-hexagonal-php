<?php
class MovieLanguage
{
    private $value;

    public function __construct($value)
    {
        $normalized = trim((string) $value);
        if ($normalized === '') {
            throw new InvalidArgumentException('El idioma original no puede estar vacío.');
        }
        $this->value = $normalized;
    }

    public function value(): string { return $this->value; }
    public function equals(MovieLanguage $other): bool { return $this->value === $other->value(); }
    public function __toString(): string { return $this->value; }
}
