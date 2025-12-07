# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Commands

### Project Setup

```bash
# Full project setup (installs dependencies, migrates, builds assets)
composer run setup

# Manual setup
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
npm install
npm run build
```

### Development

```bash
# Start development server with all services
composer run dev

# Individual services
php artisan serve                    # Laravel server
php artisan queue:listen            # Queue worker
php artisan pail --timeout=0        # Real-time logs
npm run dev                         # Vite dev server

# Tests
composer run test
php artisan test                    # Run Pest tests
```

### Production

```bash
npm run build                      # Build assets for production
php artisan migrate --force        # Run migrations in production
php artisan config:cache          # Cache configuration
php artisan route:cache           # Cache routes
```

## Architecture Overview

### Role-Based Access Control

The system uses a custom Role-based access control with these roles:

-   **Admin**: Full system access
-   **Jurado**: Event evaluation permissions
-   **Estudiante**: Participant role

Roles are managed through `CatRolSistema` model and enforced via `RoleMiddleware`.

### Core Models Relationships

-   **User**: Base authentication model, has relationships to Estudiante, Jurado, or Admin roles
-   **Evento**: Central entity, has many InscripcionEvento and CriterioEvaluacion
-   **Equipo**: Group of students, has MiembroEquipo relationships
-   **Proyecto**: Belongs to Equipo, has Avance and Evaluacion relationships
-   **Evaluacion**: Created by Jurado for an InscripcionEvento, contains multiple EvaluacionCriterio
-   **EvaluacionAvance**: Created by Jurado for Avance submissions

### Key Controllers Structure

-   `App\Http\Controllers\Admin\*`: Administrative functions (users, events, teams)
-   `App\Http\Controllers\Estudiante\*`: Student dashboard, projects, teams, activities
-   `App\Http\Controllers\Jurado\*`: Jury dashboard, project evaluation, events

### Events & Observers

The system uses Eloquent Observers for automated reactions:

-   `EquipoObserver`: Handles team-related events
-   `MiembroEquipoObserver`: Manages team member operations

### Queue System

Uses database queue driver (QUEUE_CONNECTION=database) for background processing.

## Database Configuration

### Migration Strategy

-   Uses PostgreSQL (DB_CONNECTION=pgsql)
-   Uses seeders for initial data (roles, test users, events)
-   `php artisan migrate:fresh --seed` for fresh installation

### Test Users

After seeding:

-   Admin: admin@example.com / password
-   Jurado: jurado@example.com / password
-   Estudiante: estudiante@example.com / password

## Frontend Assets

### Vite Configuration

-   Uses Vite for asset compilation
-   Tailwind CSS for styling
-   Alpine.js for interactive components
-   Laravel Vite plugin integration

### Asset Commands

-   `npm run dev`: Development with hot reload
-   `npm run build`: Production build

## PDF Generation

Uses `barryvdh/laravel-dompdf` for PDF generation (certificates, constancias).

## Email Configuration

Currently uses log driver (MAIL_MAILER=log). Configure SMTP in .env for production.

## Key Directory Structure

```
app/
├── Http/Controllers/
│   ├── Admin/
│   ├── Estudiante/
│   └── Jurado/
├── Models/
├── Observers/
└── Services/
```

## Testing

Uses Pest PHP testing framework with Laravel plugin. Tests are in the `tests/` directory.
