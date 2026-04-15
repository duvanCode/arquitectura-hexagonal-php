<?php
declare(strict_types=1);

final class MoviePersistenceDto
{
    private string $id;
    private string $nombre;
    private string $tituloOriginal;
    private string $director;
    private string $genero;
    private int    $duracionMinutos;
    private string $fechaEstreno;
    private string $paisOrigen;
    private string $idiomaOriginal;
    private string $clasificacionEdad;
    private string $productora;
    private string $sinopsis;

    public function __construct(
        string $id, string $nombre, string $tituloOriginal, string $director,
        string $genero, int $duracionMinutos, string $fechaEstreno,
        string $paisOrigen, string $idiomaOriginal, string $clasificacionEdad,
        string $productora, string $sinopsis
    ) {
        $this->id                = trim($id);
        $this->nombre            = trim($nombre);
        $this->tituloOriginal    = trim($tituloOriginal);
        $this->director          = trim($director);
        $this->genero            = trim($genero);
        $this->duracionMinutos   = $duracionMinutos;
        $this->fechaEstreno      = trim($fechaEstreno);
        $this->paisOrigen        = trim($paisOrigen);
        $this->idiomaOriginal    = trim($idiomaOriginal);
        $this->clasificacionEdad = trim($clasificacionEdad);
        $this->productora        = trim($productora);
        $this->sinopsis          = trim($sinopsis);
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
}
