<?php
declare(strict_types=1);

// Guardia de seguridad
(function (): void {
    $requestPath = rtrim((string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH), '/');
    $publicBase  = rtrim(dirname((string) ($_SERVER['SCRIPT_NAME'] ?? '/index.php')), '/');

    if ($requestPath !== $publicBase && !str_starts_with($requestPath, $publicBase . '/')) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $dest = isset($_SESSION['auth']['id']) ? 'home' : 'auth.login';
        header('Location: ' . $publicBase . '/index.php?route=' . $dest);
        exit;
    }
})();

require_once __DIR__ . '/../Common/ClassLoader.php';
require_once __DIR__ . '/../Common/DependencyInjection.php';
require_once __DIR__ . '/../Infrastructure/Entrypoints/Web/Presentation/View.php';
require_once __DIR__ . '/../Infrastructure/Entrypoints/Web/Presentation/Flash.php';

DependencyInjection::boot();
Flash::start();

// --- Auth Helpers ---
function isLoggedIn(): bool
{
    return isset($_SESSION['auth']['id']);
}

function requireAuth(): void
{
    if (!isLoggedIn()) {
        Flash::setMessage('Debes iniciar sesión para acceder a esta sección.');
        View::redirect('auth.login');
    }
}

// --- Routing ---
$route  = isset($_GET['route']) ? trim((string) $_GET['route']) : 'home';
$routes = WebRoutes::routes();

if (!isset($routes[$route])) {
    http_response_code(404);
    echo "Ruta no encontrada";
    exit;
}

$definition = $routes[$route];
$httpMethod = strtoupper((string) $_SERVER['REQUEST_METHOD']);

if ($httpMethod !== $definition['method']) {
    http_response_code(405);
    echo "Método HTTP no permitido";
    exit;
}

// Protect all non-public routes
$publicActions = array('home', 'login', 'authenticate', 'logout', 'forgot', 'forgot.send', 'create', 'store');
if (!in_array($definition['action'], $publicActions, true) && !isLoggedIn()) {
    Flash::setMessage('Debes iniciar sesión para acceder a esta sección.');
    View::redirect('auth.login');
}

// --- Dispatcher ---
try {
    switch ($definition['action']) {
        case 'home':
            View::render('home', [
                'pageTitle' => 'Menú principal',
                'message'   => Flash::message(),
                'success'   => Flash::success(),
            ]);
            break;

        case 'index':
            $controller = DependencyInjection::getUserController();
            $users      = $controller->index();
            View::render('users/list', [
                'pageTitle' => 'Lista de usuarios',
                'users'     => $users,
                'message'   => Flash::message(),
                'success'   => Flash::success(),
            ]);
            break;

        case 'create':
            View::render('users/create', [
                'pageTitle'   => 'Registrar usuario',
                'roleOptions' => UserRoleEnum::values(),
                'message'     => Flash::message(),
                'success'     => Flash::success(),
                'errors'      => Flash::errors(),
                'old'         => Flash::old(),
            ]);
            break;

        case 'store':
            $controller = DependencyInjection::getUserController();
            $id         = bin2hex(random_bytes(16));
            $request    = new CreateUserWebRequest(
                $id,
                $_POST['name']     ?? '',
                $_POST['email']    ?? '',
                $_POST['password'] ?? '',
                $_POST['role']     ?? ''
            );
            $controller->store($request);
            Flash::setSuccess('Usuario registrado correctamente.');
            View::redirect('users.index');
            break;

        case 'delete':
            $controller = DependencyInjection::getUserController();
            $id         = isset($_POST['id']) ? trim((string) $_POST['id']) : '';
            $controller->delete($id);
            Flash::setSuccess('Usuario eliminado correctamente.');
            View::redirect('users.index');
            break;

        case 'login':
            if (isLoggedIn()) {
                View::redirect('home');
            }
            View::render('auth/login', [
                'pageTitle' => 'Iniciar sesión',
                'message'   => Flash::message(),
                'errors'    => Flash::errors(),
                'old'       => Flash::old(),
            ]);
            break;

        case 'authenticate':
            $email    = trim(strtolower((string) ($_POST['email'] ?? '')));
            $password = (string) ($_POST['password'] ?? '');

            $loginUseCase = DependencyInjection::getLoginUseCase();
            $command      = new LoginCommand($email, $password);
            $user         = $loginUseCase->execute($command);

            $_SESSION['auth'] = array(
                'id'    => $user->id()->value(),
                'name'  => $user->name()->value(),
                'email' => $user->email()->value(),
                'role'  => $user->role(),
            );

            Flash::setSuccess('Bienvenido/a, ' . $user->name()->value());
            View::redirect('home');
            break;

        case 'logout':
            session_destroy();
            header('Location: ?route=auth.login');
            exit;

        default:
            throw new RuntimeException('Acción no soportada.');
    }
} catch (Throwable $exception) {
    Flash::setMessage($exception->getMessage());
    switch ($route) {
        case 'users.store':
            Flash::setOld($_POST);
            View::redirect('users.create');
            break;
        case 'auth.authenticate':
            Flash::setOld(['email' => $_POST['email'] ?? '']);
            View::redirect('auth.login');
            break;
        default:
            View::redirect('home');
            break;
    }
}
