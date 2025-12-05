<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

        // 3. ROLES DE EQUIPO (Globales)
        DB::table('cat_roles_equipo')->insertOrIgnore([
            ['nombre' => 'Líder', 'descripcion' => 'Encargado de gestionar el equipo y subir avances.'],
            ['nombre' => 'Programador Backend', 'descripcion' => 'Lógica del servidor y bases de datos.'],
            ['nombre' => 'Programador Frontend', 'descripcion' => 'Interfaces y experiencia de usuario.'],
            ['nombre' => 'Analista de Datos', 'descripcion' => 'Gestión de información y métricas.'],
            ['nombre' => 'Diseñador UX/UI', 'descripcion' => 'Prototipado y diseño visual.'],
        ]);

        // TOKENS PARA JURADOS 
        DB::table('tokens_jurado')->insertOrIgnore([
            'token' => 'JURADO-HACKATEC-2025',
            'usado' => false,
            'fecha_expiracion' => now()->addMonths(6), 
            'email_invitado' => 'jurado_invitado@ito.mx'
        ]);

        for ($i = 0; $i < 5; $i++) {
            DB::table('tokens_jurado')->insert([
                'token' => Str::upper(Str::random(10)),
                'usado' => false,
                'fecha_expiracion' => now()->addMonths(1),
                'email_invitado' => null
            ]);
        }

        // 5. USUARIO ADMINISTRADOR
        $adminEmail = 'admin@ito.mx';
        if (!DB::table('users')->where('email', $adminEmail)->exists()) {
            DB::table('users')->insert([
                'nombre' => 'Administrador',
                'app_paterno' => 'Principal',
                'app_materno' => 'Sistema',
                'email' => $adminEmail,
                'password' => Hash::make('admin123'), 
                'id_rol_sistema' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 6. CREACIÓN DE ESTUDIANTES Y JURADOS
        DB::transaction(function () {
            $carreraIds = CatCarrera::pluck('id_carrera');

            // Estudiantes originales (serán líderes)
            $estudiantesOriginales = [
                ['nombre' => 'Leonardo Satot', 'app_paterno' => 'Garcia', 'app_materno' => 'Pino', 'email' => 'leonardo@ito.mx'],
                ['nombre' => 'Diego Eduardo', 'app_paterno' => 'Quiroga', 'app_materno' => 'Gómez', 'email' => 'diego469quiroga@gmail.com'],
                ['nombre' => 'Joel', 'app_paterno' => 'Hernandez', 'app_materno' => 'Perez', 'email' => 'joel@ito.mx'],
                ['nombre' => 'Daniel', 'app_paterno' => 'Lopez', 'app_materno' => 'Martinez', 'email' => 'daniel@ito.mx'],
                ['nombre' => 'Gael', 'app_paterno' => 'Ruiz', 'app_materno' => 'Jimenez', 'email' => 'gael@ito.mx'],
                ['nombre' => 'Lorea Camila', 'app_paterno' => 'Quiroga', 'app_materno' => 'Gomez', 'email' => 'lorea@ito.mx'],
                ['nombre' => 'Carlos', 'app_paterno' => 'Dias', 'app_materno' => '', 'email' => 'carlos.dias@ito.mx'],
                ['nombre' => 'Leslie', 'app_paterno' => 'Arogon', 'app_materno' => '', 'email' => 'leslie.arogon@ito.mx'],
            ];

            // Nuevos estudiantes solicitados (ampliado para completar equipos de 5)
            $estudiantesNuevos = [
                ['nombre' => 'Carlos David', 'app_paterno' => 'Martinez', 'app_materno' => 'Lopez'],
                ['nombre' => 'Raul', 'app_paterno' => 'Chacon', 'app_materno' => 'Melchor'],
                ['nombre' => 'Elvira Yamile', 'app_paterno' => 'Crisantos', 'app_materno' => 'Teran'],
                ['nombre' => 'Kelly Adanari', 'app_paterno' => 'Cruz', 'app_materno' => 'Alonso'],
                ['nombre' => 'Hector Fernando', 'app_paterno' => 'Cruz', 'app_materno' => 'Ruiz'],
                ['nombre' => 'Andrea Joselin', 'app_paterno' => 'Cruz', 'app_materno' => 'Martinez'],
                ['nombre' => 'Carlos Adiel', 'app_paterno' => 'Cruz', 'app_materno' => 'Castro'],
                ['nombre' => 'Karla Rocío', 'app_paterno' => 'Delgado', 'app_materno' => 'Molina'],
                ['nombre' => 'Zaid', 'app_paterno' => 'Diaz', 'app_materno' => 'Cristobal'],
                ['nombre' => 'Uriel', 'app_paterno' => 'Díaz', 'app_materno' => 'Zarate'],
                ['nombre' => 'Carlos', 'app_paterno' => 'Diaz', 'app_materno' => 'Vasquez'],
                ['nombre' => 'Jennifer', 'app_paterno' => 'Diego', 'app_materno' => 'Garcia'],
                ['nombre' => 'Joaquin Baruc', 'app_paterno' => 'Elorza', 'app_materno' => 'Perez'],
                ['nombre' => 'Luis Gael', 'app_paterno' => 'Ernandez', 'app_materno' => 'Crisanto'],
                ['nombre' => 'Wilver Alfredo', 'app_paterno' => 'Flores', 'app_materno' => 'Santiago'],
                ['nombre' => 'Uziel', 'app_paterno' => 'Franco', 'app_materno' => 'Matias'],
                ['nombre' => 'Leonardo', 'app_paterno' => 'Fuentes', 'app_materno' => 'Lopez'],
                ['nombre' => 'Alexis', 'app_paterno' => 'Gabriel', 'app_materno' => 'Zarate'],
                ['nombre' => 'Daniel Eduardo', 'app_paterno' => 'Garcia', 'app_materno' => 'Salvador'],
                ['nombre' => 'Eric', 'app_paterno' => 'Garcia', 'app_materno' => 'Gallegos'],
                ['nombre' => 'Leonardo Sadot', 'app_paterno' => 'Garcia', 'app_materno' => 'Pino'],
                ['nombre' => 'Yael Trinidad', 'app_paterno' => 'Merino', 'app_materno' => 'Cruz'],
                ['nombre' => 'Angel Adrian', 'app_paterno' => 'Zarate', 'app_materno' => 'Matus'],
                ['nombre' => 'Alejandro', 'app_paterno' => 'Villegas', 'app_materno' => 'Velazquez'],
                ['nombre' => 'Candy Heidy', 'app_paterno' => 'Velasco', 'app_materno' => 'Martinez'],
                ['nombre' => 'Sebastian', 'app_paterno' => 'Vasquez', 'app_materno' => 'Sanchez'],
                ['nombre' => 'Bernardo Adonai', 'app_paterno' => 'Vasquez', 'app_materno' => 'Hernandez'],
                ['nombre' => 'Roberto Carlos', 'app_paterno' => 'Vasquez', 'app_materno' => 'Aragon'],
                ['nombre' => 'Gloria Esmeralda', 'app_paterno' => 'Vasquez', 'app_materno' => 'Porras'],
                ['nombre' => 'Alexander Jassiel', 'app_paterno' => 'Torres', 'app_materno' => 'Cortés'],
                ['nombre' => 'Joel', 'app_paterno' => 'Tellez', 'app_materno' => 'Hernandez'],
                // Estudiantes adicionales para completar equipos de 5
                ['nombre' => 'Miguel Angel', 'app_paterno' => 'Reyes', 'app_materno' => 'Luna'],
                ['nombre' => 'Sofia Isabel', 'app_paterno' => 'Moreno', 'app_materno' => 'Ruiz'],
                ['nombre' => 'Fernando', 'app_paterno' => 'Sanchez', 'app_materno' => 'Ortiz'],
                ['nombre' => 'Valentina', 'app_paterno' => 'Castro', 'app_materno' => 'Mendez'],
                ['nombre' => 'Ricardo', 'app_paterno' => 'Jimenez', 'app_materno' => 'Vargas'],
                ['nombre' => 'Camila', 'app_paterno' => 'Ramirez', 'app_materno' => 'Flores'],
                ['nombre' => 'Eduardo', 'app_paterno' => 'Hernandez', 'app_materno' => 'Torres'],
                ['nombre' => 'Mariana', 'app_paterno' => 'Lopez', 'app_materno' => 'Guzman'],
                ['nombre' => 'David', 'app_paterno' => 'Gonzalez', 'app_materno' => 'Rios'],
                ['nombre' => 'Isabella', 'app_paterno' => 'Martinez', 'app_materno' => 'Soto'],
                ['nombre' => 'Pablo', 'app_paterno' => 'Rodriguez', 'app_materno' => 'Aguilar'],
                ['nombre' => 'Daniela', 'app_paterno' => 'Perez', 'app_materno' => 'Navarro'],
                ['nombre' => 'Hugo', 'app_paterno' => 'Santos', 'app_materno' => 'Medina'],
                ['nombre' => 'Andrea', 'app_paterno' => 'Romero', 'app_materno' => 'Vega'],
                ['nombre' => 'Oscar', 'app_paterno' => 'Gutierrez', 'app_materno' => 'Corona'],
                ['nombre' => 'Lucia', 'app_paterno' => 'Mendoza', 'app_materno' => 'Espinoza'],
                ['nombre' => 'Emmanuel', 'app_paterno' => 'Ortega', 'app_materno' => 'Campos'],
                ['nombre' => 'Regina', 'app_paterno' => 'Vargas', 'app_materno' => 'Ramos'],
                ['nombre' => 'Jorge', 'app_paterno' => 'Ibarra', 'app_materno' => 'Montes'],
                ['nombre' => 'Ximena', 'app_paterno' => 'Avila', 'app_materno' => 'Duran'],
                ['nombre' => 'Ivan', 'app_paterno' => 'Rojas', 'app_materno' => 'Estrada'],
                ['nombre' => 'Ana Paula', 'app_paterno' => 'Solis', 'app_materno' => 'Zamora'],
                ['nombre' => 'Sergio', 'app_paterno' => 'Nunez', 'app_materno' => 'Contreras'],
                ['nombre' => 'Valeria', 'app_paterno' => 'Cortes', 'app_materno' => 'Herrera'],
                ['nombre' => 'Adrian', 'app_paterno' => 'Morales', 'app_materno' => 'Bautista'],
                ['nombre' => 'Renata', 'app_paterno' => 'Campos', 'app_materno' => 'Olvera'],
                ['nombre' => 'Luis Fernando', 'app_paterno' => 'Aguilar', 'app_materno' => 'Pacheco'],
                ['nombre' => 'Maria Jose', 'app_paterno' => 'Dominguez', 'app_materno' => 'Lara'],
                ['nombre' => 'Andres', 'app_paterno' => 'Navarro', 'app_materno' => 'Rangel'],
                ['nombre' => 'Fernanda', 'app_paterno' => 'Espinosa', 'app_materno' => 'Trejo'],
            ];

            // Crear estudiantes originales
            foreach ($estudiantesOriginales as $index => $estudianteData) {
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
                        'semestre' => rand(5, 9),
                        'id_carrera' => $carreraIds->random(),
                    ]);
                }
            }

            // Crear estudiantes nuevos
            foreach ($estudiantesNuevos as $index => $estudianteData) {
                $nombreSlug = Str::slug($estudianteData['nombre'], '.');
                $apellidoSlug = $estudianteData['app_paterno'] ? Str::slug($estudianteData['app_paterno'], '.') : 'estudiante';
                $email = strtolower($nombreSlug . '.' . $apellidoSlug) . '@ito.mx';
                
                // Asegurar email único
                $emailBase = $email;
                $counter = 1;
                while (User::where('email', $email)->exists()) {
                    $email = str_replace('@ito.mx', $counter . '@ito.mx', $emailBase);
                    $counter++;
                }
                
                $user = User::create([
                    'nombre' => $estudianteData['nombre'],
                    'app_paterno' => $estudianteData['app_paterno'],
                    'app_materno' => $estudianteData['app_materno'],
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'id_rol_sistema' => 3, 
                    'activo' => true,
                ]);

                Estudiante::create([
                    'id_usuario' => $user->id_usuario,
                    'numero_control' => '2020' . str_pad((string)($index + 1), 4, '0', STR_PAD_LEFT),
                    'semestre' => rand(3, 7),
                    'id_carrera' => $carreraIds->random(),
                ]);
            }

            // Jurados
            $jurados = [
                ['nombre' => 'Otilia', 'app_paterno' => 'Perez', 'app_materno' => 'Lopez', 'email' => 'otilia@jurado.mx'],
                ['nombre' => 'Adelina', 'app_paterno' => 'Martinez', 'app_materno' => 'Nieto', 'email' => 'adelina@jurado.mx'],
                ['nombre' => 'Idarh Claudio', 'app_paterno' => 'Matadamas', 'app_materno' => 'Ortiz', 'email' => 'idarh@jurado.mx'],
                ['nombre' => 'Luis Alberto', 'app_paterno' => 'Alonso', 'app_materno' => 'Hernandez', 'email' => 'luis@jurado.mx'],
                ['nombre' => 'Reyna', 'app_paterno' => 'Valverde', 'app_materno' => '', 'email' => 'reyna.valverde@jurado.mx'],
                ['nombre' => 'Bibiana', 'app_paterno' => 'Diaz', 'app_materno' => 'Sarmiento', 'email' => 'bibiana.diaz@jurado.mx'],
                ['nombre' => 'Marisol', 'app_paterno' => 'Altamirano', 'app_materno' => 'Cabrera', 'email' => 'marisol.altamirano@jurado.mx'],
                ['nombre' => 'Maricarmen Monserray', 'app_paterno' => 'Hernandez', 'app_materno' => 'Velazquez', 'email' => 'maricarmen.hernandez@jurado.mx'],
                ['nombre' => 'Maricela', 'app_paterno' => 'Morales', 'app_materno' => 'Hernandez', 'email' => 'maricela.morales@jurado.mx'],
                ['nombre' => 'Dalia', 'app_paterno' => 'Silva', 'app_materno' => 'Martinez', 'email' => 'dalia.silva@jurado.mx'],
                ['nombre' => 'Bernardo Roberto', 'app_paterno' => 'Cruz', 'app_materno' => 'Hernandez', 'email' => 'bernardo.cruz@jurado.mx'],
            ];

            foreach ($jurados as $juradoData) {
                if (!User::where('email', $juradoData['email'])->exists()) {
                    $user = User::create([
                        'nombre' => $juradoData['nombre'],
                        'app_paterno' => $juradoData['app_paterno'],
                        'app_materno' => $juradoData['app_materno'],
                        'email' => $juradoData['email'],
                        'password' => Hash::make('password'),
                        'id_rol_sistema' => 2,
                        'activo' => true,
                    ]);

                    Jurado::create([
                        'id_usuario' => $user->id_usuario,
                        'especialidad' => 'Experto en Desarrollo de Software',
                        'empresa_institucion' => 'Instituto Tecnológico de Oaxaca',
                    ]);
                }
            }
        });

        // 7. CREACIÓN DE EVENTOS Y EQUIPOS
        DB::transaction(function () {
            $rolesEquipo = CatRolEquipo::all();
            $todosEstudiantes = Estudiante::with('user')->get();
            
            // Estudiantes originales serán líderes (los primeros 8)
            $estudiantesOriginalesEmails = [
                'leonardo@ito.mx',
                'diego469quiroga@gmail.com', 
                'joel@ito.mx',
                'daniel@ito.mx',
                'gael@ito.mx',
                'lorea@ito.mx',
                'carlos.dias@ito.mx',
                'leslie.arogon@ito.mx',
            ];

            // ===== EVENTO 1: Hackathon de Innovación 2025 (Activo) =====
            $evento1 = Evento::updateOrCreate(
                ['nombre' => 'Hackathon de Innovación 2025'],
                [
                    'descripcion' => 'El evento de programación más grande del año. Demuestra tus habilidades creando soluciones innovadoras.',
                    'fecha_inicio' => now()->subDays(2),
                    'fecha_fin' => now()->addDays(15),
                    'cupo_max_equipos' => 20,
                    'estado' => 'Activo',
                ]
            );

            // Criterios de evaluación para Evento 1
            DB::table('criterios_evaluacion')->insertOrIgnore([
                ['id_evento' => $evento1->id_evento, 'nombre' => 'Innovación', 'descripcion' => 'Originalidad y creatividad de la solución', 'ponderacion' => 25],
                ['id_evento' => $evento1->id_evento, 'nombre' => 'Funcionalidad', 'descripcion' => 'El proyecto funciona correctamente', 'ponderacion' => 25],
                ['id_evento' => $evento1->id_evento, 'nombre' => 'Diseño UI/UX', 'descripcion' => 'Experiencia de usuario y diseño visual', 'ponderacion' => 20],
                ['id_evento' => $evento1->id_evento, 'nombre' => 'Presentación', 'descripcion' => 'Claridad y calidad de la presentación', 'ponderacion' => 15],
                ['id_evento' => $evento1->id_evento, 'nombre' => 'Código Limpio', 'descripcion' => 'Calidad y organización del código', 'ponderacion' => 15],
            ]);

            // ===== EVENTO 2: Feria de Proyectos TI 2025 =====
            $evento2 = Evento::updateOrCreate(
                ['nombre' => 'Feria de Proyectos TI 2025'],
                [
                    'descripcion' => 'Presenta tus proyectos de fin de semestre ante la comunidad tecnológica y empresas del sector.',
                    'fecha_inicio' => now()->addDays(30),
                    'fecha_fin' => now()->addDays(32),
                    'cupo_max_equipos' => 30,
                    'estado' => 'Próximo',
                ]
            );

            DB::table('criterios_evaluacion')->insertOrIgnore([
                ['id_evento' => $evento2->id_evento, 'nombre' => 'Impacto Social', 'descripcion' => 'Beneficio para la comunidad', 'ponderacion' => 30],
                ['id_evento' => $evento2->id_evento, 'nombre' => 'Viabilidad Técnica', 'descripcion' => 'Factibilidad de implementación', 'ponderacion' => 25],
                ['id_evento' => $evento2->id_evento, 'nombre' => 'Documentación', 'descripcion' => 'Calidad de la documentación técnica', 'ponderacion' => 20],
                ['id_evento' => $evento2->id_evento, 'nombre' => 'Demostración', 'descripcion' => 'Efectividad de la demostración en vivo', 'ponderacion' => 25],
            ]);

            // ===== EVENTO 3: Concurso de Apps Móviles =====
            $evento3 = Evento::updateOrCreate(
                ['nombre' => 'Concurso de Apps Móviles'],
                [
                    'descripcion' => 'Desarrolla una aplicación móvil innovadora que resuelva problemas de la comunidad.',
                    'fecha_inicio' => now()->addDays(45),
                    'fecha_fin' => now()->addDays(60),
                    'cupo_max_equipos' => 15,
                    'estado' => 'Próximo',
                ]
            );

            DB::table('criterios_evaluacion')->insertOrIgnore([
                ['id_evento' => $evento3->id_evento, 'nombre' => 'Usabilidad', 'descripcion' => 'Facilidad de uso de la aplicación', 'ponderacion' => 30],
                ['id_evento' => $evento3->id_evento, 'nombre' => 'Rendimiento', 'descripcion' => 'Velocidad y optimización', 'ponderacion' => 25],
                ['id_evento' => $evento3->id_evento, 'nombre' => 'Diseño Mobile', 'descripcion' => 'Adaptación a estándares móviles', 'ponderacion' => 25],
                ['id_evento' => $evento3->id_evento, 'nombre' => 'Innovación', 'descripcion' => 'Creatividad en la solución', 'ponderacion' => 20],
            ]);

            // ===== EVENTO 4: Maratón de Programación =====
            $evento4 = Evento::updateOrCreate(
                ['nombre' => 'Maratón de Programación ITO'],
                [
                    'descripcion' => '24 horas de programación intensiva. Resuelve retos algorítmicos y gana increíbles premios.',
                    'fecha_inicio' => now()->addDays(60),
                    'fecha_fin' => now()->addDays(61),
                    'cupo_max_equipos' => 25,
                    'estado' => 'Próximo',
                ]
            );

            DB::table('criterios_evaluacion')->insertOrIgnore([
                ['id_evento' => $evento4->id_evento, 'nombre' => 'Problemas Resueltos', 'descripcion' => 'Cantidad de problemas solucionados', 'ponderacion' => 40],
                ['id_evento' => $evento4->id_evento, 'nombre' => 'Eficiencia', 'descripcion' => 'Complejidad algorítmica de soluciones', 'ponderacion' => 35],
                ['id_evento' => $evento4->id_evento, 'nombre' => 'Tiempo', 'descripcion' => 'Velocidad de resolución', 'ponderacion' => 25],
            ]);

            // ===== EVENTO 5: Expo Tecnología Sustentable =====
            $evento5 = Evento::updateOrCreate(
                ['nombre' => 'Expo Tecnología Sustentable'],
                [
                    'descripcion' => 'Crea soluciones tecnológicas que contribuyan al desarrollo sustentable y medio ambiente.',
                    'fecha_inicio' => now()->addDays(90),
                    'fecha_fin' => now()->addDays(92),
                    'cupo_max_equipos' => 20,
                    'estado' => 'Próximo',
                ]
            );

            DB::table('criterios_evaluacion')->insertOrIgnore([
                ['id_evento' => $evento5->id_evento, 'nombre' => 'Impacto Ambiental', 'descripcion' => 'Contribución al medio ambiente', 'ponderacion' => 35],
                ['id_evento' => $evento5->id_evento, 'nombre' => 'Sustentabilidad', 'descripcion' => 'Viabilidad a largo plazo', 'ponderacion' => 25],
                ['id_evento' => $evento5->id_evento, 'nombre' => 'Tecnología Verde', 'descripcion' => 'Uso de tecnologías ecológicas', 'ponderacion' => 20],
                ['id_evento' => $evento5->id_evento, 'nombre' => 'Escalabilidad', 'descripcion' => 'Potencial de crecimiento', 'ponderacion' => 20],
            ]);

            // Obtener estudiantes que NO son los líderes originales (para asignar como miembros)
            $estudiantesNuevos = $todosEstudiantes->filter(function($est) use ($estudiantesOriginalesEmails) {
                return !in_array($est->user->email, $estudiantesOriginalesEmails);
            })->values();

            $miembroIndex = 0;
            $equipoNumero = 0;

            // Configuración: 14 equipos total (7 completos, 7 incompletos)
            // Equipos completos: 4 miembros | Equipos incompletos: 3 miembros
            $configuracionEquipos = [
                // EQUIPOS COMPLETOS (7) - 4 miembros cada uno
                ['nombre' => 'Quantum Coders', 'lider_email' => 'leonardo@ito.mx', 'evento' => $evento1, 'completo' => true, 'miembros' => 3],
                ['nombre' => 'Team Alpha', 'lider_email' => 'diego469quiroga@gmail.com', 'evento' => $evento1, 'completo' => true, 'miembros' => 3],
                ['nombre' => 'Digital Wizards', 'lider_email' => 'joel@ito.mx', 'evento' => $evento1, 'completo' => true, 'miembros' => 3],
                ['nombre' => 'Code Breakers', 'lider_email' => 'daniel@ito.mx', 'evento' => $evento2, 'completo' => true, 'miembros' => 3],
                ['nombre' => 'Tech Innovators', 'lider_email' => 'gael@ito.mx', 'evento' => $evento2, 'completo' => true, 'miembros' => 3],
                ['nombre' => 'Future Devs', 'lider_email' => 'lorea@ito.mx', 'evento' => $evento3, 'completo' => true, 'miembros' => 2],
                ['nombre' => 'Binary Masters', 'lider_email' => 'carlos.dias@ito.mx', 'evento' => $evento3, 'completo' => true, 'miembros' => 2],
                
                // EQUIPOS INCOMPLETOS (7) - 3 miembros cada uno, buscando más
                ['nombre' => 'App Warriors', 'lider_email' => 'leslie.arogon@ito.mx', 'evento' => $evento1, 'completo' => false, 'miembros' => 2],
                ['nombre' => 'Mobile Pioneers', 'lider_email' => 'leonardo@ito.mx', 'evento' => $evento4, 'completo' => false, 'miembros' => 2],
                ['nombre' => 'Smart Solutions', 'lider_email' => 'diego469quiroga@gmail.com', 'evento' => $evento4, 'completo' => false, 'miembros' => 2],
                ['nombre' => 'Algorithm Kings', 'lider_email' => 'joel@ito.mx', 'evento' => $evento5, 'completo' => false, 'miembros' => 2],
                ['nombre' => 'Speed Coders', 'lider_email' => 'daniel@ito.mx', 'evento' => $evento5, 'completo' => false, 'miembros' => 2],
                ['nombre' => 'Green Tech', 'lider_email' => 'gael@ito.mx', 'evento' => $evento5, 'completo' => false, 'miembros' => 2],
                ['nombre' => 'Eco Developers', 'lider_email' => 'lorea@ito.mx', 'evento' => $evento4, 'completo' => false, 'miembros' => 2],
            ];

            foreach ($configuracionEquipos as $equipoConfig) {
                $evento = $equipoConfig['evento'];
                
                // Crear equipo
                $equipo = Equipo::updateOrCreate(['nombre' => $equipoConfig['nombre']]);
                
                // Crear inscripción con status según si está completo o no
                $inscripcion = InscripcionEvento::updateOrCreate(
                    ['id_equipo' => $equipo->id_equipo, 'id_evento' => $evento->id_evento],
                    [
                        'codigo_acceso_equipo' => Str::upper(Str::random(6)), 
                        'status_registro' => $equipoConfig['completo'] ? 'Completo' : 'Incompleto'
                    ]
                );

                // Buscar y asignar líder
                $liderUser = User::where('email', $equipoConfig['lider_email'])->first();
                if ($liderUser) {
                    $liderEstudiante = Estudiante::where('id_usuario', $liderUser->id_usuario)->first();
                    if ($liderEstudiante) {
                        MiembroEquipo::updateOrCreate(
                            ['id_inscripcion' => $inscripcion->id_inscripcion, 'id_estudiante' => $liderEstudiante->id_usuario],
                            ['es_lider' => true, 'id_rol_equipo' => $rolesEquipo->where('nombre', 'Líder')->first()->id_rol_equipo]
                        );
                    }
                }

                // Asignar miembros adicionales
                $miembrosAgregados = 0;
                $cantidadMiembros = $equipoConfig['miembros'];
                
                while ($miembrosAgregados < $cantidadMiembros && $miembroIndex < $estudiantesNuevos->count()) {
                    $estudiante = $estudiantesNuevos->get($miembroIndex);
                    $miembroIndex++;

                    // Verificar que no esté ya en este evento
                    $yaEnEvento = MiembroEquipo::whereHas('inscripcion', function($q) use ($evento) {
                        $q->where('id_evento', $evento->id_evento);
                    })->where('id_estudiante', $estudiante->id_usuario)->exists();

                    if (!$yaEnEvento) {
                        // Asignar rol rotativo (evitar Líder)
                        $rolesNoLider = $rolesEquipo->where('nombre', '!=', 'Líder')->values();
                        $rol = $rolesNoLider->get($miembrosAgregados % $rolesNoLider->count());
                        
                        MiembroEquipo::create([
                            'id_inscripcion' => $inscripcion->id_inscripcion,
                            'id_estudiante' => $estudiante->id_usuario,
                            'es_lider' => false,
                            'id_rol_equipo' => $rol->id_rol_equipo
                        ]);
                        $miembrosAgregados++;
                    }
                }
            }
        });
    }
}
