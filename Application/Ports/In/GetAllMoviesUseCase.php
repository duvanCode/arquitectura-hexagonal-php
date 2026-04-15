<?php
declare(strict_types=1);
require_once __DIR__ . '/../../Services/Dto/Queries/GetAllMoviesQuery.php';
require_once __DIR__ . '/../../../Domain/Models/MovieModel.php';

interface GetAllMoviesUseCase
{
    /** @return MovieModel[] */
    public function execute(GetAllMoviesQuery $query): array;
}
