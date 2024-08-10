<?php

use App\Events\TicketStatusChangedEvent;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CorreosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EstacionController;
use App\Http\Controllers\FallaController;
use App\Http\Controllers\FolioController;
use App\Http\Controllers\GuardiasController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PrioridadController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RequisicionController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TiposController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VersionController;
use App\Http\Controllers\ZonaController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'data'])->name('dashboard');
	Route::get('/notificaciones', [DashboardController::class, 'notifs'])->name('notificaciones');

    //Usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('users');
    Route::delete('/users{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get("/trashed", [UserController::class, "trashed_users"])->name('users.trashed');
	Route::get("/visitas", [UserController::class, "visita_users"])->name('users.visita');
    Route::post("/restoreuser", [UserController::class, "do_restore"])->name('user_restore');
    Route::post("/deleteuser-permanently", [UserController::class, "delete_permanently"])->name('deleteuser_permanently');

    //Zonas
    Route::get('/zonas', [ZonaController::class, 'index'])->name('zonas');
    Route::delete('/zonas{zona}', [ZonaController::class, 'destroy'])->name('zonas.destroy');
    Route::get("/trashedzonas", [ZonaController::class, "trashed_zonas"])->name('zonas.trashedzonas');
    Route::post("/restorezona", [ZonaController::class, "do_restore"])->name('zona_restore');
    Route::post("/deletezona-permanently", [ZonaController::class, "delete_permanently"])->name('deletezona_permanently');

    //Estaciones
    Route::get('/estaciones', [EstacionController::class, 'index'])->name('estaciones');
    Route::delete('/estaciones{estacion}', [EstacionController::class, 'destroy'])->name('estaciones.destroy');
    Route::get("/trashedestaciones", [EstacionController::class, "trashed_estaciones"])->name('estaciones.trashed');
    Route::post("/restoreestacion", [EstacionController::class, "do_restore"])->name('estacion_restore');
    Route::post("/deleteestacion-permanently", [EstacionController::class, "delete_permanently"])->name('deleteestacion_permanently');

    //Categorias
    Route::controller(CategoriaController::class)->group(function(){
    Route::get('/categorias','index')->name('categorias');
    Route::delete('/categorias{categoria}','destroy')->name('categorias.destroy');
    Route::get("/trashedcategorias","trashed_categorias")->name('categorias.trashed');
    Route::post("/restorecategoria","do_restore")->name('categoria_restore');
    Route::post("/deletecategoria-permanently","delete_permanently")->name('deletecategoria_permanently');
    Route::get('/marcas','marcas')->name('marcas');
    Route::get("/trashedmarcas", "trashed_marcas")->name('marcas.trashed');
    Route::post("/restoremarca", "do_restoreM")->name('marca_restore');
    Route::post("/deletemarca-permanently", "delete_permanentlyM")->name('deletemarca_permanently');
    Route::get('/tck/servicios','servicios')->name('serviciosTCK');
    });

    //Productos
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
    Route::delete('/productos{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    Route::get("/trashedproductos", [ProductoController::class, "trashed_productos"])->name('productos.trashed');
    Route::post("/restoreproducto", [ProductoController::class, "do_restore"])->name('producto_restore');
    Route::post("/deleteproducto-permanently", [ProductoController::class, "delete_permanently"])->name('deleteproducto_permanently');

    //Permisos
    Route::get('/roles', [PermisoController::class, 'show'])->name('roles');
    Route::put('/roles/{id}', [PermisoController::class, 'asignar'])->name('asignacionpermiso.asignar');

    //Sistema
    Route::get('/versiones', [VersionController::class, 'show'])->name('versiones');
    Route::get('/manuales', [ManualController::class, 'show'])->name('manuales');
    Route::get('/horarios', [ManualController::class, 'index'])->name('horarios');

    //Areas
    Route::get('/areas', [AreaController::class, "home"])->name('areas');
    Route::delete('/areas{area}', [AreaController::class, 'destroy'])->name('areas.destroy');
    Route::get("/trashedareas", [AreaController::class, "trashed_areas"])->name('areas.trashed');
    Route::post("/restorearea", [AreaController::class, "do_restore"])->name('area_restore');
    Route::post("/deletearea-permanently", [AreaController::class, "delete_permanently"])->name('deletearea_permanently');

    //Departamentos
    Route::get('/departamentos',[DepartamentoController::class,'home'])->name('departamentos');
    Route::delete('/departamentos{departamento}', [DepartamentoController::class, 'destroy'])->name('departamentos.destroy');
    Route::get("/trasheddepartamentos", [DepartamentoController::class, "trashed_departamentos"])->name('departamentos.trashed');
    Route::post("/restoredepartamento", [DepartamentoController::class, "do_restore"])->name('departamento_restore');
    Route::post("/deletedepartamento-permanently", [DepartamentoController::class, "delete_permanently"])->name('deletedepartamento_permanently');
    
    //Regiones
    Route::get('/regiones', [RegionController::class, 'home'])->name('regiones');
    Route::delete('/regiones{region}', [RegionController::class, 'destroy'])->name('regiones.destroy');
    Route::get("/trashedregiones", [RegionController::class, "trashed_regiones"])->name('regiones.trashed');
    Route::post("/restoreregion", [RegionController::class, "do_restore"])->name('region_restore');
    Route::post("/deleteregion-permanently", [RegionController::class, "delete_permanently"])->name('deleteregion_permanently');

    //tipos
    Route::get('/tipos',[TiposController::class,'home'])->name('tipos');
    Route::delete('/tipos{tipo}', [TiposController::class, 'destroy'])->name('tipos.destroy');
    Route::get("/trashedtipos", [TiposController::class, "trashed_tipos"])->name('tipos.trashed');
    Route::post("/restoretipo", [TiposController::class, "do_restore"])->name('tipo_restore');
    Route::post("/deletetipo-permanently", [TiposController::class, "delete_permanently"])->name('deletetipo_permanently');

    //prioridades
    Route::get('/prioridades',[PrioridadController::class,'home'])->name('prioridades');
    Route::delete('/prioridades{prioridad}', [PrioridadController::class, 'destroy'])->name('prioridades.destroy');
    Route::get("/trashedprioridades", [PrioridadController::class, "trashed_prioridades"])->name('prioridades.trashed');
    Route::post("/restoreprioridad", [PrioridadController::class, "do_restore"])->name('prioridad_restore');
    Route::post("/deleteprioridad-permanently", [PrioridadController::class, "delete_permanently"])->name('deleteprioridad_permanently');

    //servicios
    Route::get('/servicios',[ServicioController::class,'home'])->name('servicios');
    Route::delete('/servicios{servicio}', [ServicioController::class, 'destroy'])->name('servicios.destroy');
    Route::get("/trashedservicios", [ServicioController::class, "trashed_servicios"])->name('servicios.trashed');
    Route::post("/restoreservicios", [ServicioController::class, "do_restore"])->name('servicios_restore');
    Route::post("/deleteservicio-permanently", [ServicioController::class, "delete_permanently"])->name('deleteservicio_permanently');

    //fallas
    Route::get('/fallas',[FallaController::class,'home'])->name('fallas');
    Route::delete('/fallas{falla}', [FallaController::class, 'destroy'])->name('fallas.destroy');
    Route::get("/trashedfallas", [FallaController::class, "trashed_fallas"])->name('fallas.trashed');
    Route::post("/restorefallas", [FallaController::class, "do_restore"])->name('fallas_restore');
    Route::post("/deletefalla-permanently", [FallaController::class, "delete_permanently"])->name('deletefalla_permanently');
    
    //tickets
    Route::controller(TicketController::class)->group(function(){
        Route::get('/tickets','home')->name('tickets');
        Route::get('/tickets/abiertos','open')->name('tickets.open');
        Route::get('/tickets/enproceso','process')->name('tickets.process');
        Route::get('/tickets/cerrados','closed')->name('tickets.closed');
        Route::get('/tickets/ver/{id}','ver')->name('tck.ver');
        Route::get('/tickets/editar/{id}','editar')->name('tck.editar');
        Route::delete('/tickets{id}', 'removeArch')->name('tck.destroy');
        Route::delete('/tickets{id}', 'removeCom')->name('com.destroy');
        Route::get('/tickets/tarea{id}','tarea')->name('tck.tarea');
        Route::get('/tickets/requisicion{id}','compra')->name('tck.compra');
        Route::get('/tickets/pendientes','pendientes')->name('tck.abierto');
        Route::get('/tickets/almacenCIS','almacenCIS')->name('almacenCIS');
		Route::get('/export-tickets', 'exportTickets')->name('export.excel');
		Route::get('/backup/db', 'backup')->name('backup');
    });

    Route::controller(TareaController::class)->group(function(){
        Route::get('/tareas','home')->name('tareas');
    });
    //requisiciones (apartado)
    Route::controller(RequisicionController::class)->group(function(){
        Route::get('/requisiciones','home')->name('requisiciones');
        Route::get('/requisiciones/search','search')->name('requisiciones.search');
        Route::get('/requisiciones/{id}','edit')->name('req.edit');
    });

     //folios de entradas y salidas
     Route::controller(FolioController::class)->group(function(){
        Route::get('/tck/folios/entradas','entradas')->name('folios.entradas');
        Route::get('/tck/folios/salidas','salidas')->name('folios.salidas');
        Route::get('/tck/folios/entradas/{id}','editEntrada')->name('entrada.edit');
        Route::get('/tck/folios/salidas/{id}','editSalida')->name('salida.edit');
    });
     //analiticas
     Route::controller(AnalyticsController::class)->group(function(){
        Route::get('/analytics/general','general')->name('analytics.general');
        Route::get('/analytics/users','users')->name('analytics.users');
        Route::get('/analytics/compras','compras')->name('analytics.compras');
        Route::get('/analytics/calificaciones','calificaciones')->name('analytics.calificaciones');
    });
    //guardias de fin de semana
    Route::controller(GuardiasController::class)->group(function(){
        Route::get('/guardias','home')->name('guardias.home');
    });

    //correos para compras
    Route::controller(CorreosController::class)->group(function(){
        Route::get('/compras/correos','home')->name('correos');
        Route::get('/compras/correos/asignados','asignados')->name('correos.asignados');
    });
});
