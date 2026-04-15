<?php
declare(strict_types=1);

require_once __DIR__ . '/../Dto/CreateMovieRequest.php';
require_once __DIR__ . '/../Dto/UpdateMovieRequest.php';
require_once __DIR__ . '/../Dto/MovieResponse.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/CreateMovieCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/UpdateMovieCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/DeleteMovieCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Queries/GetMovieByIdQuery.php';
require_once __DIR__ . '/../../../../../Domain/Models/MovieModel.php';

final class MovieWebMapper
{
    public function fromCreateRequestToCommand(CreateMovieWebRequest $request): CreateMovieCommand
    {
        return new CreateMovieCommand(
            $request->getId(),
            $request->getNombre(),
            $request->getTituloOriginal(),
            $request->getDirector(),
            $request->getGenero(),
            $request->getDuracionMinutos(),
            $request->getFechaEstreno(),
            $request->getPaisOrigen(),
            $request->getIdiomaOriginal(),
            $request->getClasificacionEdad(),
            $request->getProductora(),
            $request->getSinopsis()
        );
    }

    public function fromUpdateRequestToCommand(UpdateMovieWebRequest $request): UpdateMovieCommand
    {
        return new UpdateMovieCommand(
            $request->getId(),
            $request->getNombre(),
            $request->getTituloOriginal(),
            $request->getDirector(),
            $request->getGenero(),
            $request->getDuracionMinutos(),
            $request->getFechaEstreno(),
            $request->getPaisOrigen(),
            $request->getIdiomaOriginal(),
            $request->getClasificacionEdad(),
            $request->getProductora(),
            $request->getSinopsis()
        );
    }

    public function fromIdToGetByIdQuery(string $id): GetMovieByIdQuery
    {
        return new GetMovieByIdQuery($id);
    }

    public function fromIdToDeleteCommand(string $id): DeleteMovieCommand
    {
        return new DeleteMovieCommand($id);
    }

    public function fromModelToResponse(MovieModel $movie): MovieResponse
    {
        return new MovieResponse(
            $movie->id()->value(),
            $movie->nombre()->value(),
            $movie->tituloOriginal()->value(),
            $movie->director()->value(),
            $movie->genero(),
            $movie->duracionMinutos()->value(),
            $movie->fechaEstreno()->value(),
            $movie->paisOrigen()->value(),
            $movie->idiomaOriginal()->value(),
            $movie->clasificacionEdad(),
            $movie->productora()->value(),
            $movie->sinopsis()->value()
        );
    }

    /**
     * @param MovieModel[] $movies
     * @return MovieResponse[]
     */
    public function fromModelsToResponses(array $movies): array
    {
        $responses = array();
        foreach ($movies as $movie) {
            $responses[] = $this->fromModelToResponse($movie);
        }
        return $responses;
    }
}
