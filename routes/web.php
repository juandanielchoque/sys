<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\CambiarClaveController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\HomeUsuarioController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecuperarClaveController;
use App\Http\Controllers\ReporteExcelController;
use App\Http\Controllers\ReportePdfController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route("home");
});

Route::get('/homeCliente', [HomeUsuarioController::class, "index"])->name('homeCliente')->middleware(['verified', 'cliente']);
Route::get('/verAsistencia', [HomeUsuarioController::class, 'verAsistencia'])->name('ver.asistencia')->middleware('verified', 'cliente');

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['verified','admin_empleado']);


//marcar por qr
Route::get('/marcar/QR', [AsistenciaController::class, 'marcarQR'])->name('marcar.qr')->middleware(['verified','cliente']);


/* mis rutas */

Route::resource("usuario", UsuarioController::class)->middleware(['verified', 'administrador']);
Route::post("/usuarioActualizar-img", [UsuarioController::class, "actualizarImagen"])->name("usuario.actualizarImagen")->middleware(['verified', 'administrador']);
Route::get("/usuarioEliminar-img-{id}", [UsuarioController::class, "eliminarImagen"])->name("usuario.eliminarImagen")->middleware(['verified', 'administrador']);


Route::resource("membresia", MembresiaController::class)->middleware(['verified', 'admin_empleado']);

Route::resource("asistencia", AsistenciaController::class)->middleware(['verified', 'admin_empleado']);

Route::resource("cliente", ClienteController::class)->middleware(['verified', 'admin_empleado']);
Route::get("/clienteDatos-{id}", [ClienteController::class, "datosCliente"])->name("cliente.datosCliente")->middleware(['verified', 'admin_empleado']);
Route::get("/clienteTransaccion-{id}", [ClienteController::class, "transaccionCliente"])->name("cliente.transaccionCliente")->middleware(['verified', 'admin_empleado']);
Route::get("/clientePago-{id}", [ClienteController::class, "pagoCliente"])->name("cliente.pagoCliente")->middleware(['verified', 'admin_empleado']);
Route::get("/consultar/registro/cliente/{id_membresia}/{desde}", [ClienteController::class, "consultar"])->name("cliente.consultar")->middleware(['verified', 'admin_empleado']);
Route::PUT("/renovar/cliente/{id_cliente}", [ClienteController::class, "renovar"])->name("cliente.renovar")->middleware(['verified', 'admin_empleado']);
Route::POST("/actualizar/cliente", [ClienteController::class, "editarDatosCliente"])->name("cliente.editarDatosCliente")->middleware(['verified', 'admin_empleado']);


Route::resource("pagos", PagoController::class)->middleware(['verified', 'admin_empleado']);



//empresa
/* info de la empresa */
Route::get("/empresa", [EmpresaController::class, "datos"])->name("empresa.datos")->middleware(['verified', 'administrador']);
Route::post("/empresa-editar", [EmpresaController::class, "editar"])->name("empresa.update")->middleware(['verified', 'administrador']);
Route::post("/empresa-edit-img", [EmpresaController::class, "editarImg"])->name("empresa.updateImg")->middleware(['verified', 'administrador']);
Route::get("/empresa-eliminar-img-{id}", [EmpresaController::class, "eliminarImg"])->name("empresa.destroy")->middleware(['verified', 'administrador']);


/* info de usuarioProfile */
Route::get("/profile-eliminar-img-{id}", [ProfileController::class, "eliminarImg"])->name("profile.destroy")->middleware(['verified', 'admin_empleado']);
Route::post("/profile-edit-img", [ProfileController::class, "editarImg"])->name("profile.updateImg")->middleware(['verified', 'admin_empleado']);
Route::post("/profile-editar", [ProfileController::class, "editar"])->name("profile.update")->middleware(['verified', 'admin_empleado']);
Route::get("/profile-{id}", [ProfileController::class, "datos"])->name("profile.datos")->middleware(['verified', 'admin_empleado']);

/* cambiar password */
Route::get('/cambiarClave-bd', [CambiarClaveController::class, 'index'])->name("cambiarClave.index")->middleware('verified');
Route::post('/cambiarClave-update-bd', [CambiarClaveController::class, 'update'])->name("cambiarClave.update")->middleware('verified');


/* recuperar password */
Route::get("/recuperar-contraseña", [RecuperarClaveController::class, 'index'])->name("recuperar.index");
Route::post("/recuperar-contraseña-update", [RecuperarClaveController::class, 'update'])->name("recuperar.update");
Route::get("/nueva-contraseña-index-{correo}-{codigo}", [RecuperarClaveController::class, 'nuevoClave'])->name("nuevo.clave");
Route::post("/nueva-contraseña-reset", [RecuperarClaveController::class, 'reset'])->name("reset.clave");


/* reportes excel */
Route::get("reporte/asistencia-excel",[ReporteExcelController::class, "reporteAsistencia"] )->name("reporte.asistencia")->middleware(['verified', 'admin_empleado']);

/* reportes pdf */
Route::get("reporte/asistencia-pdf",[ReportePdfController::class, "reporteAsistencia"] )->name("reporte.asistencia.pdf")->middleware(['verified', 'admin_empleado']);