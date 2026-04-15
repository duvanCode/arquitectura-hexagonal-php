<?php
declare(strict_types=1);

require_once __DIR__ . '/../ValueObjects/MovieId.php';
require_once __DIR__ . '/../ValueObjects/MovieTitle.php';
require_once __DIR__ . '/../ValueObjects/MovieDirector.php';
require_once __DIR__ . '/../ValueObjects/MovieDuration.php';
require_once __DIR__ . '/../ValueObjects/MovieReleaseDate.php';
require_once __DIR__ . '/../ValueObjects/MovieCountry.php';
require_once __DIR__ . '/../ValueObjects/MovieLanguage.php';
require_once __DIR__ . '/../ValueObjects/MovieProducer.php';
require_once __DIR__ . '/../ValueObjects/MovieSynopsis.php';
require_once __DIR__ . '/../Enums/MovieGenreEnum.php';
require_once __DIR__ . '/../Enums/MovieAgeRatingEnum.php';

final class MovieModel
{
    private MovieId          $id;
    private MovieTitle       $nombre;
    private MovieTitle       $tituloOriginal;
    private MovieDirector    $director;
    private string           $genero;
    private MovieDuration    $duracionMinutos;
    private MovieReleaseDate $fechaEstreno;
    private MovieCountry     $paisOrigen;
    private MovieLanguage    $idiomaOriginal;
    private string           $clasificacionEdad;
    private MovieProducer    $productora;
    private MovieSynopsis    $sinopsis;

    public function __construct(
        MovieId          $id,
        MovieTitle       $nombre,
        MovieTitle       $tituloOriginal,
        MovieDirector    $director,
        string           $genero,
        MovieDuration    $duracionMinutos,
        MovieReleaseDate $fechaEstreno,
        MovieCountry     $paisOrigen,
        MovieLanguage    $idiomaOriginal,
        string           $clasificacionEdad,
        MovieProducer    $productora,
        MovieSynopsis    $sinopsis
    ) {
        MovieGenreEnum::ensureIsValid($genero);
        MovieAgeRatingEnum::ensureIsValid($clasificacionEdad);

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

    public static function create(
        MovieId          $id,
        MovieTitle       $nombre,
        MovieTitle       $tituloOriginal,
        MovieDirector    $director,
        string           $genero,
        MovieDuration    $duracionMinutos,
        MovieReleaseDate $fechaEstreno,
        MovieCountry     $paisOrigen,
        MovieLanguage    $idiomaOriginal,
        string           $clasificacionEdad,
        MovieProducer    $productora,
        MovieSynopsis    $sinopsis
    ): self {
        return new self(
            $id, $nombre, $tituloOriginal, $director, $genero,
            $duracionMinutos, $fechaEstreno, $paisOrigen, $idiomaOriginal,
            $clasificacionEdad, $productora, $sinopsis
        );
    }

    public function id(): MovieId                  { return $this->id; }
    public function nombre(): MovieTitle           { return $this->nombre; }
    public function tituloOriginal(): MovieTitle   { return $this->tituloOriginal; }
    public function director(): MovieDirector      { return $this->director; }
    public function genero(): string               { return $this->genero; }
    public function duracionMinutos(): MovieDuration  { return $this->duracionMinutos; }
    public function fechaEstreno(): MovieReleaseDate  { return $this->fechaEstreno; }
    public function paisOrigen(): MovieCountry     { return $this->paisOrigen; }
    public function idiomaOriginal(): MovieLanguage   { return $this->idiomaOriginal; }
    public function clasificacionEdad(): string    { return $this->clasificacionEdad; }
    public function productora(): MovieProducer    { return $this->productora; }
    public function sinopsis(): MovieSynopsis      { return $this->sinopsis; }

    public function changeNombre(MovieTitle $nombre): self
    {
        return new self(
            $this->id, $nombre, $this->tituloOriginal, $this->director,
            $this->genero, $this->duracionMinutos, $this->fechaEstreno,
            $this->paisOrigen, $this->idiomaOriginal, $this->clasificacionEdad,
            $this->productora, $this->sinopsis
        );
    }

    public function toArray(): array
    {
        return array(
            'id'                 => $this->id->value(),
            'nombre'             => $this->nombre->value(),
            'titulo_original'    => $this->tituloOriginal->value(),
            'director'           => $this->director->value(),
            'genero'             => $this->genero,
            'duracion_minutos'   => $this->duracionMinutos->value(),
            'fecha_estreno'      => $this->fechaEstreno->value(),
            'pais_origen'        => $this->paisOrigen->value(),
            'idioma_original'    => $this->idiomaOriginal->value(),
            'clasificacion_edad' => $this->clasificacionEdad,
            'productora'         => $this->productora->value(),
            'sinopsis'           => $this->sinopsis->value(),
        );
    }
}
