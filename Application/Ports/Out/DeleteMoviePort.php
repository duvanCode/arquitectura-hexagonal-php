<?php
declare(strict_types=1);
require_once __DIR__ . '/../../../Domain/ValueObjects/MovieId.php';

interface DeleteMoviePort
{
    public function delete(MovieId $movieId): void;
}
