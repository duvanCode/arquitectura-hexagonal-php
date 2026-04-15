<?php
declare(strict_types=1);
require_once __DIR__ . '/../../Services/Dto/Commands/CreateMovieCommand.php';
require_once __DIR__ . '/../../../Domain/Models/MovieModel.php';

interface CreateMovieUseCase
{
    public function execute(CreateMovieCommand $command): MovieModel;
}
