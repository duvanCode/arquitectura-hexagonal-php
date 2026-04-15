<?php
require_once __DIR__ . '/EventDomain.php';
require_once __DIR__ . '/../Models/MovieModel.php';

class MovieCreatedDomainEvent extends DomainEvent
{
    private $movie;

    public function __construct(MovieModel $movie)
    {
        parent::__construct('movie.created');
        $this->movie = $movie;
    }

    public function movie(): MovieModel { return $this->movie; }

    public function payload(): array
    {
        return array(
            'id'     => $this->movie->id()->value(),
            'nombre' => $this->movie->nombre()->value(),
            'genero' => $this->movie->genero(),
        );
    }
}
