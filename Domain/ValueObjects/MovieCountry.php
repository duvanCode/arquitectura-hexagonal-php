<?php
class MovieCountry
{
    private $value;

    public function __construct($value)
    {
        $normalized = trim((string) $value);
        if ($normalized === '') {
            throw new InvalidArgumentException('El país de origen no puede estar vacío.');
        }
        $this->value = $normalized;
    }

    public function value(): string { return $this->value; }
    public function equals(MovieCountry $other): bool { return $this->value === $other->value(); }
    public function __toString(): string { return $this->value; }
}
