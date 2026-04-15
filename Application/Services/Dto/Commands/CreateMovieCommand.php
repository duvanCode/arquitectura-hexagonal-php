<?php
declare(strict_types=1);

final class CreateMovieCommand
{
    private string $id;
    private string $nombre;
    private string $tituloOriginal;
    private string $director;
    private string $genero;
    private string $duracionMinutos;
    private string $fechaEstreno;
    private string $paisOrigen;
    private string $idiomaOriginal;
    private string $clasificacionEdad;
    private string $productora;
    private string $sinopsis;

    public function __construct(
        string $id, string $nombre, string $tituloOriginal, string $director,
        string $genero, string $duracionMinutos, string $fechaEstreno,
        string $paisOrigen, string $idiomaOriginal, string $clasificacionEdad,
        string $productora, string $sinopsis
    ) {
        $this->id                = trim($id);
        $this->nombre            = trim($nombre);
        $this->tituloOriginal    = trim($tituloOriginal);
        $this->director          = trim($director);
        $this->genero            = trim($genero);
        $this->duracionMinutos   = trim($duracionMinutos);
        $this->fechaEstreno      = trim($fechaEstreno);
        $this->paisOrigen        = trim($paisOrigen);
        $this->idiomaOriginal    = trim($idiomaOriginal);
        $this->clasificacionEdad = trim($clasificacionEdad);
        $this->productora        = trim($productora);
        $this->sinopsis          = trim($sinopsis);
    }

    public function getId(): string                { return $this->id; }
    public function getNombre(): string            { return $this->nombre; }
    public function getTituloOriginal(): string    { return $this->tituloOriginal; }
    public function getDirector(): string          { return $this->director; }
    public function getGenero(): string            { return $this->genero; }
    public function getDuracionMinutos(): string   { return $this->duracionMinutos; }
    public function getFechaEstreno(): string      { return $this->fechaEstreno; }
    public function getPaisOrigen(): string        { return $this->paisOrigen; }
    public function getIdiomaOriginal(): string    { return $this->idiomaOriginal; }
    public function getClasificacionEdad(): string { return $this->clasificacionEdad; }
    public function getProductora(): string        { return $this->productora; }
    public function getSinopsis(): string          { return $this->sinopsis; }
}
