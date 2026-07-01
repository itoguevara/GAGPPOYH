<?php
/*** Valores de Opcionvar para las Acciones en las vistas de los modulos (Solicitudes, Usuarios, etc) dependiendo de la acción que se esta realizando o el proceso que se esta ejecutando en la vista,
 *** para mostrar los componentes o realizar las acciones correspondientes a cada proceso
 *** Comenzando con 0 para la Pagina Principal HomePage
 * opcionvar = 0: Mostrar 
 * opcionvar = 1: Crear 
 * opcionvar = 2: Editar 
 * opcionvar = 3: Eliminar 
 * opcionvar = 4: Imprimir 
 * opcionvar = 5: Buscar 
 * opcionvar = 6: Filtrar 
 * opcionvar = 7: Ordenar 
 * opcionvar = 8: Exportar 
 */
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use App\Http\Controllers\userauth\usuadatactrl;
use App\Http\Controllers\userauth\solicitudctrl;
use app\Models\userauth\solicitudmdl;
use App\View\Components\userauth\tcsolicitud;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

Route::view('/', 'home')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('home', 'home')->name('homeverified');
});

Route::get('/solicitud/{opcionvar}', [solicitudctrl::class, 'show'])->middleware('auth')->where('opcionvar', '0|1|2|3|4|5|6|7|8|9')->name('solicitud') ;
Route::post('/solicitud/{opcionvar}', [solicitudctrl::class, 'store'])->middleware('auth')->where('opcionvar', '0|1|2|3|4|5|6|7|8|9')->name('solicitud.store');
Route::get('/solicitud/search/{opcionvar}', [solicitudctrl::class,'search'])->middleware('auth')->where('opcionvar', '0|1|2|3|4|5|6|7|8|9')->name('solicitud.search') ;
Route::get('/solicitud/edit/{opcionvar}', [solicitudctrl::class,'edit'])->middleware('auth')->name('solicitud.edit');
Route::post('/solicitud/edit/{opcionvar}', [solicitudctrl::class,'edit'])->middleware('auth')->name('solicitud.edit');
Route::get('/solicitud/report', [solicitudctrl::class,'report'])->middleware('auth')->where('report_option', '0|1|2|3|4|5|6|7|8|9')->name('solicitud.report') ;

require __DIR__.'/settings.php';
