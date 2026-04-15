<?php
declare(strict_types=1);

require_once __DIR__ . '/../Dto/Commands/CreateMovieCommand.php';
require_once __DIR__ . '/../Dto/Commands/UpdateMovieCommand.php';
require_once __DIR__ . '/../Dto/Commands/DeleteMovieCommand.php';
require_once __DIR__ . '/../Dto/Queries/GetMovieByIdQuery.php';
require_once __DIR__ . '/../../../Domain/Models/MovieModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/MovieId.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/MovieTitle.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/MovieDirector.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/MovieDuration.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/MovieReleaseDate.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/MovieCountry.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/MovieLanguage.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/MovieProducer.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/MovieSynopsis.php';

final class MovieApplicationMapper
{
    public static function fromCreateCommandToModel(CreateMovieCommand $command): MovieModel
    {
        return MovieModel::create(
            new MovieId($command->getId()),
            new MovieTitle($command->getNombre()),
            new MovieTitle($command->getTituloOriginal()),
            new MovieDirector($command->getDirector()),
            $command->getGenero(),
            new MovieDuration($command->getDuracionMinutos()),
            new MovieReleaseDate($command->getFechaEstreno()),
            new MovieCountry($command->getPaisOrigen()),
            new MovieLanguage($command->getIdiomaOriginal()),
            $command->getClasificacionEdad(),
            new MovieProducer($command->getProductora()),
            new MovieSynopsis($command->getSinopsis())
        );
    }

    public static function fromUpdateCommandToModel(UpdateMovieCommand $command): MovieModel
    {
        return new MovieModel(
            new MovieId($command->getId()),
            new MovieTitle($command->getNombre()),
            new MovieTitle($command->getTituloOriginal()),
            new MovieDirector($command->getDirector()),
            $command->getGenero(),
            new MovieDuration($command->getDuracionMinutos()),
            new MovieReleaseDate($command->getFechaEstreno()),
            new MovieCountry($command->getPaisOrigen()),
            new MovieLanguage($command->getIdiomaOriginal()),
            $command->getClasificacionEdad(),
            new MovieProducer($command->getProductora()),
            new MovieSynopsis($command->getSinopsis())
        );
    }

    public static function fromGetMovieByIdQueryToMovieId(GetMovieByIdQuery $query): MovieId
    {
        return new MovieId($query->getId());
    }

    public static function fromDeleteCommandToMovieId(DeleteMovieCommand $command): MovieId
    {
        return new MovieId($command->getId());
    }

    public static function fromModelToArray(MovieModel $movie): array
    {
        return $movie->toArray();
    }

    /** @param MovieModel[] $movies */
    public static function fromModelsToArray(array $movies): array
    {
        $result = array();
        foreach ($movies as $movie) {
            $result[] = self::fromModelToArray($movie);
        }
        return $result;
    }
}
