<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetMovieByIdUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetMovieByIdPort.php';
require_once __DIR__ . '/Mappers/MovieApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/MovieNotFoundException.php';

final class GetMovieByIdService implements GetMovieByIdUseCase
{
    private GetMovieByIdPort $getMovieByIdPort;

    public function __construct(GetMovieByIdPort $getMovieByIdPort)
    {
        $this->getMovieByIdPort = $getMovieByIdPort;
    }

    public function execute(GetMovieByIdQuery $query): MovieModel
    {
        $movieId = MovieApplicationMapper::fromGetMovieByIdQueryToMovieId($query);
        $movie   = $this->getMovieByIdPort->getById($movieId);

        if ($movie === null) {
            throw MovieNotFoundException::becauseIdWasNotFound($movieId->value());
        }

        return $movie;
    }
}
