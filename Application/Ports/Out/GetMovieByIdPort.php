<?php
declare(strict_types=1);
require_once __DIR__ . '/../../../Domain/Models/MovieModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/MovieId.php';

interface GetMovieByIdPort
{
    public function getById(MovieId $movieId): ?MovieModel;
}
