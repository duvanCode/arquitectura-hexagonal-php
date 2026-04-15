<?php
require_once __DIR__ . '/../Exceptions/InvalidMovieIdException.php';

class MovieId
{
    private $value;

    public function __construct($value)
    {
        $normalized = trim((string) $value);
        if ($normalized === '') {
            throw InvalidMovieIdException::becauseValueIsEmpty();
        }
        $this->value = $normalized;
    }

    public function value(): string { return $this->value; }
    public function equals(MovieId $other): bool { return $this->value === $other->value(); }
    public function __toString(): string { return $this->value; }
}
