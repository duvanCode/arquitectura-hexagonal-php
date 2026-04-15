<?php
declare(strict_types=1);

final class MovieController
{
    private CreateMovieUseCase  $createMovieUseCase;
    private UpdateMovieUseCase  $updateMovieUseCase;
    private GetMovieByIdUseCase $getMovieByIdUseCase;
    private GetAllMoviesUseCase $getAllMoviesUseCase;
    private DeleteMovieUseCase  $deleteMovieUseCase;
    private MovieWebMapper      $mapper;

    public function __construct(
        CreateMovieUseCase  $createMovieUseCase,
        UpdateMovieUseCase  $updateMovieUseCase,
        GetMovieByIdUseCase $getMovieByIdUseCase,
        GetAllMoviesUseCase $getAllMoviesUseCase,
        DeleteMovieUseCase  $deleteMovieUseCase,
        MovieWebMapper      $mapper
    ) {
        $this->createMovieUseCase  = $createMovieUseCase;
        $this->updateMovieUseCase  = $updateMovieUseCase;
        $this->getMovieByIdUseCase = $getMovieByIdUseCase;
        $this->getAllMoviesUseCase  = $getAllMoviesUseCase;
        $this->deleteMovieUseCase  = $deleteMovieUseCase;
        $this->mapper              = $mapper;
    }

    public function index(): array
    {
        $movies = $this->getAllMoviesUseCase->execute(new GetAllMoviesQuery());
        return $this->mapper->fromModelsToResponses($movies);
    }

    public function show(string $id): MovieResponse
    {
        $query = $this->mapper->fromIdToGetByIdQuery($id);
        $movie = $this->getMovieByIdUseCase->execute($query);
        return $this->mapper->fromModelToResponse($movie);
    }

    public function store(CreateMovieWebRequest $request): MovieResponse
    {
        $command = $this->mapper->fromCreateRequestToCommand($request);
        $movie   = $this->createMovieUseCase->execute($command);
        return $this->mapper->fromModelToResponse($movie);
    }

    public function update(UpdateMovieWebRequest $request): MovieResponse
    {
        $command = $this->mapper->fromUpdateRequestToCommand($request);
        $movie   = $this->updateMovieUseCase->execute($command);
        return $this->mapper->fromModelToResponse($movie);
    }

    public function delete(string $id): void
    {
        $command = $this->mapper->fromIdToDeleteCommand($id);
        $this->deleteMovieUseCase->execute($command);
    }
}
