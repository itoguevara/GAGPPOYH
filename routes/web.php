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
use App\Http\Controllers\userauth\simpatizantesctrl;
use App\Http\Controllers\generic\genericctrl;
use app\Models\userauth\simpatizantemdl;
use App\View\Components\userauth\tcsolicitud;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;
/*
Route::view('/', 'home')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('home', 'home')->name('homeverified');
});
*/
Route::get('/', function ($opcionvar, $solicituduser= null) {
   
    if (Auth::check()== true) {
        $id_data_search = app()->call('App\Http\Controllers\userauth\usuadatactrl@GetDataUser')->first()->id_persona ?? null;}
     else {   
        $id_data_search = -1; // Valor predeterminado si no hay usuario autenticado
     }
    $recordsimpatizantes = app()->call('App\Http\Controllers\userauth\Simpatizantesctrl@GetDatasimpatizante', ['id_data_search' => $id_data_search, 'id_opcion' => -1]);    
//     return redirect()->route('home', [$opcionvar]);
//    return redirect()->route('home')->with('opcionvar', $opcionvar);;
    return view('Home', compact('opcionvar', 'recordsimpatizantes'));
})->name('home')->where('opcionvar', '0|1|2|3|4|5|6|7|8|9');

Route::post('/', function ($opcionvar, $recordsimpatizantes = null) {

    return view('Home', compact('opcionvar', 'recordsimpatizantes'));    
})->name('home')->where('opcionvar', '0|1|2|3|4|5|6|7|8|9');

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');
/* Rutas Genericas */
Route::get('/generic/{opcionvar}', [genericctrl::class, 'show'])->middleware('auth')->where('opcionvar', '0|1|2|3|4|5|6|7|8|9')->name('generic.show');
/* Rutas de Simpatizantes*/
Route::get('/simpatizante/{opcionvar}', [simpatizantesctrl::class, 'show'])->middleware('auth')->where('opcionvar', '0|1|2|3|4|5|6|7|8|9')->name('simpatizantes') ;
Route::post('/simpatizante/{opcionvar}', [simpatizantesctrl::class, 'store'])->middleware('auth')->where('opcionvar', '0|1|2|3|4|5|6|7|8|9')->name('simpatizante.store');
Route::get('/simpatizante/search/{opcionvar}', [simpatizantesctrl::class,'search'])->middleware('auth')->where('opcionvar', '0|1|2|3|4|5|6|7|8|9')->name('simpatizante.search') ;
Route::get('/simpatizante/edit}', [simpatizantesctrl::class,'edit'])->middleware('auth')->name('simpatizante.edit');
Route::post('/simpatizante/edit', [simpatizantesctrl::class,'edit'])->middleware('auth')->name('simpatizante.edit');
Route::get('/simpatizante/report', [simpatizantesctrl::class,'report'])->middleware('auth')->where('report_option', '0|1|2|3|4|5|6|7|8|9')->name('simpatizante.report') ;

require __DIR__.'/settings.php';
