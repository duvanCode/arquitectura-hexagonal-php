<?php
declare(strict_types=1);

require_once __DIR__ . '/ClassLoader.php';
require_once __DIR__ . '/Env.php';

final class DependencyInjection
{
    public static function boot(): void
    {
        Env::load(dirname(__DIR__) . '/.env');
        ClassLoader::register();
    }

    public static function getConnection(): Connection
    {
        return new Connection(
            Env::get('DB_HOST', '127.0.0.1'),
            Env::getInt('DB_PORT', 3306),
            Env::get('DB_NAME', 'crud_usuarios'),
            Env::get('DB_USER', 'root'),
            Env::get('DB_PASSWORD', ''),
            Env::get('DB_CHARSET', 'utf8mb4')
        );
    }

    public static function getPdo(): PDO
    {
        return self::getConnection()->createPdo();
    }

    public static function getUserPersistenceMapper(): UserPersistenceMapper
    {
        return new UserPersistenceMapper();
    }

    public static function getUserRepository(): UserRepositoryMySQL
    {
        return new UserRepositoryMySQL(self::getPdo(), self::getUserPersistenceMapper());
    }

    public static function getCreateUserUseCase(): CreateUserUseCase
    {
        $repo = self::getUserRepository();
        return new CreateUserService($repo, $repo);
    }

    public static function getUpdateUserUseCase(): UpdateUserUseCase
    {
        $repo = self::getUserRepository();
        return new UpdateUserService($repo, $repo, $repo);
    }

    public static function getDeleteUserUseCase(): DeleteUserUseCase
    {
        $repo = self::getUserRepository();
        return new DeleteUserService($repo, $repo);
    }

    public static function getGetUserByIdUseCase(): GetUserByIdUseCase
    {
        return new GetUserByIdService(self::getUserRepository());
    }

    public static function getGetAllUsersUseCase(): GetAllUsersUseCase
    {
        return new GetAllUsersService(self::getUserRepository());
    }

    public static function getLoginUseCase(): LoginService
    {
        return new LoginService(self::getUserRepository());
    }

    public static function getUserWebMapper(): UserWebMapper
    {
        return new UserWebMapper();
    }

    public static function getUserController(): UserController
    {
        return new UserController(
            self::getCreateUserUseCase(),
            self::getUpdateUserUseCase(),
            self::getGetUserByIdUseCase(),
            self::getGetAllUsersUseCase(),
            self::getDeleteUserUseCase(),
            self::getUserWebMapper()
        );
    }

    // -------------------------------------------------------------------------
    // Movie
    // -------------------------------------------------------------------------

    public static function getMoviePersistenceMapper(): MoviePersistenceMapper
    {
        return new MoviePersistenceMapper();
    }

    public static function getMovieRepository(): MovieRepositoryMySQL
    {
        return new MovieRepositoryMySQL(self::getPdo(), self::getMoviePersistenceMapper());
    }

    public static function getCreateMovieUseCase(): CreateMovieUseCase
    {
        return new CreateMovieService(self::getMovieRepository());
    }

    public static function getUpdateMovieUseCase(): UpdateMovieUseCase
    {
        $repo = self::getMovieRepository();
        return new UpdateMovieService($repo, $repo);
    }

    public static function getDeleteMovieUseCase(): DeleteMovieUseCase
    {
        $repo = self::getMovieRepository();
        return new DeleteMovieService($repo, $repo);
    }

    public static function getGetMovieByIdUseCase(): GetMovieByIdUseCase
    {
        return new GetMovieByIdService(self::getMovieRepository());
    }

    public static function getGetAllMoviesUseCase(): GetAllMoviesUseCase
    {
        return new GetAllMoviesService(self::getMovieRepository());
    }

    public static function getMovieWebMapper(): MovieWebMapper
    {
        return new MovieWebMapper();
    }

    public static function getMovieController(): MovieController
    {
        return new MovieController(
            self::getCreateMovieUseCase(),
            self::getUpdateMovieUseCase(),
            self::getGetMovieByIdUseCase(),
            self::getGetAllMoviesUseCase(),
            self::getDeleteMovieUseCase(),
            self::getMovieWebMapper()
        );
    }
}
