<?php
declare(strict_types=1);

require_once __DIR__ . '/../Entity/MovieEntity.php';
require_once __DIR__ . '/../Dto/MoviePersistenceDto.php';
require_once __DIR__ . '/../../../../../Domain/Models/MovieModel.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/MovieId.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/MovieTitle.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/MovieDirector.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/MovieDuration.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/MovieReleaseDate.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/MovieCountry.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/MovieLanguage.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/MovieProducer.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/MovieSynopsis.php';

final class MoviePersistenceMapper
{
    public function fromModelToDto(MovieModel $movie): MoviePersistenceDto
    {
        return new MoviePersistenceDto(
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

    public function fromRowToEntity(array $row): MovieEntity
    {
        return new MovieEntity(
            (string) $row['id'],
            (string) $row['nombre'],
            (string) $row['titulo_original'],
            (string) $row['director'],
            (string) $row['genero'],
            (int)    $row['duracion_minutos'],
            (string) $row['fecha_estreno'],
            (string) $row['pais_origen'],
            (string) $row['idioma_original'],
            (string) $row['clasificacion_edad'],
            (string) $row['productora'],
            (string) $row['sinopsis'],
            isset($row['created_at']) ? (string) $row['created_at'] : null,
            isset($row['updated_at']) ? (string) $row['updated_at'] : null
        );
    }

    public function fromEntityToModel(MovieEntity $entity): MovieModel
    {
        return new MovieModel(
            new MovieId($entity->id()),
            new MovieTitle($entity->nombre()),
            new MovieTitle($entity->tituloOriginal()),
            new MovieDirector($entity->director()),
            $entity->genero(),
            new MovieDuration($entity->duracionMinutos()),
            new MovieReleaseDate($entity->fechaEstreno()),
            new MovieCountry($entity->paisOrigen()),
            new MovieLanguage($entity->idiomaOriginal()),
            $entity->clasificacionEdad(),
            new MovieProducer($entity->productora()),
            new MovieSynopsis($entity->sinopsis())
        );
    }

    public function fromRowToModel(array $row): MovieModel
    {
        return $this->fromEntityToModel($this->fromRowToEntity($row));
    }

    /** @return MovieModel[] */
    public function fromRowsToModels(array $rows): array
    {
        $models = array();
        foreach ($rows as $row) {
            $models[] = $this->fromRowToModel($row);
        }
        return $models;
    }
}
