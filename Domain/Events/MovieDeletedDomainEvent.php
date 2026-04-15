<?php
require_once __DIR__ . '/EventDomain.php';
require_once __DIR__ . '/../ValueObjects/MovieId.php';

class MovieDeletedDomainEvent extends DomainEvent
{
    private $movieId;

    public function __construct(MovieId $movieId)
    {
        parent::__construct('movie.deleted');
        $this->movieId = $movieId;
    }

    public function movieId(): MovieId { return $this->movieId; }

    public function payload(): array
    {
        return array('id' => $this->movieId->value());
    }
}
