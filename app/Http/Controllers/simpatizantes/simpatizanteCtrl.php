<?php


namespace App\Http\Controllers\simpatizantes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userauth\simpatizantesmdl;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class simpatizanteCtrl extends Controller
{
public $simpatizantesdata;
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
            if ($id_opcion == 0) { // Buscar simpatizante por ID
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
    public function edit(simpatizantemdl $simpatizantesmdl)
    {
        //
    }

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
