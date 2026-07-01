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
/*
Route::view('/', 'home')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('home', 'home')->name('homeverified');
});
*/
Route::get('/', function ($opcionvar = '0', $solicituduser= null) {
    
    if (Auth::check()== true) {
        $id_data_search = app()->call('App\Http\Controllers\userauth\usuadatactrl@GetDataUser')->first()->id_persona ?? null;
        $clientesdata = app()->call('App\Http\Controllers\simpatizantes\simpatizanteCtrl@GetDatasimpatizante', ['id_data_search' => $id_data_search, 'id_opcion' => 1]);    
        // Buscar Datos de las Solicitudes del usuario
        $solicituduser = PublicFunctions::GetDataObject(11, '', $clientesdata[0]->id_clienteempre ?? -1);
    }
    return view('Home', compact('opcionvar', 'solicituduser'));
})->name('home')->where('opcionvar', '0|1|2|3|4|5|6|7|8|9');

Route::post('/', function ($opcionvar = '0', $solicituduser = null) {
    return view('Home', compact('opcionvar', 'solicituduser'));    
})->name('home')->where('opcionvar', '0|1|2|3|4|5|6|7|8|9');

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::get('/solicitud/{opcionvar}', [solicitudctrl::class, 'show'])->middleware('auth')->where('opcionvar', '0|1|2|3|4|5|6|7|8|9')->name('solicitud') ;
Route::post('/solicitud/{opcionvar}', [solicitudctrl::class, 'store'])->middleware('auth')->where('opcionvar', '0|1|2|3|4|5|6|7|8|9')->name('solicitud.store');
Route::get('/solicitud/search/{opcionvar}', [solicitudctrl::class,'search'])->middleware('auth')->where('opcionvar', '0|1|2|3|4|5|6|7|8|9')->name('solicitud.search') ;
Route::get('/solicitud/edit/{opcionvar}', [solicitudctrl::class,'edit'])->middleware('auth')->name('solicitud.edit');
Route::post('/solicitud/edit/{opcionvar}', [solicitudctrl::class,'edit'])->middleware('auth')->name('solicitud.edit');
Route::get('/solicitud/report', [solicitudctrl::class,'report'])->middleware('auth')->where('report_option', '0|1|2|3|4|5|6|7|8|9')->name('solicitud.report') ;

require __DIR__.'/settings.php';
