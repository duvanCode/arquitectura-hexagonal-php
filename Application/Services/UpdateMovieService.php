<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/UpdateMovieUseCase.php';
require_once __DIR__ . '/../Ports/Out/UpdateMoviePort.php';
require_once __DIR__ . '/../Ports/Out/GetMovieByIdPort.php';
require_once __DIR__ . '/Mappers/MovieApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/MovieNotFoundException.php';
require_once __DIR__ . '/../../Domain/ValueObjects/MovieId.php';

final class UpdateMovieService implements UpdateMovieUseCase
{
    private UpdateMoviePort    $updateMoviePort;
    private GetMovieByIdPort   $getMovieByIdPort;

    public function __construct(
        UpdateMoviePort  $updateMoviePort,
        GetMovieByIdPort $getMovieByIdPort
    ) {
        $this->updateMoviePort  = $updateMoviePort;
        $this->getMovieByIdPort = $getMovieByIdPort;
    }

    public function execute(UpdateMovieCommand $command): MovieModel
    {
        $movieId = new MovieId($command->getId());
        $existing = $this->getMovieByIdPort->getById($movieId);

        if ($existing === null) {
            throw MovieNotFoundException::becauseIdWasNotFound($movieId->value());
        }

        $movie = MovieApplicationMapper::fromUpdateCommandToModel($command);
        return $this->updateMoviePort->update($movie);
    }
}
