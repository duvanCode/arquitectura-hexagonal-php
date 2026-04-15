<?php
require_once __DIR__ . '/../Exceptions/InvalidMovieDurationException.php';

class MovieDuration
{
    private int $value;

    public function __construct($value)
    {
        $int = (int) $value;
        if ($int <= 0) {
            throw InvalidMovieDurationException::becauseMustBePositive();
        }
        $this->value = $int;
    }

    public function value(): int { return $this->value; }
    public function equals(MovieDuration $other): bool { return $this->value === $other->value(); }
    public function __toString(): string { return (string) $this->value; }
}
