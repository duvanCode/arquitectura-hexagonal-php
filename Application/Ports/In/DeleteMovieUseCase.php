<?php
declare(strict_types=1);
require_once __DIR__ . '/../../Services/Dto/Commands/DeleteMovieCommand.php';

interface DeleteMovieUseCase
{
    public function execute(DeleteMovieCommand $command): void;
}
