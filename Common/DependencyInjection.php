<?php
declare(strict_types=1);

require_once __DIR__ . '/ClassLoader.php';

final class DependencyInjection
{
    public static function boot(): void
    {
        ClassLoader::register();
    }

    public static function getConnection(): Connection
    {
        return new Connection(
            '127.0.0.1',
            3306,
            'crud_usuarios',
            'root',
            '', // tu contraseña de BD
            'utf8mb4'
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
}
