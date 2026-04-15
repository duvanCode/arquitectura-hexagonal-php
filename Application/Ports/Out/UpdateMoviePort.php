<?php
declare(strict_types=1);
require_once __DIR__ . '/../../../Domain/Models/MovieModel.php';

interface UpdateMoviePort
{
    public function update(MovieModel $movie): MovieModel;
}
