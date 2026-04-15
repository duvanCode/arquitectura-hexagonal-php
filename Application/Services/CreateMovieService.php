<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/CreateMovieUseCase.php';
require_once __DIR__ . '/../Ports/Out/SaveMoviePort.php';
require_once __DIR__ . '/Mappers/MovieApplicationMapper.php';

final class CreateMovieService implements CreateMovieUseCase
{
    private SaveMoviePort $saveMoviePort;

    public function __construct(SaveMoviePort $saveMoviePort)
    {
        $this->saveMoviePort = $saveMoviePort;
    }

    public function execute(CreateMovieCommand $command): MovieModel
    {
        $movie = MovieApplicationMapper::fromCreateCommandToModel($command);
        return $this->saveMoviePort->save($movie);
    }
}
