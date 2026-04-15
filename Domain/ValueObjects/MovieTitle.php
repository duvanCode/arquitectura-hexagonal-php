<?php
require_once __DIR__ . '/../Exceptions/InvalidMovieTitleException.php';

class MovieTitle
{
    private $value;

    public function __construct($value)
    {
        $normalized = trim((string) $value);
        if ($normalized === '') {
            throw InvalidMovieTitleException::becauseValueIsEmpty();
        }
        if (mb_strlen($normalized) < 1) {
            throw InvalidMovieTitleException::becauseLengthIsTooShort(1);
        }
        $this->value = $normalized;
    }

    public function value(): string { return $this->value; }
    public function equals(MovieTitle $other): bool { return $this->value === $other->value(); }
    public function __toString(): string { return $this->value; }
}
