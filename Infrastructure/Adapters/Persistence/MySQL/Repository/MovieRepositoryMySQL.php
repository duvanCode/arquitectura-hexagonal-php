<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../../../Application/Ports/Out/SaveMoviePort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/UpdateMoviePort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetMovieByIdPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetAllMoviesPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/DeleteMoviePort.php';
require_once __DIR__ . '/../Mapper/MoviePersistenceMapper.php';
require_once __DIR__ . '/../../../../../Domain/Models/MovieModel.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/MovieId.php';

final class MovieRepositoryMySQL implements
    SaveMoviePort,
    UpdateMoviePort,
    GetMovieByIdPort,
    GetAllMoviesPort,
    DeleteMoviePort
{
    private PDO                  $pdo;
    private MoviePersistenceMapper $mapper;

    public function __construct(PDO $pdo, MoviePersistenceMapper $mapper)
    {
        $this->pdo    = $pdo;
        $this->mapper = $mapper;
    }

    public function save(MovieModel $movie): MovieModel
    {
        $dto = $this->mapper->fromModelToDto($movie);
        $sql = '
            INSERT INTO movies (
                id, nombre, titulo_original, director, genero,
                duracion_minutos, fecha_estreno, pais_origen,
                idioma_original, clasificacion_edad, productora,
                sinopsis, created_at, updated_at
            ) VALUES (
                :id, :nombre, :titulo_original, :director, :genero,
                :duracion_minutos, :fecha_estreno, :pais_origen,
                :idioma_original, :clasificacion_edad, :productora,
                :sinopsis, NOW(), NOW()
            )
        ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(
            ':id'                 => $dto->id(),
            ':nombre'             => $dto->nombre(),
            ':titulo_original'    => $dto->tituloOriginal(),
            ':director'           => $dto->director(),
            ':genero'             => $dto->genero(),
            ':duracion_minutos'   => $dto->duracionMinutos(),
            ':fecha_estreno'      => $dto->fechaEstreno(),
            ':pais_origen'        => $dto->paisOrigen(),
            ':idioma_original'    => $dto->idiomaOriginal(),
            ':clasificacion_edad' => $dto->clasificacionEdad(),
            ':productora'         => $dto->productora(),
            ':sinopsis'           => $dto->sinopsis(),
        ));

        $saved = $this->getById(new MovieId($dto->id()));
        if ($saved === null) {
            throw new RuntimeException('No se pudo recuperar la película después de guardarla.');
        }
        return $saved;
    }

    public function update(MovieModel $movie): MovieModel
    {
        $dto = $this->mapper->fromModelToDto($movie);
        $sql = '
            UPDATE movies
            SET nombre             = :nombre,
                titulo_original    = :titulo_original,
                director           = :director,
                genero             = :genero,
                duracion_minutos   = :duracion_minutos,
                fecha_estreno      = :fecha_estreno,
                pais_origen        = :pais_origen,
                idioma_original    = :idioma_original,
                clasificacion_edad = :clasificacion_edad,
                productora         = :productora,
                sinopsis           = :sinopsis,
                updated_at         = NOW()
            WHERE id = :id
        ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(
            ':id'                 => $dto->id(),
            ':nombre'             => $dto->nombre(),
            ':titulo_original'    => $dto->tituloOriginal(),
            ':director'           => $dto->director(),
            ':genero'             => $dto->genero(),
            ':duracion_minutos'   => $dto->duracionMinutos(),
            ':fecha_estreno'      => $dto->fechaEstreno(),
            ':pais_origen'        => $dto->paisOrigen(),
            ':idioma_original'    => $dto->idiomaOriginal(),
            ':clasificacion_edad' => $dto->clasificacionEdad(),
            ':productora'         => $dto->productora(),
            ':sinopsis'           => $dto->sinopsis(),
        ));

        $updated = $this->getById(new MovieId($dto->id()));
        if ($updated === null) {
            throw new RuntimeException('No se pudo recuperar la película después de actualizarla.');
        }
        return $updated;
    }

    public function getById(MovieId $movieId): ?MovieModel
    {
        $sql  = 'SELECT * FROM movies WHERE id = :id LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(':id' => $movieId->value()));
        $row = $stmt->fetch();
        return $row !== false ? $this->mapper->fromRowToModel($row) : null;
    }

    public function getAll(): array
    {
        $sql  = 'SELECT * FROM movies ORDER BY nombre ASC';
        $stmt = $this->pdo->query($sql);
        return $this->mapper->fromRowsToModels($stmt->fetchAll());
    }

    public function delete(MovieId $movieId): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM movies WHERE id = :id');
        $stmt->execute(array(':id' => $movieId->value()));
    }
}
