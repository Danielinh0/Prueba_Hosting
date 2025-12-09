<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventoController;
use App\Http\Controllers\Admin\JuradoAssignmentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EquipoController as AdminEquipoController;
use App\Http\Controllers\Admin\MiembroController as AdminMiembroController;
use App\Http\Controllers\Admin\ResultadosController;
use App\Http\Controllers\Jurado\DashboardController as JuradoDashboardController;
use App\Http\Controllers\Estudiante\DashboardController as EstudianteDashboardController;
use App\Http\Controllers\Estudiante\EventoController as EstudianteEventoController;
use App\Http\Controllers\Estudiante\EquipoController as EstudianteEquipoController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\Estudiante\MiEquipoController;
use App\Http\Controllers\Estudiante\MiembroController;
use App\Http\Controllers\Estudiante\SolicitudController;
use App\Http\Controllers\Estudiante\EquipoPreviewController;
use App\Http\Controllers\Estudiante\HabilidadController;

use App\Http\Controllers\Estudiante\RecursoController;
use App\Http\Controllers\Estudiante\TecnologiaController;
use App\Http\Controllers\Estudiante\ActividadController;
use App\Http\Controllers\Estudiante\StatsController;
use App\Http\Controllers\Estudiante\MisProyectosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Jurado\AcusesController;
use App\Http\Controllers\Jurado\EventosController;
use App\Http\Controllers\Admin\ReporteExcelController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardRedirectController::class)->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::patch('/profile/student', [ProfileController::class, 'updateStudentInfo'])->name('profile.student.update');
    Route::patch('/profile/jury', [ProfileController::class, 'updateJuryInfo'])->name('profile.jury.update');
    
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
    
    Route::post('/inscripciones/{inscripcion}/unirse', [InscripcionController::class, 'unirse'])->name('inscripciones.unirse');
    
    // Perfil público de usuario
    Route::get('/perfil/{user}', [App\Http\Controllers\PerfilController::class, 'show'])->name('perfil.show');
});

//? Rutas para Administradores
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
    
    //? Rutas para asignar jurados a un evento
    Route::get('eventos/{evento}/asignar', [JuradoAssignmentController::class, 'edit'])->name('eventos.asignar');
    Route::patch('eventos/{evento}/asignar', [JuradoAssignmentController::class, 'update'])->name('eventos.actualizar_asignacion');

    //? Rutas para cambiar el estado del evento
    Route::patch('eventos/{evento}/activar', [EventoController::class, 'activar'])->name('eventos.activar');
    Route::patch('eventos/{evento}/desactivar', [EventoController::class, 'desactivar'])->name('eventos.desactivar');
   
    Route::patch('eventos/{evento}/cerrar', [EventoController::class, 'cerrar'])->name('eventos.cerrar');
    Route::patch('eventos/{evento}/finalizar', [EventoController::class, 'finalizar'])->name('eventos.finalizar');
    Route::patch('eventos/{evento}/reactivar', [EventoController::class, 'reactivar'])->name('eventos.reactivar');

    //? Rutas para resultados y ganadores
    Route::get('eventos/{evento}/resultados', [ResultadosController::class, 'show'])->name('eventos.resultados');
    Route::post('eventos/{evento}/resultados/asignar', [ResultadosController::class, 'asignarPuesto'])->name('eventos.resultados.asignar-puesto');
    Route::delete('eventos/{evento}/resultados/quitar', [ResultadosController::class, 'quitarPuesto'])->name('eventos.resultados.quitar-puesto');

    //? Rutas para proyectos del evento
    Route::post('eventos/{evento}/configurar-tipo-proyecto', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'configurarTipo'])->name('eventos.configurar-proyectos');
    Route::get('eventos/{evento}/proyecto/create', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'create'])->name('proyectos-evento.create');
    Route::post('eventos/{evento}/proyecto', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'store'])->name('proyectos-evento.store');
    Route::get('proyectos-evento/{proyectoEvento}/edit', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'edit'])->name('proyectos-evento.edit');
    Route::patch('proyectos-evento/{proyectoEvento}', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'update'])->name('proyectos-evento.update');
    Route::post('proyectos-evento/{proyectoEvento}/publicar', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'publicar'])->name('proyectos-evento.publicar');
    Route::post('proyectos-evento/{proyectoEvento}/despublicar', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'despublicar'])->name('proyectos-evento.despublicar');
    Route::get('eventos/{evento}/proyecto/asignar', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'asignar'])->name('proyectos-evento.asignar');
    Route::get('eventos/{evento}/proyecto/{inscripcion}/create-individual', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'createIndividual'])->name('proyectos-evento.create-individual');
    Route::post('eventos/{evento}/proyecto/{inscripcion}/store-individual', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'storeIndividual'])->name('proyectos-evento.store-individual');

    //? Rutas para gestión de proyectos y evaluaciones
    Route::get('proyectos-evaluaciones', [App\Http\Controllers\Admin\ProyectoEvaluacionController::class, 'index'])->name('proyectos-evaluaciones.index');
    Route::get('proyectos-evaluaciones/{inscripcion}', [App\Http\Controllers\Admin\ProyectoEvaluacionController::class, 'show'])->name('proyectos-evaluaciones.show');

    Route::resource('eventos', EventoController::class);
    Route::resource('users', UserController::class)->only(['index', 'edit', 'update', 'destroy']);
    Route::resource('equipos', AdminEquipoController::class)->except(['create', 'store']);
    
    // Excluir equipo de un evento específico (sin eliminarlo)
    Route::post('equipos/{equipo}/remove-from-event', [AdminEquipoController::class, 'removeFromEvent'])->name('equipos.remove-from-event');
    
    // Gestión de miembros por admin
    Route::delete('miembros/{miembro}', [AdminMiembroController::class, 'destroy'])->name('miembros.destroy');
    Route::patch('miembros/{miembro}/role', [AdminEquipoController::class, 'updateMemberRole'])->name('miembros.update-role');

    // Gestión de tokens de jurado
    Route::resource('jurado-tokens', App\Http\Controllers\Admin\JuradoTokenController::class)->names([
        'index' => 'jurado-tokens.index',
        'create' => 'jurado-tokens.create',
        'store' => 'jurado-tokens.store'
    ])->only(['index', 'create', 'store']);

    // Acciones adicionales para tokens de jurado
    Route::patch('jurado-tokens/{token}/revocar', [App\Http\Controllers\Admin\JuradoTokenController::class, 'revocar'])->name('jurado-tokens.revocar');
    Route::patch('jurado-tokens/{token}/extender', [App\Http\Controllers\Admin\JuradoTokenController::class, 'extender'])->name('jurado-tokens.extender');
    Route::post('jurado-tokens/{token}/reenviar', [App\Http\Controllers\Admin\JuradoTokenController::class, 'reenviar'])->name('jurado-tokens.reenviar');
    Route::patch('miembros/{miembro}/toggle-leader', [AdminEquipoController::class, 'toggleLeader'])->name('miembros.toggle-leader');
    
    //Rutas para exportar reportes en Excel y pdf
    Route::get('reportes', [ReporteExcelController::class, 'index'])->name('reportes.index');
    Route::get('reportes/eventos', [ReporteExcelController::class, 'exportarEventos'])->name('reportes.eventos');
    Route::get('reportes/proyectos', [ReporteExcelController::class, 'exportarProyectos'])->name('reportes.proyectos');
    Route::get('reportes/equipos', [ReporteExcelController::class, 'exportarEquipos'])->name('reportes.equipos');
    Route::get('reportes/eventos/pdf', [ReporteExcelController::class, 'exportarEventosPdf'])->name('reportes.eventos.pdf');
    Route::get('reportes/proyectos/pdf', [ReporteExcelController::class, 'exportarProyectosPdf'])->name('reportes.proyectos.pdf');
    Route::get('reportes/equipos/pdf', [ReporteExcelController::class, 'exportarEquiposPdf'])->name('reportes.equipos.pdf');
});

//? Rutas para Jurados
Route::middleware(['auth', 'role:jurado'])->prefix('jurado')->name('jurado.')->group(function () {
    Route::get('/dashboard', JuradoDashboardController::class)->name('dashboard');
    Route::get('/equipos/{equipo}', [App\Http\Controllers\Jurado\EquipoController::class, 'show'])->name('equipos.show');
    Route::get('/equipos', [App\Http\Controllers\Jurado\EquipoController::class, 'index'])->name('equipos.index');
    
    // Evaluaciones
    Route::get('/evaluaciones/{inscripcion}/create', [App\Http\Controllers\Jurado\EvaluacionController::class, 'create'])->name('evaluaciones.create');
    Route::post('/evaluaciones/{inscripcion}', [App\Http\Controllers\Jurado\EvaluacionController::class, 'store'])->name('evaluaciones.store');
    Route::get('/evaluaciones/{evaluacion}', [App\Http\Controllers\Jurado\EvaluacionController::class, 'show'])->name('evaluaciones.show');


    // Eventos
    Route::get('/eventos', [EventosController::class, 'index'])->name('eventos.index');
    Route::get('/eventos/{evento}', [EventosController::class, 'show'])->name('eventos.show');
    Route::get('/eventos/{evento}/equipos/{equipo}', [EventosController::class, 'equipo_evento'])->name('eventos.equipo_evento');
    Route::get('/eventos/{evento}/equipos/{equipo}/avance/{avance}', [EventosController::class, 'calificar_avance'])->name('eventos.calificar_avance');
    Route::post('/eventos/{evento}/equipos/{equipo}/avance/{avance}/guardar', [EventosController::class, 'guardar_calificacion'])->name('eventos.guardar_calificacion');

});

//? Rutas para Estudiantes
Route::middleware(['auth', 'role:estudiante'])->prefix('estudiante')->name('estudiante.')->group(function () {
    Route::get('/dashboard', EstudianteDashboardController::class)->name('dashboard');
    Route::get('/stats', [StatsController::class, 'dashboard'])->name('stats.dashboard');
    Route::get('eventos', [EstudianteEventoController::class, 'index'])->name('eventos.index');
    Route::get('eventos/{evento}', [EstudianteEventoController::class, 'show'])->name('eventos.show');
    Route::get('eventos/{evento}/posiciones', [EstudianteEventoController::class, 'posiciones'])->name('eventos.posiciones');

    // Rutas para Equipos
    Route::get('mi-equipo', MiEquipoController::class)->name('equipo.index');
    Route::get('mi-equipo/edit', [EstudianteEquipoController::class, 'edit'])->name('equipo.edit');
    Route::put('mi-equipo', [EstudianteEquipoController::class, 'update'])->name('equipo.update');
    Route::get('mi-equipo/{inscripcion}', [MiEquipoController::class, 'showDetalle'])->name('equipo.show-detalle');
    Route::resource('eventos.equipos', EstudianteEquipoController::class)->only(['index', 'create', 'store', 'show']);

    // Rutas para registrar equipo existente a evento
    Route::get('eventos/{evento}/registrar-equipo-existente', [EstudianteEquipoController::class, 'selectEquipoExistente'])->name('eventos.select-equipo-existente');
    Route::post('eventos/{evento}/registrar-equipo-existente', [EstudianteEquipoController::class, 'registrarEquipoExistente'])->name('eventos.registrar-equipo-existente');

    // Rutas para Gestionar Miembros
    Route::patch('miembros/{miembro}/update-role', [MiembroController::class, 'updateRole'])->name('miembros.updateRole');
    Route::delete('miembros/{miembro}', [MiembroController::class, 'destroy'])->name('miembros.destroy');
    Route::post('miembros/leave', [MiembroController::class, 'leave'])->name('miembros.leave');
    
    // Rutas para Solicitudes de Unión
    Route::post('equipos/{equipo}/solicitar', [SolicitudController::class, 'store'])->name('solicitudes.store');
    Route::post('solicitudes/{solicitud}/aceptar', [SolicitudController::class, 'accept'])->name('solicitudes.accept');
    Route::post('solicitudes/{solicitud}/rechazar', [SolicitudController::class, 'reject'])->name('solicitudes.reject');
    Route::get('equipos/{equipo}/preview', [EquipoPreviewController::class, 'show'])->name('equipos.preview');
    Route::get('api/equipos/disponibles', [EquipoPreviewController::class, 'getAvailableTeams']);
    
    // Rutas para Habilidades del Estudiante
    Route::get('habilidades', [HabilidadController::class, 'index'])->name('habilidades.index');
    Route::post('habilidades', [HabilidadController::class, 'store'])->name('habilidades.store');
    Route::patch('habilidades/{habilidad}', [HabilidadController::class, 'update'])->name('habilidades.update');
    Route::delete('habilidades/{habilidad}', [HabilidadController::class, 'destroy'])->name('habilidades.destroy');
    

    // Rutas para Recursos del Equipo
    Route::get('equipos/{equipo}/recursos', [RecursoController::class, 'index'])->name('recursos.index');
    Route::post('equipos/{equipo}/recursos', [RecursoController::class, 'store'])->name('recursos.store');
    Route::delete('recursos/{recurso}', [RecursoController::class, 'destroy'])->name('recursos.destroy');
    
    // Rutas para Tecnologías del Proyecto
    Route::post('proyectos/{proyecto}/tecnologias', [TecnologiaController::class, 'store'])->name('tecnologias.store');
    Route::delete('proyectos/{proyecto}/tecnologias/{tecnologia}', [TecnologiaController::class, 'destroy'])->name('tecnologias.destroy');
    
    // Rutas para Feed de Actividades
    Route::get('eventos/{evento}/actividades', [ActividadController::class, 'feedEvento'])->name('actividades.evento');
    Route::get('equipos/{equipo}/actividades', [ActividadController::class, 'feedEquipo'])->name('actividades.equipo');
    
    //! Rutas para Mis Proyectos (índice general)
    Route::get('mis-proyectos', [MisProyectosController::class, 'index'])->name('proyectos.index');

    //! Rutas para Proyecto del Equipo
    Route::get('equipo/proyecto', [App\Http\Controllers\Estudiante\ProyectoController::class, 'show'])->name('proyecto.show');
    Route::get('equipo/proyecto/create', [App\Http\Controllers\Estudiante\ProyectoController::class, 'create'])->name('proyecto.create');
    Route::post('equipo/proyecto', [App\Http\Controllers\Estudiante\ProyectoController::class, 'store'])->name('proyecto.store');
    Route::get('equipo/proyecto/edit', [App\Http\Controllers\Estudiante\ProyectoController::class, 'edit'])->name('proyecto.edit');
    Route::patch('equipo/proyecto', [App\Http\Controllers\Estudiante\ProyectoController::class, 'update'])->name('proyecto.update');

    //! Rutas para Proyectos Específicos (desde mis-proyectos)
    Route::get('proyectos/{proyecto}', [App\Http\Controllers\Estudiante\ProyectoController::class, 'showSpecific'])->name('proyecto.show-specific');
    Route::get('proyectos/{proyecto}/edit', [App\Http\Controllers\Estudiante\ProyectoController::class, 'editSpecific'])->name('proyecto.edit-specific');
    Route::patch('proyectos/{proyecto}', [App\Http\Controllers\Estudiante\ProyectoController::class, 'updateSpecific'])->name('proyecto.update-specific');

    //! Rutas para Crear Proyecto basado en Evento
    Route::get('proyecto-evento/{evento}/create', [App\Http\Controllers\Estudiante\ProyectoController::class, 'createFromEvento'])->name('proyecto.create-from-evento');
    Route::post('proyecto-evento/{evento}/store', [App\Http\Controllers\Estudiante\ProyectoController::class, 'storeFromEvento'])->name('proyecto.store-from-evento');
    
    //! Ruta para ver Proyecto del Evento (asignado por admin)
    Route::get('proyecto-evento', [App\Http\Controllers\Estudiante\ProyectoController::class, 'showProyectoEvento'])->name('proyecto-evento.show');
    Route::get('proyecto-evento/{evento}', [App\Http\Controllers\Estudiante\ProyectoController::class, 'showProyectoEventoEspecifico'])->name('proyecto-evento.especifico');
    
    // Rutas para Tareas del Proyecto
    Route::get('equipo/proyecto/tareas', [App\Http\Controllers\Estudiante\TareaController::class, 'index'])->name('tareas.index');
    Route::post('equipo/proyecto/tareas', [App\Http\Controllers\Estudiante\TareaController::class, 'store'])->name('tareas.store');
    Route::patch('tareas/{tarea}/toggle', [App\Http\Controllers\Estudiante\TareaController::class, 'toggle'])->name('tareas.toggle');
    Route::delete('tareas/{tarea}', [App\Http\Controllers\Estudiante\TareaController::class, 'destroy'])->name('tareas.destroy');

    // Rutas para Tareas Específicas de Proyecto
    Route::get('proyectos/{proyecto}/tareas', [App\Http\Controllers\Estudiante\TareaController::class, 'indexSpecific'])->name('tareas.index-specific');
    Route::post('proyectos/{proyecto}/tareas', [App\Http\Controllers\Estudiante\TareaController::class, 'storeSpecific'])->name('tareas.store-specific');
    Route::patch('proyectos/tareas/{tarea}/toggle', [App\Http\Controllers\Estudiante\TareaController::class, 'toggle'])->name('proyectos.tareas.toggle');
    Route::delete('proyectos/tareas/{tarea}', [App\Http\Controllers\Estudiante\TareaController::class, 'destroy'])->name('proyectos.tareas.destroy');

    // Rutas para Avances del Proyecto
    Route::get('equipo/proyecto/avances', [App\Http\Controllers\Estudiante\AvanceController::class, 'index'])->name('avances.index');
    Route::get('equipo/proyecto/avances/create', [App\Http\Controllers\Estudiante\AvanceController::class, 'create'])->name('avances.create');
    Route::post('equipo/proyecto/avances', [App\Http\Controllers\Estudiante\AvanceController::class, 'store'])->name('avances.store');
    Route::get('equipo/proyecto/avances/{avance}', [App\Http\Controllers\Estudiante\AvanceController::class, 'show'])->name('avances.show');

    // Rutas para Avances Específicos de Proyecto
    Route::get('proyectos/{proyecto}/avances', [App\Http\Controllers\Estudiante\AvanceController::class, 'indexSpecific'])->name('avances.index-specific');
    Route::get('proyectos/{proyecto}/avances/create', [App\Http\Controllers\Estudiante\AvanceController::class, 'createSpecific'])->name('avances.create-specific');
    Route::post('proyectos/{proyecto}/avances', [App\Http\Controllers\Estudiante\AvanceController::class, 'storeSpecific'])->name('avances.store-specific');
    Route::get('proyectos/avances/{avance}', [App\Http\Controllers\Estudiante\AvanceController::class, 'showSpecific'])->name('avances.show-specific');

    Route::get('constancias', [App\Http\Controllers\Estudiante\ConstanciaController::class, 'index'])->name('constancias.index');
    //Ruta para ver constancias
    Route::get('constancias/ver/{evento}', [App\Http\Controllers\Estudiante\ConstanciaController::class, 'generarPdf'])->name('constancias.ver');
    //? Rutas para proyectos del evento
Route::post('eventos/{evento}/configurar-tipo-proyecto', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'configurarTipo'])->name('eventos.configurar-proyectos');
Route::get('eventos/{evento}/proyecto/create', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'create'])->name('proyectos-evento.create');
Route::post('eventos/{evento}/proyecto', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'store'])->name('proyectos-evento.store');
Route::get('proyectos-evento/{proyectoEvento}/edit', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'edit'])->name('proyectos-evento.edit');
Route::patch('proyectos-evento/{proyectoEvento}', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'update'])->name('proyectos-evento.update');
Route::post('proyectos-evento/{proyectoEvento}/publicar', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'publicar'])->name('proyectos-evento.publicar');
Route::post('proyectos-evento/{proyectoEvento}/despublicar', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'despublicar'])->name('proyectos-evento.despublicar');
Route::get('eventos/{evento}/proyecto/asignar', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'asignar'])->name('proyectos-evento.asignar');
Route::get('eventos/{evento}/proyecto/{inscripcion}/create-individual', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'createIndividual'])->name('proyectos-evento.create-individual');
Route::post('eventos/{evento}/proyecto/{inscripcion}/store-individual', [App\Http\Controllers\Admin\ProyectoEventoController::class, 'storeIndividual'])->name('proyectos-evento.store-individual');

// Rutas para crear equipos sin evento
Route::get('equipos/crear', [EstudianteEquipoController::class, 'createSinEvento'])->name('equipos.create-sin-evento');
Route::post('equipos/guardar', [EstudianteEquipoController::class, 'storeSinEvento'])->name('equipos.store-sin-evento');
});

//? Rutas para Jurados
Route::middleware(['auth', 'role:jurado'])->prefix('jurado')->name('jurado.')->group(function () {
    Route::get('/dashboard', App\Http\Controllers\Jurado\DashboardController::class)->name('dashboard');
    
    // Rutas para constancias
    Route::get('/constancias', [App\Http\Controllers\Jurado\ConstanciaController::class, 'index'])->name('constancias.index');
    Route::get('/constancias/{evento}', [App\Http\Controllers\Jurado\ConstanciaController::class, 'generarPdf'])->name('constancias.ver');
});


require __DIR__.'/auth.php';