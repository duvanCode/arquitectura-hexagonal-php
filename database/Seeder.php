<?php
declare(strict_types=1);

/**
 * Seeder — Inicializa la base de datos y crea el usuario administrador.
 *
 * Uso desde la terminal (en la raíz del proyecto):
 *   php database/Seeder.php
 *
 * Uso desde el navegador (solo en entorno local):
 *   http://localhost/arquitectura-hexagonal-php/database/Seeder.php
 */

// ── Configuración de conexión ─────────────────────────────────────────────
// Prioridad: variables de entorno (Docker) → valores locales por defecto
$host     = getenv('DB_HOST')          ?: '127.0.0.1';
$port     = (int) (getenv('DB_PORT')   ?: 3306);
$dbName   = getenv('DB_NAME')          ?: 'crud_usuarios';
// En Docker usamos la contraseña root; localmente puede ser vacía
$username = getenv('DB_USER')     ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';

// ── Credenciales del usuario administrador inicial ─────────────────────────
$adminName     = 'Administrador';
$adminEmail    = 'admin@admin.com';
$adminPassword = 'Admin1234!';   // <-- cámbiala después del primer login
$adminRole     = 'ADMIN';
$adminStatus   = 'ACTIVE';

// ── Helpers de output ─────────────────────────────────────────────────────
$isCli = PHP_SAPI === 'cli';

function ok(string $msg): void
{
    global $isCli;
    echo $isCli ? "  ✓ $msg\n" : "<p style='color:green'>✓ $msg</p>";
}

function warn(string $msg): void
{
    global $isCli;
    echo $isCli ? "  ⚠ $msg\n" : "<p style='color:orange'>⚠ $msg</p>";
}

function fail(string $msg): void
{
    global $isCli;
    echo $isCli ? "  ✗ $msg\n" : "<p style='color:red'>✗ $msg</p>";
}

function titulo(string $msg): void
{
    global $isCli;
    echo $isCli ? "\n── $msg\n" : "<h3>$msg</h3>";
}

// ── Inicio ─────────────────────────────────────────────────────────────────
if (!$isCli) {
    echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">
          <title>Seeder</title></head><body><h2>Seeder — CRUD Usuarios</h2>';
}

try {
    // 1. Conectar a MySQL SIN base de datos para poder crearla
    titulo('Paso 1: Conectar a MySQL');
    $pdo = new PDO(
        "mysql:host=$host;port=$port;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
    ok("Conexión a MySQL establecida ({$host}:{$port})");

    // 2. Crear la base de datos si no existe
    titulo('Paso 2: Crear base de datos');
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}`
                CHARACTER SET utf8mb4
                COLLATE utf8mb4_unicode_ci");
    ok("Base de datos '{$dbName}' lista");

    // 3. Seleccionar la base de datos
    $pdo->exec("USE `{$dbName}`");

    // 4. Crear la tabla users
    titulo('Paso 3: Crear tabla users');
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id         VARCHAR(36)  NOT NULL,
            name       VARCHAR(100) NOT NULL,
            email      VARCHAR(150) NOT NULL,
            password   VARCHAR(255) NOT NULL,
            role       VARCHAR(30)  NOT NULL,
            status     VARCHAR(30)  NOT NULL,
            created_at DATETIME     NOT NULL,
            updated_at DATETIME     NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY uk_users_email (email)
        ) ENGINE=InnoDB
          DEFAULT CHARSET=utf8mb4
          COLLATE=utf8mb4_unicode_ci
    ");
    ok("Tabla 'users' lista");

    // 5. Crear la tabla password_resets
    titulo('Paso 4: Crear tabla password_resets');
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS password_resets (
            token      VARCHAR(64)  NOT NULL,
            email      VARCHAR(150) NOT NULL,
            expires_at DATETIME     NOT NULL,
            used       TINYINT(1)   NOT NULL DEFAULT 0,
            created_at DATETIME     NOT NULL,
            PRIMARY KEY (token),
            KEY idx_password_resets_email (email)
        ) ENGINE=InnoDB
          DEFAULT CHARSET=utf8mb4
          COLLATE=utf8mb4_unicode_ci
    ");
    ok("Tabla 'password_resets' lista");

    // 6. Crear la tabla movies
    titulo('Paso 5: Crear tabla movies');
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS movies (
            id                 VARCHAR(36)  NOT NULL,
            nombre             VARCHAR(200) NOT NULL,
            titulo_original    VARCHAR(200) NOT NULL,
            director           VARCHAR(150) NOT NULL,
            genero             VARCHAR(50)  NOT NULL,
            duracion_minutos   INT          NOT NULL,
            fecha_estreno      DATE         NOT NULL,
            pais_origen        VARCHAR(100) NOT NULL,
            idioma_original    VARCHAR(100) NOT NULL,
            clasificacion_edad VARCHAR(30)  NOT NULL,
            productora         VARCHAR(200) NOT NULL,
            sinopsis           TEXT         NOT NULL,
            created_at         DATETIME     NOT NULL,
            updated_at         DATETIME     NOT NULL,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB
          DEFAULT CHARSET=utf8mb4
          COLLATE=utf8mb4_unicode_ci
    ");
    ok("Tabla 'movies' lista");

    // 7. Verificar si el admin ya existe
    titulo('Paso 6: Crear usuario administrador');
    $check = $pdo->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
    $check->execute([':email' => strtolower(trim($adminEmail))]);

    if ($check->fetch()) {
        warn("El usuario '{$adminEmail}' ya existe, no se modificó.");
    } else {
        $id             = bin2hex(random_bytes(16));
        $hashedPassword = password_hash($adminPassword, PASSWORD_BCRYPT);
        $now            = date('Y-m-d H:i:s');

        $stmt = $pdo->prepare("
            INSERT INTO users (id, name, email, password, role, status, created_at, updated_at)
            VALUES (:id, :name, :email, :password, :role, :status, :created_at, :updated_at)
        ");
        $stmt->execute([
            ':id'         => $id,
            ':name'       => $adminName,
            ':email'      => strtolower(trim($adminEmail)),
            ':password'   => $hashedPassword,
            ':role'       => $adminRole,
            ':status'     => $adminStatus,
            ':created_at' => $now,
            ':updated_at' => $now,
        ]);

        ok("Usuario administrador creado:");
        ok("  Email    : {$adminEmail}");
        ok("  Password : {$adminPassword}");
        ok("  Rol      : {$adminRole}");
        ok("  Estado   : {$adminStatus}");
    }

    // ── Resumen final ──────────────────────────────────────────────────────
    titulo('Seeder completado con éxito');
    if (!$isCli) {
        echo '<p><a href="../public/index.php?route=auth.login">
              → Ir al login</a></p>';
    }

} catch (PDOException $e) {
    fail('Error de base de datos: ' . $e->getMessage());
    exit(1);
} catch (Throwable $e) {
    fail('Error inesperado: ' . $e->getMessage());
    exit(1);
}

if (!$isCli) {
    echo '</body></html>';
}
