<?php

namespace App\Http\Controllers\userauth;

use App\Http\Controllers\Controller;
use App\Models\userauth\usuadatamdl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\table;

class usuadatactrl extends Controller
{
    public int $id_user = 0;
    public string $name = '';
    public string $email = '';
    public $userdata = null;
    /**
     * Display a listing of the resource.
     */
    public function index(int $opcionvar): View
    {

        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $opcionvar): View
    {
        /** $users = DB::table('usuarios.vwusuamodulos')->get();*/
        $usermodulos = DB::table('usuarios.vwusuamodulos')
                ->distinct()
                ->select(['vwusuamodulos.id_modulo', 'vwusuamodulos.modulo', 'vwusuamodulos.icon', 'vwusuamodulos.nodo', 'vwusuamodulos.pathweb', 'vwusuamodulos.id_opcion_datos'])
                ->whereNotNull('id_modulo')
                ->where('vwusuamodulos.id', '=', Auth::user()->id)
                ->orderBy('vwusuamodulos.nodo')
                ->get();        
                 return view('HomePage',  compact('usermodulos', 'opcionvar'));  


    }
    /** Los Modulos del Usuario Conectado */
    
        function getModulosSonUser(string $nodo_padre, int $id_tipo_modulo)        
         {
            if ($id_tipo_modulo == 1) {
                // Buscar descendientes
                $descendants = DB::table('usuarios.vwusuamodulos')
                    ->where('nodo', '<@', [$nodo_padre]) // Excluir el nodo padre
                    ->where('nlevel(nodo)', '>', 1) // Excluir el nodo padre
                    ->orderBy('vwusuamodulos.nodo')
                    ->get();
                    
                return $descendants;
            } elseif ($id_tipo_modulo == 2) {
                // Buscar ancestros
                $ancestors = DB::table('usuarios.vwusuamodulos')
                    ->whereRaw('nodo @> ?', [$nodo_padre] )
                    ->orderBy('vwusuamodulos.nodo')
                    ->get();
                return $ancestors;
            } else {
                return collect(); // Retorna una colección vacía si el tipo de módulo no es válido
            }
         }

        function getModulosSonUser01(string $nodo_padre, int $id_tipo_modulo)        
         {
            if ($id_tipo_modulo == 1) {
                // Buscar descendientes
                $descendants = DB::select('select * from usuarios.vwusuamodulos where nlevel(nodo) > 1 and nodo <@ ? and id = ? order by nodo asc', [$nodo_padre, Auth::user()->id]);
                return $descendants;
            } elseif ($id_tipo_modulo == 2) {
                // Buscar ancestros
                $ancestors = DB::table('usuarios.vwusuamodulos')
                    ->whereRaw('nodo @> ?', [$nodo_padre] )
                    ->orderBy('vwusuamodulos.nodo')
                    ->get();
                return $ancestors;
            } 
            else {
                return collect(); // Retorna una colección vacía si el tipo de módulo no es válido
            }
         }

         /** Data del Usuario */

        function GetDataUser()
         {
           $id_data_search = Auth::user()->id;
           $userdata = DB::table('usuarios.vwusuarios')
                ->distinct()
                ->select(['vwusuarios.id', 'vwusuarios.cedula', 'vwusuarios.nombre', 'vwusuarios.apellido', 'vwusuarios.nickname', 'vwusuarios.pass', 'vwusuarios.idpermisoreporte', 'vwusuarios.id_nivel', 'vwusuarios.activo', 'vwusuarios.id_persona',  'vwusuarios.nivel', 'vwusuarios.direccion', 'vwusuarios.telefono', 'vwusuarios.emails'])
                ->where('vwusuarios.id', '=', $id_data_search)
                ->get();
                return $userdata;    

        }


         /** Los Modulos del Usuario Conectado */
    
        function getModulosUser()
         {
            /** 
           $usermodulos = DB::table(config('usuarios.vwusuamodulos'))
                ->distinct()
                ->select(['vwusuamodulos.id_modulo', 'vwusuamodulos.modulo'])
                ->whereNotNull('id_modulo')
                ->where('vwusuamodulos.id', '=', Auth::user()->id)
                ->get();
            */                
                $usermodulos =  $users = DB::select('select * from usuarios.vwusuamodulos where id = ? and nlevel(nodo) = 1', [Auth::user()->id]);
                return $usermodulos;    

        }
       

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(usuadatamdl $usuadatamdl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, usuadatamdl $usuadatamdl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(usuadatamdl $usuadatamdl)
    {
        //
    }
}
