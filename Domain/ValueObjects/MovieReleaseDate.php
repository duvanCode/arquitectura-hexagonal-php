<?php
require_once __DIR__ . '/../Exceptions/InvalidMovieReleaseDateException.php';

class MovieReleaseDate
{
    private $value;

    public function __construct($value)
    {
        $normalized = trim((string) $value);
        if ($normalized === '') {
            throw InvalidMovieReleaseDateException::becauseValueIsEmpty();
        }
        $date = DateTime::createFromFormat('Y-m-d', $normalized);
        if (!$date || $date->format('Y-m-d') !== $normalized) {
            throw InvalidMovieReleaseDateException::becauseFormatIsInvalid($normalized);
        }
        $this->value = $normalized;
    }

    public function value(): string { return $this->value; }
    public function equals(MovieReleaseDate $other): bool { return $this->value === $other->value(); }
    public function __toString(): string { return $this->value; }
}
