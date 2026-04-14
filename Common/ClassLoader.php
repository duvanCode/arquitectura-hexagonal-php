<?php
declare(strict_types=1);

final class ClassLoader
{
    private static array $classMap = array(
        // Domain - Exceptions
        'InvalidUserEmailException'    => 'Domain/Exceptions/InvalidUserEmailException.php',
        'InvalidUserIdException'       => 'Domain/Exceptions/InvalidUserIdException.php',
        'InvalidUserNameException'     => 'Domain/Exceptions/InvalidUserNameException.php',
        'InvalidUserPasswordException' => 'Domain/Exceptions/InvalidUserPasswordException.php',
        'InvalidUserRoleException'     => 'Domain/Exceptions/InvalidUserRoleException.php',
        'InvalidUserStatusException'   => 'Domain/Exceptions/InvalidUserStatusException.php',
        'UserAlreadyExistsException'   => 'Domain/Exceptions/UserAlreadyExistsException.php',
        'UserNotFoundException'        => 'Domain/Exceptions/UserNotFoundException.php',
        'InvalidCredentialsException'  => 'Domain/Exceptions/InvalidCredentialsException.php',
        // Domain - Enums
        'UserRoleEnum'   => 'Domain/Enums/UserRoleEnum.php',
        'UserStatusEnum' => 'Domain/Enums/UserStatusEnum.php',
        // Domain - Value Objects
        'UserId'       => 'Domain/ValueObjects/UserId.php',
        'UserName'     => 'Domain/ValueObjects/UserName.php',
        'UserEmail'    => 'Domain/ValueObjects/UserEmail.php',
        'UserPassword' => 'Domain/ValueObjects/UserPassword.php',
        // Domain - Models
        'UserModel' => 'Domain/Models/UserModel.php',

        // Application - Ports In
        'CreateUserUseCase'  => 'Application/Ports/In/CreateUserUseCase.php',
        'UpdateUserUseCase'  => 'Application/Ports/In/UpdateUserUseCase.php',
        'GetUserByIdUseCase' => 'Application/Ports/In/GetUserByIdUseCase.php',
        'GetAllUsersUseCase' => 'Application/Ports/In/GetAllUsersUseCase.php',
        'DeleteUserUseCase'  => 'Application/Ports/In/DeleteUserUseCase.php',
        // Application - Ports Out
        'SaveUserPort'       => 'Application/Ports/Out/SaveUserPort.php',
        'UpdateUserPort'     => 'Application/Ports/Out/UpdateUserPort.php',
        'GetUserByIdPort'    => 'Application/Ports/Out/GetUserByIdPort.php',
        'GetUserByEmailPort' => 'Application/Ports/Out/GetUserByEmailPort.php',
        'GetAllUsersPort'    => 'Application/Ports/Out/GetAllUsersPort.php',
        'DeleteUserPort'     => 'Application/Ports/Out/DeleteUserPort.php',
        // Application - Commands
        'CreateUserCommand' => 'Application/Services/Dto/Commands/CreateUserCommand.php',
        'UpdateUserCommand' => 'Application/Services/Dto/Commands/UpdateUserCommand.php',
        'DeleteUserCommand' => 'Application/Services/Dto/Commands/DeleteUserCommand.php',
        'LoginCommand'      => 'Application/Services/Dto/Commands/LoginCommand.php',
        // Application - Queries
        'GetUserByIdQuery' => 'Application/Services/Dto/Queries/GetUserByIdQuery.php',
        'GetAllUsersQuery' => 'Application/Services/Dto/Queries/GetAllUsersQuery.php',
        // Application - Services
        'CreateUserService'    => 'Application/Services/CreateUserService.php',
        'UpdateUserService'    => 'Application/Services/UpdateUserService.php',
        'GetUserByIdService'   => 'Application/Services/GetUserByIdService.php',
        'GetAllUsersService'   => 'Application/Services/GetAllUsersService.php',
        'DeleteUserService'    => 'Application/Services/DeleteUserService.php',
        'LoginService'         => 'Application/Services/LoginService.php',
        'UserApplicationMapper' => 'Application/Services/Mappers/UserApplicationMapper.php',

        // Infrastructure - MySQL
        'Connection'           => 'Infrastructure/Adapters/Persistence/MySQL/Config/Connection.php',
        'UserPersistenceDto'   => 'Infrastructure/Adapters/Persistence/MySQL/Dto/UserPersistenceDto.php',
        'UserEntity'           => 'Infrastructure/Adapters/Persistence/MySQL/Entity/UserEntity.php',
        'UserPersistenceMapper' => 'Infrastructure/Adapters/Persistence/MySQL/Mapper/UserPersistenceMapper.php',
        'UserRepositoryMySQL'  => 'Infrastructure/Adapters/Persistence/MySQL/Repository/UserRepositoryMySQL.php',

        // Infrastructure - Entrypoints Web
        'CreateUserWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/CreateUserRequest.php',
        'UpdateUserWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UpdateUserRequest.php',
        'LoginWebRequest'      => 'Infrastructure/Entrypoints/Web/Controllers/Dto/LoginWebRequest.php',
        'UserResponse'         => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UserResponse.php',
        'UserWebMapper'        => 'Infrastructure/Entrypoints/Web/Controllers/Mapper/UserWebMapper.php',
        'UserController'       => 'Infrastructure/Entrypoints/Web/Controllers/UserController.php',
        'WebRoutes'            => 'Infrastructure/Entrypoints/Web/Controllers/Config/WebRoutes.php',
        'View'                 => 'Infrastructure/Entrypoints/Web/Presentation/View.php',
        'Flash'                => 'Infrastructure/Entrypoints/Web/Presentation/Flash.php',

        // Common
        'DependencyInjection' => 'Common/DependencyInjection.php',
    );

    public static function register(): void
    {
        spl_autoload_register(array(self::class, 'loadClass'));
    }

    public static function loadClass(string $className): void
    {
        if (!isset(self::$classMap[$className])) {
            return;
        }

        $baseDir  = dirname(__DIR__) . DIRECTORY_SEPARATOR;
        $filePath = $baseDir . self::$classMap[$className];

        if (!file_exists($filePath)) {
            throw new RuntimeException(sprintf(
                'No se encontró el archivo para la clase %s en %s',
                $className,
                $filePath
            ));
        }

        require_once $filePath;
    }
}
