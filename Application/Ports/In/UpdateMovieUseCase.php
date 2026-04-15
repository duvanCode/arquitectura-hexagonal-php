<?php
declare(strict_types=1);
require_once __DIR__ . '/../../Services/Dto/Commands/UpdateMovieCommand.php';
require_once __DIR__ . '/../../../Domain/Models/MovieModel.php';

interface UpdateMovieUseCase
{
    public function execute(UpdateMovieCommand $command): MovieModel;
}
