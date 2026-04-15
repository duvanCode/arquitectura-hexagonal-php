<?php
class MovieSynopsis
{
    private $value;

    public function __construct($value)
    {
        $normalized = trim((string) $value);
        if ($normalized === '') {
            throw new InvalidArgumentException('La sinopsis no puede estar vacía.');
        }
        $this->value = $normalized;
    }

    public function value(): string { return $this->value; }
    public function equals(MovieSynopsis $other): bool { return $this->value === $other->value(); }
    public function __toString(): string { return $this->value; }
}
