<?php

namespace App\Http\Controllers\userauth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use App\Models\userauth\solicitudmdl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\userauth\famisolmdl;
use App\Models\userauth\famisoltmpmdl;
use PublicFunctions;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\Mime\Message;

class solicitudctrl extends Controller
{
    public $solicituduser = [];
    public $opcionvar;
    public $FunctionsPublic = null;

    /**
     * Report de Solcitudes.
     */
    public function report(Request $request)
    {
        $datos= null;
        $datos = $request->all();

        $solicituduser = session('solicituduser');
        $FunctionsPublic = new PublicFunctions();
        $FunctionsPublic->id_solicitud = Crypt::decrypt($datos['id_solicitud'] ?? -1);
        $FunctionsPublic->id_cliente = Crypt::decrypt($datos['id_cliente'] ?? -1);
        $FunctionsPublic->report_option = $datos['report_option'] ?? -1;

        if ($FunctionsPublic->id_cliente > 0 )
            {
                switch ($FunctionsPublic->report_option) {
                    case 0:  //Imprimir Todas las SOlicitudes del Clientef
                        $solicituduser = solicitudmdl::all();
                        break;              
                    case 1:  //Imprimir Carta de la Solicitud
                        if ($FunctionsPublic->id_solicitud > 0) {
                            $solicituduser = $FunctionsPublic->GetDataObject(12, '', $FunctionsPublic->id_solicitud) ?? -1;
                            $pdf = Pdf::loadView('userauth.reportes.solicitud.solicitudrpt', compact('solicituduser'));
                            /* return $pdf->download('solicitudreport.pdf');        */
                            return $pdf->stream('solicitudreport.pdf');        
                        }    
                        break;              
                    case 2:  //Imprimir Las Solicitudes de las Busqueda
                        if ($solicituduser !== null) {
                            $titulo = 'Relacion General de Solicitudes';
                            $pdf = Pdf::loadView('userauth.reportes.solicitud.solicituduserrpt', compact('solicituduser','titulo'));
                            /* return $pdf->download('solicitudreport.pdf');        */
                            return $pdf->setPaper('a4', 'landscape')
                                    ->stream('solicituduserrpt.pdf');
                        }    
                        break;              
                    default:
                        $solicituduser = null; // O manejar el caso de opción no válida
                }
           }
        //
   
    }

    /**
     * Display a listing of the resource
     */
    public function search(Request $request, int $opcionvar)
    {
      $datos = $request->all();
      $solicituduser = $request->input('solicituduser', null);
      $id_cliente = $request->input('id_cliente', -1);
      $id_status = $request->input('id_status', -1);
      $id_tipo_sol = $request->input('id_tipo_sol', -1);
      $data_search = trim($request->input('data_search', ''));
      $search_field = $request->input('search_field', -1);
      switch ($search_field) {
        case 0:  // Buscar Por Nro de Solicitud
            if ($request->input('data_search')== Null || $request->input('data_search')== '') {
                $message = 'Debe ingresar un número de solicitud para la búsqueda por número de solicitud.';
                 return redirect()->route('home', ['opcionvar' => 0, 'solicituduser' => null])->with('error', $message);
            } elseif ($request->input('data_search') != Null || $request->input('data_search') != '') {
                $solicituduser = DB::table('tramitesconsulares.vwsolicitudes')
                    ->distinct()
                    ->select(['vwsolicitudes.id', 'vwsolicitudes.nro_sol', 'vwsolicitudes.fecha', 'vwsolicitudes.id_cliente', 'vwsolicitudes.cedula', 'vwsolicitudes.cliente', 'vwsolicitudes.id_tipo_sol', 'vwsolicitudes.tipo_sol', 'vwsolicitudes.observacion', 'vwsolicitudes.id_status', 'vwsolicitudes.status'])
                    ->whereNotNull('vwsolicitudes.id')
                    ->where('vwsolicitudes.id_cliente', '=', $id_cliente)
                    ->Where('vwsolicitudes.nro_sol', 'like', '%'.$data_search.'%')
                    ->orderBy('vwsolicitudes.nro_sol')
                    ->paginate(5); // Paginación de 10 resultados por página
            } else {
                    $solicituduser= null; // O manejar el caso de opción no válida
                    $data_search = '';
                    $message = 'Debe ingresar un número de solicitud para la búsqueda por número de solicitud.';
                    return redirect()->route('home', ['opcionvar' => 0, 'solicituduser' => null])->with('error', $message);
            }
            break;
        case 1: // Buscar por Observacion
            if ($request->input('data_search')== Null || $request->input('data_search')== '') {
                $message = 'Debe ingresar una observación para la búsqueda por observación.';
                 return redirect()->route('home', ['opcionvar' => 0, 'solicituduser' => null])->with('error', $message);
            } elseif ($request->input('data_search') != Null || $request->input('data_search') != '') {
                $solicituduser = DB::table('tramitesconsulares.vwsolicitudes')
                    ->distinct()
                    ->select(['vwsolicitudes.id', 'vwsolicitudes.nro_sol', 'vwsolicitudes.fecha', 'vwsolicitudes.id_cliente', 'vwsolicitudes.cedula', 'vwsolicitudes.cliente', 'vwsolicitudes.id_tipo_sol', 'vwsolicitudes.tipo_sol', 'vwsolicitudes.observacion', 'vwsolicitudes.id_status', 'vwsolicitudes.status'])
                    ->whereNotNull('vwsolicitudes.id')
                    ->where('vwsolicitudes.id_cliente', '=', $id_cliente)
                    ->Where('vwsolicitudes.observacion', 'like', '%'.$data_search.'%')
                    ->orderBy('vwsolicitudes.nro_sol')
                    ->paginate(5); // Paginación de 5    resultados por página
            } else {
                $solicituduser = null; // O manejar el caso de opción no válida
                $data_search = '';
                $message = 'Debe ingresar un dato a buscar en la observación cargada a la solicitud.';
                 return redirect()->route('home', ['opcionvar' => 0, 'solicituduser' => null])->with('error', $message);
            }
            break;
        case 2: // Buscar por fecha
            if ($request->input('fecha_desde')== Null ) {
                $message = 'Debe ingresar una fecha de inicio para la búsqueda por fecha.';
                 return redirect()->route('home', ['opcionvar' => 0, 'solicituduser' => null])->with('error', $message);
            } elseif ($request->input('fecha_hasta')== Null) {
                $message = 'Debe ingresar una fecha de fin para la búsqueda por fecha.';
                 return redirect()->route('home', ['opcionvar' => 0, 'solicituduser' => null])->with('error', $message);
            } elseif ($request->input('fecha_desde') > $request->input('fecha_hasta')) {
                $message = 'La fecha de inicio no puede ser mayor que la fecha de fin.';
                 return redirect()->route('home', ['opcionvar' => 0, 'solicituduser' => null])->with('error', $message);
            } elseif ($request->input('fecha_desde') != Null && $request->input('fecha_hasta') != Null) {
                $fecha_desde = $request->input('fecha_desde');
                $fecha_hasta = $request->input('fecha_hasta');
                $data_search = ''; // Limpiar el campo de búsqueda para evitar conflictos
            } else {
                $recorddataobject = null; // O manejar el caso de opción no válida
                $fecha_desde = null;
                $fecha_hasta = null;
            }
            
            $solicituduser = DB::table('tramitesconsulares.vwsolicitudes')
                ->distinct()
                ->select(['vwsolicitudes.id', 'vwsolicitudes.nro_sol', 'vwsolicitudes.fecha', 'vwsolicitudes.id_cliente', 'vwsolicitudes.cedula', 'vwsolicitudes.cliente', 'vwsolicitudes.id_tipo_sol', 'vwsolicitudes.tipo_sol', 'vwsolicitudes.observacion', 'vwsolicitudes.id_status', 'vwsolicitudes.status'])
                ->whereNotNull('vwsolicitudes.id')
                ->where('vwsolicitudes.id_cliente', '=', $id_cliente)
                ->whereBetween('vwsolicitudes.fecha', [$fecha_desde, $fecha_hasta])
                ->orderBy('vwsolicitudes.nro_sol')
                ->paginate(5); // Paginación de 5 resultados por página

            break;
        case 3: // Buscar por Tipo
            if ($id_tipo_sol== Null || $id_tipo_sol== -1) {                
                $message = 'Debe seleccionar un tipo de solicitud para la búsqueda por tipo de solicitud.';
                 return redirect()->route('home', ['opcionvar' => 0, 'solicituduser' => null])->with('error', $message);
            } elseif ($id_tipo_sol != Null || $id_tipo_sol > 0) {
                $solicituduser = DB::table('tramitesconsulares.vwsolicitudes')
                    ->distinct()
                    ->select(['vwsolicitudes.id', 'vwsolicitudes.nro_sol', 'vwsolicitudes.fecha', 'vwsolicitudes.id_cliente', 'vwsolicitudes.cedula', 'vwsolicitudes.cliente', 'vwsolicitudes.id_tipo_sol', 'vwsolicitudes.tipo_sol', 'vwsolicitudes.observacion', 'vwsolicitudes.id_status', 'vwsolicitudes.status'])
                    ->whereNotNull('vwsolicitudes.id')
                    ->where('vwsolicitudes.id_cliente', '=', $id_cliente)
                    ->Where('vwsolicitudes.id_tipo_sol', '=', $id_tipo_sol)
                    ->orderBy('vwsolicitudes.nro_sol')
                    ->paginate(5); // Paginación de 5 resultados por página
            } else {
                $solicituduser = null; // O manejar el caso de opción no válida
                $id_tipo_sol = -1;
                $message = 'Debe seleccionar un tipo de solicitud para la búsqueda por tipo de solicitud.';
                 return redirect()->route('home', ['opcionvar' => 0, 'solicituduser' => null])->with('error', $message);
            }     
                
            break;
        case 4: // Buscar por Status
            if ($id_status== Null || $id_status== -1) {                
                $message = 'Debe seleccionar un status para la búsqueda por status.';
                 return redirect()->route('home', ['opcionvar' => 0, 'solicituduser' => null])->with('error', $message);
            } elseif ($id_status != Null || $id_status > 0) {  
                $solicituduser = DB::table('tramitesconsulares.vwsolicitudes')
                    ->distinct()
                    ->select(['vwsolicitudes.id', 'vwsolicitudes.nro_sol', 'vwsolicitudes.fecha', 'vwsolicitudes.id_cliente', 'vwsolicitudes.cedula', 'vwsolicitudes.cliente', 'vwsolicitudes.id_tipo_sol', 'vwsolicitudes.tipo_sol', 'vwsolicitudes.observacion', 'vwsolicitudes.id_status', 'vwsolicitudes.status'])
                    ->whereNotNull('vwsolicitudes.id')
                    ->where('vwsolicitudes.id_cliente', '=', $id_cliente)
                    ->Where('vwsolicitudes.id_status', '=', $id_status)
                    ->orderBy('vwsolicitudes.nro_sol')
                    ->paginate(5); // Paginación de 5 resultados por página
            } else {
                $solicituduser = null; // O manejar el caso de opción no válida
                $id_status = -1;
                $message = 'Debe seleccionar un status para la búsqueda por status.';
                 return redirect()->route('home', ['opcionvar' => 0, 'solicituduser' => null])->with('error', $message);    
            }

            break;              
        default:
            $solicituduser = null; // O manejar el caso de opción no válida
    }
        session()->put('solicituduser', $solicituduser,false);
            // Something posted
        if (isset($_GET['printer'])) {
            //return redirect()->route('solicitud.report',['solicituduser'=>$solicituduser,'report_option' => 2]);
      
            return redirect()->route('solicitud.report', ['solicituduser'=>$solicituduser,'report_option' => 2,'id_cliente' => Crypt::encrypt($id_cliente),'id_solicitud' => Crypt::encrypt(-1)]);
        } 

    return view('homepage', compact('solicituduser', 'opcionvar'));    


/*      
      $solicituduser = solicitudmdl::where('id_cliente', $id_cliente)
                                    ->where(function ($query) use ($data_search) {
                                         $query->where('nro_sol', 'like', '%' . $data_search . '%')
                                        ->orWhere('observacion', 'like', '%' . $data_search . '%');})
                                    ->get();
                 dd($id_cliente, $data_search,$solicituduser);
                return view('homepage', compact('solicituduser', 'opcionvar'));      
*/                                    

                /*return redirect()->route('home', compact('solicituduser', 'opcionvar'))->with('success', 'Búsqueda realizada exitosamente.');    */

/*                return view('homepage', compact('solicituduser', 'opcionvar'))->with('success', 'Búsqueda realizada exitosamente.');*/

  }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,int $opcionvar)
    {
        $rules = [
            'student' => 'required|max:20',
            'score' => 'required|numeric|min:1|max:10',
        ];
        $messages = [
            'student.required' => 'Agrega el nombre del estudiante.',
            'student.max' =>'El nombre del estudiante no puede ser mayor a :max caracteres.',
            'score.required' => 'Agrega la puntuación al estudiante.',
            'score.numeric' => 'La puntuación debe ser un número',
            'score.between' => 'La puntuación debe estar entre :min y :max'
        ];
        
        //$this->validate($request, $rules, $messages);
        
        $mesage = '';
        $datos = $request->all();
       //dd(isset($_POST['agregafamilia']),$_SERVER['REQUEST_METHOD']);
        $FunctionsPublic =  new PublicFunctions();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Something posted
            if (isset($_POST['save'])) {
                // Se guardó la solicitud
                $solicitud = new solicitudmdl();
                $solicitud->id_cliente = $datos['id_cliente'] ?? -1;
                $solicitud->nro_sol = $datos['nro_sol'] ?? 'SO-00000';
                $solicitud->observacion = $datos['observacion'] ?? '';
                $solicitud->id_status = $datos['id_status'] ?? -1;
                $solicitud->id_usercreator = Auth::user()->id ?? -1;
                $solicitud->id_tipo_sol = $datos['id_tipo_sol'] ?? -1;  
                $solicitud->fecha = now()->format('d-m-Y H:i:s'); // Establecer la fecha actual en formato dia/mes/año
                $solicitud->save();
                $mesage = 'Solicitud creada exitosamente.';
            } elseif (isset($_POST['delete'])) {
                $id_solicitud = $FunctionsPublic->GetDataObject(10, $datos['nro_sol'] ?? '')[0]->id ?? -1;
                if ($id_solicitud > 0) {    
                    $solicitud = solicitudmdl::findOrFail($id_solicitud);
                    $solicitud->delete(); // Retorna true o false
                    $mesage = 'Solicitud eliminada exitosamente.';
                } else {
                    $mesage = 'No se encontró la solicitud para eliminar.'.' Nro: '.$datos['nro_sol'];
                }       
            } elseif (isset($_POST['edit'])) {
                $solicituduser = null;
                $id_solicitud = $datos['id_solicitud'] ?? -1;
                if ($id_solicitud > 0) {
                    $solicituduser = $FunctionsPublic->GetDataObject(12, '', $id_solicitud) ?? -1;
                } else {
                    $mesage = 'ID de solicitud no proporcionado para edición.';
                }
                $opcionvar = 2; // Establecer opción para edición
                return view('homepage', compact('solicituduser', 'opcionvar')); 
            } elseif (isset($_POST['printer'])) {
                $mesage = 'Función de impresión no implementada aún.';
            } elseif (isset($_POST['exit'])) {
                $mesage = 'Función de exit no implementada aún.';
            } elseif (isset($_POST['agregafamilia'])) {
                $mesage = 'Se Agrego el Familia a la Solicitud';
                if ($request->session()->exists('familiares')) {
                    $familiares = session()->get('familiares');
                        dd($datos);
                        $array_fami = ["cedula" => $datos['userdocfami'] ?? '', "nombre" => $datos['usernamefami'] ?? '',"apellido" => $datos['userapefami'] ?? '', "id_parentesco" => $datos['parentesco'] ?? -1, "id_grdinstru" => $datos['grdoinst'] ?? -1, "id_profesion" => $datos['profesion'] ?? -1, "id_ocupacion" => $datos['ocupacion'] ?? -1, "id_clienteempre" => $datos['id_cliente'] ?? -1];                
                        famisoltmpmdl::create($array_fami );
                        //var_dump($array_fami);
                        //dd('Controlador');
                        $famisoltmpmdl = famisoltmpmdl::all();

                }
                
                //dd('Agrega Familia',session('familiares'));
                $famisoltmpmdl = famisoltmpmdl::all();
                return redirect()->route('solicitud', compact('opcionvar','famisoltmpmdl'))->with('success', $mesage);                
            }
            else {
                $mesage = '';
                 
                $id_famisol = $datos['id_famisol'] ?? -1;
                $famisoltmpmdl = famisoltmpmdl::findOrFail($id_famisol);
                $famisoltmpmdl->delete();
                
                 return redirect()->route('solicitud', compact('opcionvar','famisoltmpmdl'))->with('success', $mesage);                         
                
            }
        return redirect()->route('home', ['opcionvar' => 0, 'solicituduser' => $solicituduser ?? null])->with('success', $mesage);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(solicitudmdl $solicitudmdl,int $opcionvar)
    {
   /** $users = DB::table('usuarios.vwusuamodulos')->get();*/
 /** $users = DB::table('usuarios.vwusuamodulos')->get();*/
        $opcionvar = $opcionvar;
        $solcituduser = DB::table('tramitesconsulares.vwsolicitudes')
                ->distinct()
                ->select(['vwsolicitudes.id', 'vwsolicitudes.nro_sol', 'vwsolicitudes.fecha', 'vwsolicitudes.id_cliente', 'vwsolicitudes.cedula', 'vwsolicitudes.cliente', 'vwsolicitudes.id_tipo_sol', 'vwsolicitudes.tipo_sol', 'vwsolicitudes.observacion'])
                ->whereNotNull('vwsolicitudes.id')
                ->where('vwsolicitudes.id_cliente', '=', Auth::user()->id)
                ->orderBy('vwsolicitudes.nro_sol')
                ->paginate(5); // Paginación de 5 resultados por página
                 return view('homepage', compact('solcituduser', 'opcionvar')); 
 
   
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, int $opcionvar)
    {
        $datos= null;
        $datos = $request->all();
    
        $FunctionsPublic = new PublicFunctions();
        $FunctionsPublic->nro_sol= $datos['nro_sol'] ?? -1;
        $FunctionsPublic->id_accion = $datos['id_accion'] ?? -1;    
        $FunctionsPublic->solicituduser = null;
        $message = '';
        $opcionvar = 0; // Establecer opción para edición
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $solicitud = solicitudmdl::where('nro_sol', $FunctionsPublic->nro_sol)->get();
            $FunctionsPublic->id_cliente = $solicitud[0]->id_cliente ?? -1;
            if ($FunctionsPublic->id_cliente > 0) {
                $opcionvar = 0; // Establecer opción para edición
                if (isset($_POST['save']) == true) {
                    $solicitud[0]->observacion = $datos['observacion'] ?? '';
                    $solicitud[0]->id_status = $datos['id_status'] ?? -1;
                    $solicitud[0]->id_usercreator = Auth::user()->id ?? -1;
                    $solicitud[0]->id_tipo_sol = $datos['id_tipo_sol'] ?? -1;  
                    $solicitud[0]->fecha = $datos['fecha'] ??  now()->format('d-m-Y H:i:s'); // Establecer la fecha actual en formato dia/mes/año
                    $solicitud[0]->save();
                    $opcionvar = 0; // Establecer opción para Listar todas las Solicitudes del Cliente\
                    $FunctionsPublic->solicituduser = $FunctionsPublic->GetDataObject(11, '', $FunctionsPublic->id_cliente) ?? -1;
                    $message = 'Solicitud actualizada exitosamente.';
                    }                
            } else {
                $message = 'ID de cliente no proporcionado para edición.';
            }
            return redirect()->route('home', ['opcionvar' => $opcionvar, 'solicituduser' => $FunctionsPublic->solicituduser ?? null,'id_cliente' => $FunctionsPublic->id_cliente])->with('success', $message);
            /*return view('homepage', compact('solicituduser', 'opcionvar','id_cliente'));      */
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
  
                 $FunctionsPublic->id_solicitud = Crypt::decrypt($datos['id_solicitud'] ?? -1);
                 $FunctionsPublic->id_cliente =  Crypt::decrypt($datos['id_cliente'] ?? -1);
                 $id_cliente = $FunctionsPublic->id_cliente?? -1;
                 $FunctionsPublic->id_accion = $datos['id_accion'] ?? -1;    
                 $message = '';
                 
                if ($FunctionsPublic->id_solicitud > 0) {
                    if ($FunctionsPublic->id_accion == 1) {
                        $opcionvar = 2; // Establecer opción para edición
                        $solicituduser = $FunctionsPublic->GetDataObject(12, '', $FunctionsPublic->id_solicitud) ?? -1;
                        return view('homepage', compact('solicituduser', 'opcionvar','id_cliente'));                         
                    } elseif ($FunctionsPublic->id_accion == 2) { // Imprimir Solicitud
                        $FunctionsPublic->report_option = $datos['report_option'] ?? 0;  
                        $message = 'Función de impresión no implementada aún.';
                        return redirect()->route('solicitud.report', ['id_solicitud'=>Crypt::encrypt($FunctionsPublic->id_solicitud),'report_option' => Crypt::encrypt($FunctionsPublic->report_option),'id_cliente' => Crypt::encrypt($FunctionsPublic->id_cliente)])->with('success', $message);
                    } elseif ($FunctionsPublic->id_accion == 3) { // Eliminar Solicitud
                        $solicitud = solicitudmdl::findOrFail($FunctionsPublic->id_solicitud);
                        $solicitud->id_usercreator = Auth::user()->id ?? -1;
                        $solicitud->id_status = 2; // Establecer el estado como "eliminado" (puedes usar un valor específico para esto)
                        $solicitud->save();
                        $opcionvar = 0; // Establecer opción para Listar todas las Solicitudes del Cliente
                         $message = 'Solicitud eliminada exitosamente.';
                         $FunctionsPublic->solicituduser = $FunctionsPublic->GetDataObject(11, '', $FunctionsPublic->id_cliente) ?? -1;
                         $solicituduser = $FunctionsPublic->solicituduser;
                        return redirect()->route('home', ['opcionvar' => $opcionvar, 'solicituduser' => $FunctionsPublic->solicituduser ?? null,'id_cliente' => $FunctionsPublic->id_cliente])->with('success', $message);
                    } else {
                        $message = 'Accion no permitida para Actualizacion.';
                    }
                    
                } else {
                    $message = 'ID de solicitud no proporcionado para edición.';
                }
        } else {
            $message = 'Método HTTP no soportado para esta acción.';
        }

                
    }   
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, solicitudmdl $solicitudmdl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(solicitudmdl $solicitudmdl)
    {
        //
    }
    
   
}
