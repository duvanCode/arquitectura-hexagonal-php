# Arquitectura Hexagonal PHP

Aplicación web CRUD construida en **PHP 8.2 puro** (sin frameworks) siguiendo los principios de la **Arquitectura Hexagonal** (Ports & Adapters). Gestiona usuarios y películas con autenticación, recuperación de contraseña y despliegue completamente dockerizado.

---

## Características principales

- **Arquitectura Hexagonal pura** — separación estricta entre Dominio, Aplicación e Infraestructura sin dependencia de frameworks externos.
- **PHP 8.2 sin frameworks** — autoloader propio, inyección de dependencias manual, router HTTP ligero.
- **Value Objects** — todos los campos del dominio están encapsulados en objetos tipados (`UserId`, `UserEmail`, `MovieTitle`, etc.) con validación en construcción.
- **Domain Events** — se disparan eventos de dominio al crear, actualizar o eliminar usuarios y películas.
- **CQRS básico** — separación de Commands y Queries en la capa de aplicación con DTOs dedicados.
- **Ports & Adapters** — los casos de uso definen interfaces (puertos); MySQL y SMTP son adaptadores intercambiables.
- **Autenticación con sesiones** — login/logout, recuperación de contraseña por correo (token con expiración).
- **Docker listo para producción** — imagen Alpine con PHP-FPM + Nginx + Supervisor, puerto dinámico.
- **Despliegue en Dokploy** — compatible con cualquier plataforma que soporte Docker Compose.

---

## Requisitos

| Herramienta | Versión mínima |
|-------------|----------------|
| Docker      | 24+            |
| Docker Compose | v2+         |
| (Opcional) PHP CLI local | 8.2+ |
| (Opcional) MySQL local   | 8.0+ |

---

## Estructura del proyecto

```
arquitectura-hexagonal-php/
├── Domain/                   # Núcleo del negocio (sin dependencias externas)
│   ├── Models/               # Entidades: UserModel, MovieModel
│   ├── ValueObjects/         # Tipos fuertemente tipados con validación
│   ├── Events/               # Eventos de dominio
│   ├── Exceptions/           # Excepciones de dominio
│   └── Enums/                # Enumeraciones (roles, géneros, clasificaciones)
│
├── Application/              # Casos de uso y orquestación
│   ├── Ports/
│   │   ├── In/               # Interfaces de entrada (use cases)
│   │   └── Out/              # Interfaces de salida (repositorios, mailer)
│   └── Services/             # Implementación de casos de uso + DTOs
│
├── Infrastructure/           # Adaptadores e implementaciones concretas
│   ├── Adapters/
│   │   ├── Persistence/MySQL/ # Repositorios MySQL (PDO)
│   │   └── Mail/              # Adaptador SMTP
│   └── Entrypoints/Web/      # Controladores, vistas PHP, router
│
├── Common/                   # Autoloader, DI Container, cargador de .env
├── database/                 # schema.sql + Seeder (usuario admin inicial)
├── docker/                   # Configuraciones de Nginx, PHP, Supervisor
├── public/                   # index.php (único punto de entrada)
├── Dockerfile
├── docker-compose.yml
└── .env.example
```

---

## Puesta en marcha con Docker (recomendado)

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd arquitectura-hexagonal-php
```

### 2. Configurar las variables de entorno

```bash
cp .env.example .env
```

Editar `.env` con los valores deseados:

```env
# Base de datos
DB_NAME=crud_usuarios
DB_ROOT_PASSWORD=tu_password_segura

# Puerto de la aplicación
APP_PORT=8080

# Activar seeder en el PRIMER arranque (crea tablas + usuario admin)
RUN_SEEDER=true

# Correo SMTP (opcional, para recuperación de contraseña)
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu@correo.com
MAIL_PASSWORD=tu_contrasena_de_aplicacion
MAIL_FROM=tu@correo.com
MAIL_FROM_NAME="Mi App"
MAIL_ENCRYPTION=tls
```

> **Importante:** `RUN_SEEDER=true` solo debe usarse en el primer despliegue. En los siguientes, volver a `false` para no recrear el usuario admin.

### 3. Construir y arrancar

```bash
docker compose up -d --build
```

### 4. Acceder a la aplicación

```
http://localhost:8080
```

### 5. Credenciales del admin inicial

| Campo    | Valor           |
|----------|-----------------|
| Email    | admin@admin.com |
| Password | Admin1234!      |

> Cambia la contraseña tras el primer inicio de sesión.

---

## Uso local (sin Docker)

Requiere PHP 8.2+ y MySQL 8.0+ instalados localmente (p. ej. con Laragon).

### 1. Crear la base de datos

```bash
mysql -u root -p < database/schema.sql
```

### 2. Configurar `.env`

```bash
cp .env.example .env
```

Ajustar `DB_HOST`, `DB_USER`, `DB_PASSWORD` para tu entorno local.

### 3. Ejecutar el Seeder

```bash
php database/Seeder.php
```

### 4. Servir con Laragon / Apache

Asegurarse de que el `DocumentRoot` apunte a la carpeta del proyecto. El `.htaccess` redirige todas las rutas a `public/index.php`.

Acceder a:
```
http://arquitectura-hexagonal-php.test
```

---

## Rutas disponibles

| Ruta | Método | Descripción |
|------|--------|-------------|
| `/` | GET | Página de inicio |
| `/users` | GET | Listado de usuarios |
| `/users/create` | GET | Formulario crear usuario |
| `/users/store` | POST | Guardar nuevo usuario |
| `/users/show?id=` | GET | Ver detalle de usuario |
| `/users/edit?id=` | GET | Formulario editar usuario |
| `/users/update` | POST | Actualizar usuario |
| `/users/delete` | POST | Eliminar usuario |
| `/movies` | GET | Listado de películas |
| `/movies/create` | GET | Formulario crear película |
| `/movies/store` | POST | Guardar nueva película |
| `/movies/show?id=` | GET | Ver detalle de película |
| `/movies/edit?id=` | GET | Formulario editar película |
| `/movies/update` | POST | Actualizar película |
| `/movies/delete` | POST | Eliminar película |
| `/login` | GET/POST | Iniciar sesión |
| `/logout` | GET | Cerrar sesión |
| `/forgot-password` | GET/POST | Solicitar recuperación de contraseña |
| `/reset-password` | GET/POST | Restablecer contraseña con token |

---

## Despliegue en Dokploy

1. Crear nueva aplicación → tipo **Docker Compose**.
2. Apuntar al repositorio Git.
3. Definir las variables de entorno en el panel de Dokploy (las mismas que en `.env.example`).
4. **Primer despliegue:** añadir `RUN_SEEDER=true` para crear las tablas y el usuario admin.
5. **Despliegues siguientes:** cambiar `RUN_SEEDER=false`.

---

## Comandos útiles

```bash
# Ver logs de la aplicación
docker compose logs -f app

# Ver logs de la base de datos
docker compose logs -f db

# Ejecutar el seeder manualmente
docker compose exec app php database/Seeder.php

# Detener los contenedores
docker compose down

# Detener y eliminar volúmenes (borra la BD)
docker compose down -v
```

---

## Stack tecnológico

| Componente | Tecnología |
|------------|------------|
| Lenguaje | PHP 8.2 |
| Base de datos | MySQL 8.0 |
| Servidor web | Nginx (Alpine) |
| Process manager | Supervisor |
| Contenedores | Docker + Docker Compose |
| Mailer | SMTP nativo (sin librerías) |
| Frontend | PHP Views + Bootstrap |
