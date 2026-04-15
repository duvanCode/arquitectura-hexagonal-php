<?php
declare(strict_types=1);
require_once __DIR__ . '/../../Services/Dto/Queries/GetMovieByIdQuery.php';
require_once __DIR__ . '/../../../Domain/Models/MovieModel.php';

interface GetMovieByIdUseCase
{
    public function execute(GetMovieByIdQuery $query): MovieModel;
}
