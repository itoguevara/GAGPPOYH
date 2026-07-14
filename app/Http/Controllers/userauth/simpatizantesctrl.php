<?php


namespace App\Http\Controllers\userauth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userauth\simpatizantemdl;
use Illuminate\Support\Facades\Crypt;
use PublicFunctions;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class simpatizantesctrl extends Controller
      
{
public $simpatizantesdata;
public $FunctionsPublic = null;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,int $opcionvar)
    {
        $simpatizantesdata = $request->all();

        return redirect()->route('solicitud', ['opcionvar' => $opcionvar])->with('success', 'Solicitud creada exitosamente.');
        // Obtener un dato específico
    }

    /**
     * Display the specified resource.
     */
 function GetDatasimpatizante(int $id_data_search, int $id_opcion)   
         {
            if ($id_opcion == -1) { // Buscar simpatizante por ID
                $simpatizantesdata = DB::table('militantes.vwsimpatizantes')
                     ->distinct()
                     ->select(['vwsimpatizantes.id', 'vwsimpatizantes.cedula', 'vwsimpatizantes.nombre', 'vwsimpatizantes.apellido', 'vwsimpatizantes.fec_nac', 'vwsimpatizantes.direccion','vwsimpatizantes.telefono','vwsimpatizantes.emails','vwsimpatizantes.id_status'])                     
                     ->orderBy('vwsimpatizantes.id', 'asc')
                     ->paginate(5);
                 return $simpatizantesdata;    
            } elseif ($id_opcion == 0) { // Buscar simpatizante por ID
                $simpatizantesdata = DB::table('militantes.vwsimpatizantes')
                     ->distinct()
                     ->select(['vwsimpatizantes.id', 'vwsimpatizantes.cedula', 'vwsimpatizantes.nombre', 'vwsimpatizantes.apellido', 'vwsimpatizantes.fec_nac', 'vwsimpatizantes.direccion','vwsimpatizantes.telefono','vwsimpatizantes.emails'])                     
                     ->where('vwsimpatizantes.id', '=', $id_data_search)
                     ->get();
                 return $simpatizantesdata;    
             
            } elseif ($id_opcion == 1) { // Buscar simpatizante por id de Persona
           
                $simpatizantesdata = DB::table('militantes.vwsimpatizantes')
                     ->distinct()
                     ->select(['vwsimpatizantes.id', 'vwsimpatizantes.cedula', 'vwsimpatizantes.nombre', 'vwsimpatizantes.apellido', 'vwsimpatizantes.fec_nac', 'vwsimpatizantes.direccion','vwsimpatizantes.telefono','vwsimpatizantes.emails'])                     
                     ->where('vwsimpatizantes.id_persona', '=', $id_data_search)
                     ->get();
                 return $simpatizantesdata;

            } elseif ($id_opcion == 2) { // Buscar simpatizante por cédula
                 $simpatizantesdata = DB::table('militantes.vwsimpatizantes')
                     ->distinct()
                     ->select(['vwsimpatizantes.id', 'vwsimpatizantes.cedula', 'vwsimpatizantes.nombre', 'vwsimpatizantes.apellido', 'vwsimpatizantes.fec_nac', 'vwsimpatizantes.direccion','vwsimpatizantes.telefono','vwsimpatizantes.emails'])                     
                     ->where('vwsimpatizantes.cedula', '=', $id_data_search)
                     ->get();
                 return $simpatizantesdata;    
            } elseif ($id_opcion == 3) { // Buscar simpatizante por nombre
                $simpatizantesdata = DB::table('militantes.vwsimpatizantes')
                     ->distinct()
                     ->select(['vwsimpatizantes.id', 'vwsimpatizantes.cedula', 'vwsimpatizantes.nombre', 'vwsimpatizantes.apellido', 'vwsimpatizantes.fec_nac', 'vwsimpatizantes.direccion','vwsimpatizantes.telefono','vwsimpatizantes.emails'])                     
                     ->where('vwsimpatizantes.nombre', 'like', "%$id_data_search%"       )
                     ->get();
                 return $simpatizantesdata;    
   
            } elseif ($id_opcion == 4) { // Buscar simpatizante por apellido
                $simpatizantesdata = DB::table('militantes.vwsimpatizantes')
                     ->distinct()
                     ->select(['vwsimpatizantes.id', 'vwsimpatizantes.cedula', 'vwsimpatizantes.nombre', 'vwsimpatizantes.apellido', 'vwsimpatizantes.fec_nac', 'vwsimpatizantes.direccion','vwsimpatizantes.telefono','vwsimpatizantes.emails'])                     
                      ->where('vwsimpatizantes.apellido', 'like', "%$id_data_search%")
                     ->get();
                 return $simpatizantesdata;
                
            } else {
                return collect(); // Retorna una colección vacía si el tipo de módulo no es válido
            }
         }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(simpatizantemdl $simpatizantesmdl, Request $request)
   {
     $FunctionsPublic = new PublicFunctions();
     $datos = $request->all();
                dd($datos);
    $_SERVER['REQUEST_METHOD'] === 'POST' ? $datos = $request->all() : $datos = $request->query();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_simpatizante = $datos['id_simpatizante'] ?? -1;
            $simpatizantesmdl = simpatizantemdl::find($id_simpatizante);
            if (!$simpatizantesmdl) {
                return redirect()->back()->with('error', 'Simpatizante no encontrado.');
            }
            $simpatizantesmdl->fill($datos);
            $simpatizantesmdl->save();  
            return redirect()->back()->with('success', 'Simpatizante actualizado exitosamente.');
         } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $FunctionsPublic->id_simpatizante = Crypt::decrypt($datos['id'] ?? -1);
            $FunctionsPublic->id_accion = $datos['id_accion'] ?? -1;    
            $message = '';
            if ($FunctionsPublic->id_simpatizante> 0) {
                if ($FunctionsPublic->id_accion == 1) {
                    $opcionvar = 2; // Establecer opción para edición
                    $id_simpatizante = $FunctionsPublic->id_simpatizante;
                    $recordsimpatizante = $FunctionsPublic->GetDataObject(15, '', $id_simpatizante) ?? -1;
                    session()->put('recordsimpatizante', $recordsimpatizante,false);
                    return view('home', compact('recordsimpatizante', 'opcionvar','id_simpatizante'));                         
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
                $message = 'Simpatizante no encontrado.';
            }   
            $simpatizantesmdl = simpatizantemdl::find($FunctionsPublic->id_simpatizante);
            if (!$simpatizantesmdl) {
                return redirect()->back()->with('error', 'Simpatizante no encontrado.');
            }
            return view('userauth.simpatizantes.edit', compact('simpatizantesmdl'));
        }
    }                       
     //
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, simpatizantemdl $simpatizantesmdl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(simpatizantemdl $simpatizantesmdl)
    {
        //
    }
}
