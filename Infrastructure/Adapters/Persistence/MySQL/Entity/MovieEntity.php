<?php
declare(strict_types=1);

final class MovieEntity
{
    private string  $id;
    private string  $nombre;
    private string  $tituloOriginal;
    private string  $director;
    private string  $genero;
    private int     $duracionMinutos;
    private string  $fechaEstreno;
    private string  $paisOrigen;
    private string  $idiomaOriginal;
    private string  $clasificacionEdad;
    private string  $productora;
    private string  $sinopsis;
    private ?string $createdAt;
    private ?string $updatedAt;

    public function __construct(
        string $id, string $nombre, string $tituloOriginal, string $director,
        string $genero, int $duracionMinutos, string $fechaEstreno,
        string $paisOrigen, string $idiomaOriginal, string $clasificacionEdad,
        string $productora, string $sinopsis,
        ?string $createdAt = null, ?string $updatedAt = null
    ) {
        $this->id                = $id;
        $this->nombre            = $nombre;
        $this->tituloOriginal    = $tituloOriginal;
        $this->director          = $director;
        $this->genero            = $genero;
        $this->duracionMinutos   = $duracionMinutos;
        $this->fechaEstreno      = $fechaEstreno;
        $this->paisOrigen        = $paisOrigen;
        $this->idiomaOriginal    = $idiomaOriginal;
        $this->clasificacionEdad = $clasificacionEdad;
        $this->productora        = $productora;
        $this->sinopsis          = $sinopsis;
        $this->createdAt         = $createdAt;
        $this->updatedAt         = $updatedAt;
    }

    public function id(): string                { return $this->id; }
    public function nombre(): string            { return $this->nombre; }
    public function tituloOriginal(): string    { return $this->tituloOriginal; }
    public function director(): string          { return $this->director; }
    public function genero(): string            { return $this->genero; }
    public function duracionMinutos(): int      { return $this->duracionMinutos; }
    public function fechaEstreno(): string      { return $this->fechaEstreno; }
    public function paisOrigen(): string        { return $this->paisOrigen; }
    public function idiomaOriginal(): string    { return $this->idiomaOriginal; }
    public function clasificacionEdad(): string { return $this->clasificacionEdad; }
    public function productora(): string        { return $this->productora; }
    public function sinopsis(): string          { return $this->sinopsis; }
    public function createdAt(): ?string        { return $this->createdAt; }
    public function updatedAt(): ?string        { return $this->updatedAt; }
}
