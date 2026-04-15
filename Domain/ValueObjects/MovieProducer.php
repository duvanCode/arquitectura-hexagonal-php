<?php
class MovieProducer
{
    private $value;

    public function __construct($value)
    {
        $normalized = trim((string) $value);
        if ($normalized === '') {
            throw new InvalidArgumentException('La productora no puede estar vacía.');
        }
        $this->value = $normalized;
    }

    public function value(): string { return $this->value; }
    public function equals(MovieProducer $other): bool { return $this->value === $other->value(); }
    public function __toString(): string { return $this->value; }
}
