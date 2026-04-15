<?php
declare(strict_types=1);

final class MovieResponse
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
        string $id,
        string $nombre,
        string $tituloOriginal,
        string $director,
        string $genero,
        int    $duracionMinutos,
        string $fechaEstreno,
        string $paisOrigen,
        string $idiomaOriginal,
        string $clasificacionEdad,
        string $productora,
        string $sinopsis
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
    }

    public function getId(): string                { return $this->id; }
    public function getNombre(): string            { return $this->nombre; }
    public function getTituloOriginal(): string    { return $this->tituloOriginal; }
    public function getDirector(): string          { return $this->director; }
    public function getGenero(): string            { return $this->genero; }
    public function getDuracionMinutos(): int      { return $this->duracionMinutos; }
    public function getFechaEstreno(): string      { return $this->fechaEstreno; }
    public function getPaisOrigen(): string        { return $this->paisOrigen; }
    public function getIdiomaOriginal(): string    { return $this->idiomaOriginal; }
    public function getClasificacionEdad(): string { return $this->clasificacionEdad; }
    public function getProductora(): string        { return $this->productora; }
    public function getSinopsis(): string          { return $this->sinopsis; }

    public function toArray(): array
    {
        return array(
            'id'                 => $this->id,
            'nombre'             => $this->nombre,
            'titulo_original'    => $this->tituloOriginal,
            'director'           => $this->director,
            'genero'             => $this->genero,
            'duracion_minutos'   => $this->duracionMinutos,
            'fecha_estreno'      => $this->fechaEstreno,
            'pais_origen'        => $this->paisOrigen,
            'idioma_original'    => $this->idiomaOriginal,
            'clasificacion_edad' => $this->clasificacionEdad,
            'productora'         => $this->productora,
            'sinopsis'           => $this->sinopsis,
        );
    }
}
