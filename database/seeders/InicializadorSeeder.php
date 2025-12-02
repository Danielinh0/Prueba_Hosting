<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Para generar strings aleatorios
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\Jurado;
use App\Models\CatCarrera;
use App\Models\Evento;
use App\Models\Equipo;
use App\Models\InscripcionEvento;
use App\Models\MiembroEquipo;
use App\Models\CatRolEquipo;

class InicializadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // 1. ROLES DEL SISTEMA (Vital para el Login)

        // Usamos insertOrIgnore para no duplicar si ya existen
        DB::table('cat_roles_sistema')->insertOrIgnore([
            ['id_rol_sistema' => 1, 'nombre' => 'admin'],
            ['id_rol_sistema' => 2, 'nombre' => 'jurado'],
            ['id_rol_sistema' => 3, 'nombre' => 'estudiante'],
        ]);


        // 2. CARRERAS (Oferta Educativa del ITO)

        $carreras = [
            'Ingeniería en Sistemas Computacionales',
            'Ingeniería Civil',
            'Ingeniería en Gestión Empresarial',
            'Ingeniería Industrial',
            'Ingeniería Electrónica',
            'Ingeniería Eléctrica',
            'Ingeniería Mecánica',
            'Ingeniería Química',
            'Licenciatura en Administración'
        ];

        foreach ($carreras as $carrera) {
            DB::table('cat_carreras')->insertOrIgnore([
                'nombre' => $carrera
            ]);
        }


        // 3. ROLES DE EQUIPO

        DB::table('cat_roles_equipo')->insertOrIgnore([
            ['nombre' => 'Líder', 'descripcion' => 'Encargado de gestionar el equipo y subir avances.'],
            ['nombre' => 'Programador Backend', 'descripcion' => 'Lógica del servidor y bases de datos.'],
            ['nombre' => 'Programador Frontend', 'descripcion' => 'Interfaces y experiencia de usuario.'],
            ['nombre' => 'Analista de Datos', 'descripcion' => 'Gestión de información y métricas.'],
            ['nombre' => 'Diseñador UX/UI', 'descripcion' => 'Prototipado y diseño visual.'],
        ]);


        //! TOKENS PARA JURADOS 
        //TODO Token FIJO para pruebas 
        DB::table('tokens_jurado')->insertOrIgnore([
            'token' => 'JURADO-HACKATEC-2025', // Contraseña maestra para registrar jurados
            'usado' => false,
            'fecha_expiracion' => now()->addMonths(6), 
            'email_invitado' => 'jurado_invitado@ito.mx'
        ]);

        //! GENERADOR DE 5 tokens aleatorios extra (Para simular invitaciones reales)
        for ($i = 0; $i < 5; $i++) {
            DB::table('tokens_jurado')->insert([
                'token' => Str::upper(Str::random(10)), // Genera algo como "A1B2C3D4E5"
                'usado' => false,
                'fecha_expiracion' => now()->addMonths(1),
                'email_invitado' => null
            ]);
        }

        // 5. USUARIO ADMINISTRADOR (Super Usuario)
        // Verificamos si existe para no dar error
        $adminEmail = 'admin@ito.mx';
        if (!DB::table('users')->where('email', $adminEmail)->exists()) {
            DB::table('users')->insert([
                'nombre' => 'Administrador',
                'app_paterno' => 'Principal',
                'app_materno' => 'Sistema',
                'email' => $adminEmail,
                'password' => Hash::make('admin123'), 
                'id_rol_sistema' => 1, // 1 = Admin
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 6. CREACIÓN DE ESTUDIANTES Y JURADOS DE PRUEBA
        DB::transaction(function () {
            $carreraIds = CatCarrera::pluck('id_carrera');

            // Estudiantes
            $estudiantes = [
                ['nombre' => 'Leonardo Satot', 'app_paterno' => 'Garcia', 'app_materno' => 'Pino', 'email' => 'leonardo@ito.mx'],
                ['nombre' => 'Diego Eduardo', 'app_paterno' => 'Quiroga', 'app_materno' => 'Gómez', 'email' => 'diego469quiroga@gmail.com'],
                ['nombre' => 'Joel', 'app_paterno' => 'Hernandez', 'app_materno' => 'Perez', 'email' => 'joel@ito.mx'],
                ['nombre' => 'Daniel', 'app_paterno' => 'Lopez', 'app_materno' => 'Martinez', 'email' => 'daniel@ito.mx'],
                ['nombre' => 'Gael', 'app_paterno' => 'Ruiz', 'app_materno' => 'Jimenez', 'email' => 'gael@ito.mx'],
                ['nombre' => 'Lorea Camila', 'app_paterno' => 'Quiroga', 'app_materno' => 'Gomez', 'email' => 'lorea@ito.mx'],
                ['nombre' => 'Carlos', 'app_paterno' => 'Dias', 'app_materno' => '', 'email' => 'carlos.dias@ito.mx'],
                ['nombre' => 'Leslie', 'app_paterno' => 'Arogon', 'app_materno' => '', 'email' => 'leslie.arogon@ito.mx'],
                ['nombre' => 'Alejandro', 'app_paterno' => 'Perez', 'app_materno' => 'Lopez', 'email' => 'alejandro.perez@ito.mx'],
                ['nombre' => 'Hector', 'app_paterno' => 'Sanchez', 'app_materno' => '', 'email' => 'hector.sanchez@ito.mx'],
                ['nombre' => 'Manuel', 'app_paterno' => 'Garcia', 'app_materno' => '', 'email' => 'manuel.garcia@ito.mx'],
                ['nombre' => 'Angel de Jesus', 'app_paterno' => 'Cruz', 'app_materno' => 'Cruz', 'email' => 'angel.cruz@ito.mx'],
                ['nombre' => 'Erick', 'app_paterno' => 'Garcia', 'app_materno' => 'Perez', 'email' => 'erick.garcia@ito.mx'],
                ['nombre' => 'Givanni Raymundo', 'app_paterno' => 'Olmedo', 'app_materno' => 'Carbajal', 'email' => 'givanni.olmedo@ito.mx'],
                ['nombre' => 'Juan', 'app_paterno' => 'Perez', 'app_materno' => 'Rodriguez', 'email' => 'juan.perez@ito.mx'],
            ];

            foreach ($estudiantes as $index => $estudianteData) {
                if (!User::where('email', $estudianteData['email'])->exists()) {
                    $user = User::create([
                        'nombre' => $estudianteData['nombre'],
                        'app_paterno' => $estudianteData['app_paterno'],
                        'app_materno' => $estudianteData['app_materno'],
                        'email' => $estudianteData['email'],
                        'password' => Hash::make('password'),
                        'id_rol_sistema' => 3, 
                        'activo' => true,
                    ]);

                    Estudiante::create([
                        'id_usuario' => $user->id_usuario,
                        'numero_control' => '2016' . str_pad((string)($index + 1), 4, '0', STR_PAD_LEFT),
                        'semestre' => rand(3, 9),
                        'id_carrera' => $carreraIds->random(),
                    ]);
                }
            }

            // Jurados
            $jurados = [
                ['nombre' => 'Otilia', 'app_paterno' => 'Perez', 'app_materno' => 'Lopez', 'email' => 'otilia@jurado.mx'],
                ['nombre' => 'Adelina', 'app_paterno' => 'Martinez', 'app_materno' => 'Nieto', 'email' => 'adelina@jurado.mx'],
                ['nombre' => 'Idarh Claudio', 'app_paterno' => 'Matadamas', 'app_materno' => 'Ortiz', 'email' => 'idarh@jurado.mx'],
                ['nombre' => 'Luis Alberto', 'app_paterno' => 'Alonso', 'app_materno' => 'Hernandez', 'email' => 'luis@jurado.mx'],
            ];

            foreach ($jurados as $juradoData) {
                if (!User::where('email', $juradoData['email'])->exists()) {
                    $user = User::create([
                        'nombre' => $juradoData['nombre'],
                        'app_paterno' => $juradoData['app_paterno'],
                        'app_materno' => $juradoData['app_materno'],
                        'email' => $juradoData['email'],
                        'password' => Hash::make('password'),
                        'id_rol_sistema' => 2, // Rol Jurado
                        'activo' => true,
                    ]);

                    Jurado::create([
                        'id_usuario' => $user->id_usuario,
                        'especialidad' => 'Experto en Desarrollo de Software',
                        'empresa_institucion' => 'Empresa Tecnológica',
                    ]);
                }
            }
        });

        // 7. CREACIÓN DE EVENTOS, EQUIPOS E INSCRIPCIONES DE PRUEBA
        DB::transaction(function () {
            // --- Crear Eventos ---
            $eventoActivo = Evento::updateOrCreate(
                ['nombre' => 'Hackathon de Innovación 2025'],
                [
                    'descripcion' => 'El evento de programación más grande del año. Demuestra tus habilidades.',
                    'fecha_inicio' => now()->subDays(2),
                    'fecha_fin' => now()->addDays(15),
                    'cupo_max_equipos' => 20,
                    'estado' => 'Activo',
                    'tipo_proyecto' => 'individual'
                ]
            );
        
            Evento::updateOrCreate(
                ['nombre' => 'Feria de Proyectos TI 2026'],
                [
                    'descripcion' => 'Presenta tus proyectos de fin de semestre ante la comunidad tecnológica.',
                    'fecha_inicio' => now()->addMonths(3),
                    'fecha_fin' => now()->addMonths(3)->addDays(2),
                    'cupo_max_equipos' => 50,
                    'estado' => 'Próximo',
                    'tipo_proyecto' => 'general'
                ]
            );
        
            // --- Obtener Estudiantes y Roles ---
            $estudiantes = Estudiante::all();
            $rolesEquipo = CatRolEquipo::all();

            // --- Equipo 1: Quantum Coders ---
            $equipo1 = Equipo::updateOrCreate(['nombre' => 'Quantum Coders']);
            $inscripcion1 = InscripcionEvento::updateOrCreate(
                ['id_equipo' => $equipo1->id_equipo, 'id_evento' => $eventoActivo->id_evento],
                ['codigo_acceso_equipo' => Str::upper(Str::random(6)), 'status_registro' => 'Completo']
            );
            if ($estudiantes->count() >= 5) {
                foreach ($estudiantes->take(5) as $index => $estudiante) {
                    MiembroEquipo::firstOrCreate(
                        ['id_inscripcion' => $inscripcion1->id_inscripcion, 'id_estudiante' => $estudiante->id_usuario],
                        ['es_lider' => ($index === 0), 'id_rol_equipo' => $rolesEquipo->get($index % $rolesEquipo->count())->id_rol_equipo]
                    );
                }
            }

            // --- Equipo 2: Team Alpha ---
            $equipo2 = Equipo::updateOrCreate(['nombre' => 'Team Alpha']);
            $inscripcion2 = InscripcionEvento::updateOrCreate(
                ['id_equipo' => $equipo2->id_equipo, 'id_evento' => $eventoActivo->id_evento],
                ['codigo_acceso_equipo' => Str::upper(Str::random(6)), 'status_registro' => 'Completo']
            );
            if ($estudiantes->count() >= 10) {
                foreach ($estudiantes->slice(5, 5) as $index => $estudiante) {
                    MiembroEquipo::firstOrCreate(
                        ['id_inscripcion' => $inscripcion2->id_inscripcion, 'id_estudiante' => $estudiante->id_usuario],
                        ['es_lider' => ($index === 0), 'id_rol_equipo' => $rolesEquipo->get($index % $rolesEquipo->count())->id_rol_equipo]
                    );
                }
            }

            // --- Equipo 3: Team Beta ---
            $equipo3 = Equipo::updateOrCreate(['nombre' => 'Team Beta']);
            $inscripcion3 = InscripcionEvento::updateOrCreate(
                ['id_equipo' => $equipo3->id_equipo, 'id_evento' => $eventoActivo->id_evento],
                ['codigo_acceso_equipo' => Str::upper(Str::random(6)), 'status_registro' => 'Completo']
            );
            if ($estudiantes->count() >= 15) {
                foreach ($estudiantes->slice(10, 5) as $index => $estudiante) {
                    MiembroEquipo::firstOrCreate(
                        ['id_inscripcion' => $inscripcion3->id_inscripcion, 'id_estudiante' => $estudiante->id_usuario],
                        ['es_lider' => ($index === 0), 'id_rol_equipo' => $rolesEquipo->get($index % $rolesEquipo->count())->id_rol_equipo]
                    );
                }
            }
        });
    }
}