<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/DeleteMovieUseCase.php';
require_once __DIR__ . '/../Ports/Out/DeleteMoviePort.php';
require_once __DIR__ . '/../Ports/Out/GetMovieByIdPort.php';
require_once __DIR__ . '/Mappers/MovieApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/MovieNotFoundException.php';

final class DeleteMovieService implements DeleteMovieUseCase
{
    private DeleteMoviePort  $deleteMoviePort;
    private GetMovieByIdPort $getMovieByIdPort;

    public function __construct(
        DeleteMoviePort  $deleteMoviePort,
        GetMovieByIdPort $getMovieByIdPort
    ) {
        $this->deleteMoviePort  = $deleteMoviePort;
        $this->getMovieByIdPort = $getMovieByIdPort;
    }

    public function execute(DeleteMovieCommand $command): void
    {
        $movieId  = MovieApplicationMapper::fromDeleteCommandToMovieId($command);
        $existing = $this->getMovieByIdPort->getById($movieId);

        if ($existing === null) {
            throw MovieNotFoundException::becauseIdWasNotFound($movieId->value());
        }

        $this->deleteMoviePort->delete($movieId);
    }
}
