<?php
declare(strict_types=1);
require_once __DIR__ . '/../../../Domain/Models/MovieModel.php';

interface GetAllMoviesPort
{
    /** @return MovieModel[] */
    public function getAll(): array;
}
