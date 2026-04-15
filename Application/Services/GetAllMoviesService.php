<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetAllMoviesUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetAllMoviesPort.php';

final class GetAllMoviesService implements GetAllMoviesUseCase
{
    private GetAllMoviesPort $getAllMoviesPort;

    public function __construct(GetAllMoviesPort $getAllMoviesPort)
    {
        $this->getAllMoviesPort = $getAllMoviesPort;
    }

    /** @return MovieModel[] */
    public function execute(GetAllMoviesQuery $query): array
    {
        return $this->getAllMoviesPort->getAll();
    }
}
