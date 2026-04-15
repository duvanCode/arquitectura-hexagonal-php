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

        // Domain - Movie Exceptions
        'InvalidMovieIdException'          => 'Domain/Exceptions/InvalidMovieIdException.php',
        'InvalidMovieTitleException'       => 'Domain/Exceptions/InvalidMovieTitleException.php',
        'InvalidMovieDirectorException'    => 'Domain/Exceptions/InvalidMovieDirectorException.php',
        'InvalidMovieDurationException'    => 'Domain/Exceptions/InvalidMovieDurationException.php',
        'InvalidMovieReleaseDateException' => 'Domain/Exceptions/InvalidMovieReleaseDateException.php',
        'MovieNotFoundException'           => 'Domain/Exceptions/MovieNotFoundException.php',
        // Domain - Movie Enums
        'MovieGenreEnum'     => 'Domain/Enums/MovieGenreEnum.php',
        'MovieAgeRatingEnum' => 'Domain/Enums/MovieAgeRatingEnum.php',
        // Domain - Movie Value Objects
        'MovieId'          => 'Domain/ValueObjects/MovieId.php',
        'MovieTitle'       => 'Domain/ValueObjects/MovieTitle.php',
        'MovieDirector'    => 'Domain/ValueObjects/MovieDirector.php',
        'MovieDuration'    => 'Domain/ValueObjects/MovieDuration.php',
        'MovieReleaseDate' => 'Domain/ValueObjects/MovieReleaseDate.php',
        'MovieCountry'     => 'Domain/ValueObjects/MovieCountry.php',
        'MovieLanguage'    => 'Domain/ValueObjects/MovieLanguage.php',
        'MovieProducer'    => 'Domain/ValueObjects/MovieProducer.php',
        'MovieSynopsis'    => 'Domain/ValueObjects/MovieSynopsis.php',
        // Domain - Movie Model
        'MovieModel' => 'Domain/Models/MovieModel.php',
        // Domain - Movie Events
        'MovieCreatedDomainEvent' => 'Domain/Events/MovieCreatedDomainEvent.php',
        'MovieUpdatedDomainEvent' => 'Domain/Events/MovieUpdatedDomainEvent.php',
        'MovieDeletedDomainEvent' => 'Domain/Events/MovieDeletedDomainEvent.php',

        // Domain - Password Reset Exceptions
        'InvalidResetTokenException'  => 'Domain/Exceptions/InvalidResetTokenException.php',
        'ResetTokenExpiredException'  => 'Domain/Exceptions/ResetTokenExpiredException.php',

        // Application - Password Reset Ports In
        'ForgotPasswordUseCase' => 'Application/Ports/In/ForgotPasswordUseCase.php',
        'ResetPasswordUseCase'  => 'Application/Ports/In/ResetPasswordUseCase.php',
        // Application - Password Reset Ports Out
        'SavePasswordResetPort'       => 'Application/Ports/Out/SavePasswordResetPort.php',
        'FindPasswordResetPort'       => 'Application/Ports/Out/FindPasswordResetPort.php',
        'InvalidatePasswordResetPort' => 'Application/Ports/Out/InvalidatePasswordResetPort.php',
        'SendMailPort'                => 'Application/Ports/Out/SendMailPort.php',
        // Application - Password Reset Commands & Data
        'ForgotPasswordCommand' => 'Application/Services/Dto/Commands/ForgotPasswordCommand.php',
        'ResetPasswordCommand'  => 'Application/Services/Dto/Commands/ResetPasswordCommand.php',
        'PasswordResetData'     => 'Application/Services/Dto/PasswordResetData.php',
        // Application - Password Reset Services
        'ForgotPasswordService' => 'Application/Services/ForgotPasswordService.php',
        'ResetPasswordService'  => 'Application/Services/ResetPasswordService.php',

        // Infrastructure - Mail
        'SmtpMailer' => 'Infrastructure/Adapters/Mail/SmtpMailer.php',
        // Infrastructure - Password Reset Repository
        'PasswordResetRepositoryMySQL' => 'Infrastructure/Adapters/Persistence/MySQL/Repository/PasswordResetRepositoryMySQL.php',

        // Application - Movie Ports In
        'CreateMovieUseCase'  => 'Application/Ports/In/CreateMovieUseCase.php',
        'UpdateMovieUseCase'  => 'Application/Ports/In/UpdateMovieUseCase.php',
        'GetMovieByIdUseCase' => 'Application/Ports/In/GetMovieByIdUseCase.php',
        'GetAllMoviesUseCase' => 'Application/Ports/In/GetAllMoviesUseCase.php',
        'DeleteMovieUseCase'  => 'Application/Ports/In/DeleteMovieUseCase.php',
        // Application - Movie Ports Out
        'SaveMoviePort'       => 'Application/Ports/Out/SaveMoviePort.php',
        'UpdateMoviePort'     => 'Application/Ports/Out/UpdateMoviePort.php',
        'GetMovieByIdPort'    => 'Application/Ports/Out/GetMovieByIdPort.php',
        'GetAllMoviesPort'    => 'Application/Ports/Out/GetAllMoviesPort.php',
        'DeleteMoviePort'     => 'Application/Ports/Out/DeleteMoviePort.php',
        // Application - Movie Commands
        'CreateMovieCommand' => 'Application/Services/Dto/Commands/CreateMovieCommand.php',
        'UpdateMovieCommand' => 'Application/Services/Dto/Commands/UpdateMovieCommand.php',
        'DeleteMovieCommand' => 'Application/Services/Dto/Commands/DeleteMovieCommand.php',
        // Application - Movie Queries
        'GetMovieByIdQuery' => 'Application/Services/Dto/Queries/GetMovieByIdQuery.php',
        'GetAllMoviesQuery' => 'Application/Services/Dto/Queries/GetAllMoviesQuery.php',
        // Application - Movie Services
        'CreateMovieService'    => 'Application/Services/CreateMovieService.php',
        'UpdateMovieService'    => 'Application/Services/UpdateMovieService.php',
        'GetMovieByIdService'   => 'Application/Services/GetMovieByIdService.php',
        'GetAllMoviesService'   => 'Application/Services/GetAllMoviesService.php',
        'DeleteMovieService'    => 'Application/Services/DeleteMovieService.php',
        'MovieApplicationMapper' => 'Application/Services/Mappers/MovieApplicationMapper.php',

        // Infrastructure - MySQL
        'Connection'           => 'Infrastructure/Adapters/Persistence/MySQL/Config/Connection.php',
        'UserPersistenceDto'   => 'Infrastructure/Adapters/Persistence/MySQL/Dto/UserPersistenceDto.php',
        'UserEntity'           => 'Infrastructure/Adapters/Persistence/MySQL/Entity/UserEntity.php',
        'UserPersistenceMapper' => 'Infrastructure/Adapters/Persistence/MySQL/Mapper/UserPersistenceMapper.php',
        'UserRepositoryMySQL'  => 'Infrastructure/Adapters/Persistence/MySQL/Repository/UserRepositoryMySQL.php',
        'MoviePersistenceDto'   => 'Infrastructure/Adapters/Persistence/MySQL/Dto/MoviePersistenceDto.php',
        'MovieEntity'           => 'Infrastructure/Adapters/Persistence/MySQL/Entity/MovieEntity.php',
        'MoviePersistenceMapper' => 'Infrastructure/Adapters/Persistence/MySQL/Mapper/MoviePersistenceMapper.php',
        'MovieRepositoryMySQL'  => 'Infrastructure/Adapters/Persistence/MySQL/Repository/MovieRepositoryMySQL.php',

        // Infrastructure - Entrypoints Web
        'CreateUserWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/CreateUserRequest.php',
        'UpdateUserWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UpdateUserRequest.php',
        'LoginWebRequest'      => 'Infrastructure/Entrypoints/Web/Controllers/Dto/LoginWebRequest.php',
        'UserResponse'         => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UserResponse.php',
        'UserWebMapper'        => 'Infrastructure/Entrypoints/Web/Controllers/Mapper/UserWebMapper.php',
        'UserController'       => 'Infrastructure/Entrypoints/Web/Controllers/UserController.php',
        'CreateMovieWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/CreateMovieRequest.php',
        'UpdateMovieWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UpdateMovieRequest.php',
        'MovieResponse'         => 'Infrastructure/Entrypoints/Web/Controllers/Dto/MovieResponse.php',
        'MovieWebMapper'        => 'Infrastructure/Entrypoints/Web/Controllers/Mapper/MovieWebMapper.php',
        'MovieController'       => 'Infrastructure/Entrypoints/Web/Controllers/MovieController.php',
        'WebRoutes'            => 'Infrastructure/Entrypoints/Web/Controllers/Config/WebRoutes.php',
        'View'                 => 'Infrastructure/Entrypoints/Web/Presentation/View.php',
        'Flash'                => 'Infrastructure/Entrypoints/Web/Presentation/Flash.php',

        // Common
        'Env'                 => 'Common/Env.php',
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
