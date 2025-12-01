# Sistema de Gestión de Eventos Escolares

Este proyecto es una plataforma web para gestionar la inscripción de estudiantes a eventos académicos y de innovación, como hackathons y concursos. Permite a los estudiantes formar equipos, unirse a ellos, y participar en eventos, mientras que los administradores y jurados gestionan el contenido y las evaluaciones.

## Requisitos del Sistema

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   Una base de datos (ej. MySQL, MariaDB)

## Guía de Instalación para Desarrolladores

Sigue estos pasos para configurar el entorno de desarrollo en tu máquina local.

### 1. Clonar el Repositorio

Primero, clona el repositorio desde GitHub a tu máquina local.

```bash
git clone https://URL_DEL_REPOSITORIO_DE_GITHUB.git
cd nombre-del-proyecto
```

### 2. Instalar Dependencias

Instala las dependencias de PHP (con Composer) y de JavaScript (con NPM).

```bash
# Instalar dependencias de PHP
composer install

# Instalar dependencias de JavaScript
npm install
```

### 3. Configuración del Entorno

Crea tu propio archivo de configuración de entorno y genera la clave de la aplicación.

```bash
# Copia el archivo de ejemplo (en Windows usa 'copy' en lugar de 'cp')
cp .env.example .env

# Genera una clave de aplicación única
php artisan key:generate
```

### 4. Configurar la Base de Datos

1.  Abre el archivo `.env` que acabas de crear.
2.  Modifica las siguientes variables para que coincidan con la configuración de tu base de datos local. Por ejemplo, para PostgreSQL:

    ```env
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=sistema_escolar_db
    DB_USERNAME=postgres
    DB_PASSWORD= colocar su contraseña de postgres
    ```

3.  Asegúrate de haber creado una base de datos con el nombre que especificaste (ej. `sistema_escolar`).

### 5. Ejecutar Migraciones y Seeders

Este comando creará todas las tablas de la base de datos y las llenará con datos de prueba esenciales (roles, usuarios de ejemplo, eventos, etc.).

```bash
php artisan migrate:fresh --seed
```

### 6. Crear el Enlace Simbólico de Almacenamiento

Esto es necesario para que las imágenes subidas (como las de los eventos y equipos) sean accesibles desde la web.

```bash
php artisan storage:link
```

### 7. Compilar los Assets

Compila los archivos CSS y JavaScript usando Vite.

```bash
# Ejecuta el servidor de desarrollo de Vite (se mantiene activo y recompila al detectar cambios)
npm run dev

# O compila los archivos para producción
npm run build
```

### 8. Iniciar el Servidor

Finalmente, inicia el servidor de desarrollo de Laravel.

```bash
php artisan serve
```

¡Y listo! Ahora puedes acceder a la aplicación en tu navegador, generalmente en `http://127.0.0.1:8000`.

---

**Usuarios de Prueba:**

Después de ejecutar los seeders, se crearán los siguientes usuarios para que puedas probar los diferentes roles:

-   **Administrador:**
    -   **Email:** `admin@example.com`
    -   **Contraseña:** `password`
-   **Jurado:**
    -   **Email:** `jurado@example.com`
    -   **Contraseña:** `password`
-   **Estudiante:**
    -   **Email:** `estudiante@example.com`
    -   **Contraseña:** `password`
