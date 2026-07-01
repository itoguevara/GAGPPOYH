<?php
use Illuminate\Support\Facades\DB;

class PublicFunctions
{
    /** Variables Publicas Generales */
    public $id_solicitud = -1;
    public $report_option = 0;
    public $id_id_persona_user = -1;
    public $id_simpatizante = -1;
    public $swi_solnew = true;
    public $id_accion = 0;
    public $nro_sol = 'SOL-0000';
    /** Variables Publicas de Registros de Tipos */
    public $recordsimpatizante = null;
    public $recordinteresados = null;
    public $tiposolicitud = null; // Variable para almacenar registros de Tipo de Solicitud
    public $recordtipodirtemail = null; // Variable para almacenar registros de Tipo de Direccion/Telefono/Email
    public $recordnacionalidad = null; // Variable para almacenar registros de Nacionalidad
    public $recordpais = null; // Variable para almacenar registros de Pais
    public $recordestado = null; // Variable para almacenar registros de Estado
    public $recordmunicipio = null; // Variable para almacenar registros de Municipio
    public $recordciudad = null; // Variable para almacenar registros de Ciudad
    public $recordempresa = null; // Variable para almacenar los Datos de la Empresa
    public $recordtipopersona= null; // Variable para almacenar registros de Tipo de personas
    public $recordstatus = null; // Variable para almacenar registros de Status de las solicitudes
    public $recordstatusconfirmacion    = null; // Variable para almacenar registros de Status de las solicitudes


    
    public function __construct()
    {
        // Constructor vacío, no se necesita inicialización
    }
    public static function CargaInicialDataRecord(){
        $id_persona_user = app()->call('App\Http\Controllers\userauth\usuadatactrl@GetDataUser')->first()->id_persona ?? null;
        $recordsimpatizante = app()->call('App\Http\Controllers\simpatizantes\simpatizanteCtrl@GetDatasimpatizante', ['id_data_search' => $id_persona_user, 'id_opcion' => 1]);    
        session(['recordstatus' => PublicFunctions::GetDataObject(-1,'',-1)]); // Ejemplo de uso de sesión para almacenar Los Datos del Status de las Solicitudes
        session(['recordstatusconfirmacion' => PublicFunctions::GetDataObject(1,'',-1)]); // Ejemplo de uso de sesión para almacenar Los Datos del Status de Confirmación de las Solicitudes
        session(['recordempresa' => PublicFunctions::GetDataObject(14,'',-1)]); // Ejemplo de uso de sesión para almacenar Los Datos de la Empresa
        session(['recordcliente' => PublicFunctions::GetDataObject(15,'',-1)]); // Ejemplo de uso de sesión para almacenar Los Datos del Cliente
        session(['id_persona_user' => $id_persona_user ?? -1]); // Ejemplo de uso de sesión para almacenar id de la Persona del usuario Activo
        session(['id_simpatizante' => $recordsimpatizante[0]->id_simpatizante ?? -1]); // Ejemplo de uso de sesión para almacenar Los Datos del Simpatizante
        session(['recordtipopersona' => PublicFunctions::GetDataObject(1,'',-1)]); // Ejemplo de uso de sesión para almacenar Los Datos del Tipo de Persona
        session(['tiposolicitud' => PublicFunctions::GetDataObject(9,'',-1)]); // Ejemplo de uso de sesión para almacenar Los Datos del Tipo de Solicitud

    }


   public static function GetNextNroSol()
    {
        $lastNroSol = DB::table('militantes.solicitud')
            ->select('nro_sol')
            ->orderByDesc('id')
            ->first();

        if ($lastNroSol && preg_match('/SO-(\d{5})/', $lastNroSol->nro_sol, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
            return 'SO-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        } else {
            return 'SO-00001'; // Valor inicial si no hay registros
        }
    }   

// Función para obtener un objeto de datos según el ID de opción proporcionado

public static function GetDataObject(int $id_opcion_search, string $search_term = '', int $id_search = -1)
    {
        
    switch ($id_opcion_search) {
        case -1:  // Buscar Status
            $recorddataobject = DB::table('configuracion.tblstatus')
                            ->distinct()
                            ->select(['tblstatus.id', 'tblstatus.descripcion'])
                            ->whereNotNull('tblstatus.id')
                            ->where('tblstatus.id', '>', 0)
                            ->orderBy('tblstatus.descripcion')
                            ->get();  
            break;
        
        case 0:  // Buscar Status
            $recorddataobject = DB::table('militantes.status_confirmacion')
                            ->distinct()
                            ->select(['status_confirmacion.id', 'status_confirmacion.descripcion'])
                            ->whereNotNull('status_confirmacion.id')
                            ->where('status_confirmacion.id', '>', 0)
                            ->orderBy('status_confirmacion.descripcion')
                            ->get();  
            break;
        case 1:  // Buscar Tipos de Personas
            $recorddataobject = DB::table('datacenter.tipo_persona')
                            ->distinct()
                            ->select(['tipo_persona.id', 'tipo_persona.descripcion'])
                            ->whereNotNull('tipo_persona.id')
                            ->where('tipo_persona.id', '>', 0)
                            ->orderBy('tipo_persona.descripcion')
                            ->get();  
            break;
        case 2: // Buscar tipos de direcciones/Emails/Telefonos
            $recorddataobject = DB::table('datacenter.tipo_dir_telf_email')
                            ->distinct()
                            ->select(['tipo_dir_telf_email.id', 'tipo_dir_telf_email.nombre'])
                            ->whereNotNull('tipo_dir_telf_email.id')
                            ->where('tipo_dir_telf_email.id', '>', 0)
                            ->orderBy('tipo_dir_telf_email  .nombre')
                            ->get();
            break;
        case 3: // Buscar profesiones
            $recorddataobject = DB::table('datacenter.profesion')
                            ->distinct()
                            ->select(['profesion.id', 'profesion.nombre'])
                            ->whereNotNull('profesion.id')
                            ->where('profesion.id', '>', 0)
                            ->orderBy('profesion.nombre')
                            ->get();
            break;
        case 4: // Buscar Ocupaciones
            $recorddataobject = DB::table('datacenter.ocupacion')
                            ->distinct()
                            ->select(['ocupacion.id', 'ocupacion.descripcion'])
                            ->whereNotNull('ocupacion.id')
                            ->where('ocupacion.id', '>', 0)
                            ->orderBy('ocupacion.descripcion')
                            ->get();
            break;
        case 5: // Buscar nacionalidades
            $recorddataobject = DB::table('datacenter.nacionalidad')
                            ->distinct()
                            ->select(['nacionalidad.id', 'nacionalidad.nombre'])
                            ->whereNotNull('nacionalidad.id')
                            ->where('nacionalidad.id', '>', 0)
                            ->orderBy('nacionalidad.nombre')
                            ->get();
            break;
        case 6: // Buscar Paises
            $recorddataobject = DB::table('datacenter.pais')
                            ->distinct()
                            ->select(['pais.id', 'pais.nombre', 'pais.codigo_telefonico', 'pais.gentilicio'])
                            ->whereNotNull('pais.id')
                            ->where('pais.id', '>', 0)
                            ->orderBy('pais.nombre')
                            ->get();
            break;
        case 6: // Buscar estados
            $recorddataobject = DB::table('datacenter.estado')
                            ->distinct()
                            ->select(['estado.id', 'estado.nombre', 'estado.codigo_iso', 'estado.id_pais'])
                            ->whereNotNull('estado.id')
                            ->where('estado.id', '>', 0)
                            ->orderBy('estado.nombre')
                            ->get();
            break;                    
        case 7: // Buscar Municipios
            $recorddataobject = DB::table('datacenter.municipio')
                            ->distinct()
                            ->select(['municipio.id', 'municipio.nombre', 'municipio.id_estado'])
                            ->whereNotNull('municipio.id')
                            ->where('municipio.id', '>', 0)
                            ->orderBy('municipio.nombre')
                            ->get();
            break;
        case 8: // Buscar Ciudades
            $recorddataobject = DB::table('datacenter.ciudad')
                            ->distinct()
                            ->select(['ciudad.id', 'ciudad.nombre', 'ciudad.id_municipio'])
                            ->whereNotNull('ciudad.id')
                            ->where('ciudad.id', '>', 0)
                            ->orderBy('ciudad.nombre')
                            ->get();
            break; 
        case 9: // Tipo de Solicitud    
            $recorddataobject = DB::table('militantes.tipo_solicitud')
                            ->distinct()
                            ->select(['tipo_solicitud.id', 'tipo_solicitud.descripcion'])
                            ->whereNotNull('tipo_solicitud.id')
                            ->where('tipo_solicitud.id', '>', 0)
                            ->orderBy('tipo_solicitud.descripcion')
                            ->get();
            break;                         
        case 10: // Solicitud Por Nro. de Solicitud
            $recorddataobject = DB::table('tramitesconsulares.solicitud')
                            ->distinct()
                            ->select(['solicitud.id', 'solicitud.nro_sol'])
                            ->whereNotNull('solicitud.id')
                            ->where('solicitud.nro_sol', '=', $search_term)
                            ->orderBy('solicitud.nro_sol')
                            ->paginate(20);
            break;
        case 11: // Solicitudes del Usuario Logeado
            $recorddataobject = DB::table('tramitesconsulares.vwsolicitudes')
                            ->distinct()
                            ->select(['vwsolicitudes.id', 'vwsolicitudes.nro_sol', 'vwsolicitudes.fecha', 'vwsolicitudes.id_cliente', 'vwsolicitudes.cedula', 'vwsolicitudes.cliente', 'vwsolicitudes.id_tipo_sol', 'vwsolicitudes.tipo_sol', 'vwsolicitudes.observacion', 'vwsolicitudes.id_status', 'vwsolicitudes.status'])
                            ->whereNotNull('vwsolicitudes.id')
                            ->where('vwsolicitudes.id_cliente', '=', $id_search)
                            ->orderBy('vwsolicitudes.nro_sol')
                            ->paginate(5);
            break;
        case 12: // Solicitudes por id de la solicitud
            $recorddataobject = DB::table('tramitesconsulares.vwsolicitudes')
                            ->distinct()
                            ->select(['vwsolicitudes.id', 'vwsolicitudes.nro_sol', 'vwsolicitudes.fecha', 'vwsolicitudes.id_cliente', 'vwsolicitudes.cedula', 'vwsolicitudes.cliente', 'vwsolicitudes.id_tipo_sol', 'vwsolicitudes.tipo_sol', 'vwsolicitudes.observacion', 'vwsolicitudes.id_status', 'vwsolicitudes.status'])
                            ->whereNotNull('vwsolicitudes.id')
                            ->where('vwsolicitudes.id', '=', $id_search)
                            ->orderBy('vwsolicitudes.nro_sol')
                            ->paginate(20);
                            break;
        case 13: // Tidpo Documentos
            $recorddataobject = DB::table('tramitesconsulares.tipo_documentos')
                            ->distinct()
                            ->select(['tipo_documentos.id', 'tipo_documentos.descripcion'])
                            ->whereNotNull('tipo_documentos.id')
                            ->where('tipo_documentos.id', '>', 0)
                            ->orderBy('tipo_documentos.descripcion')
                            ->paginate(20);
            break;              
        case 14: // Datos de la Empresa
            $recorddataobject = DB::table('configuracion.vwempresa')
                            ->distinct()
                            ->select(['id_empresa', 'razonsocial', 'docfiscal', 'representante', 'direccionfiscal', 'emails', 'telefono'])
                            ->whereNotNull('vwempresa.id_empresa')
                            ->where('vwempresa.id_empresa', '>', 0)
                            ->orderBy('vwempresa.id_empresa')
                            ->get();
            break;              
        case 15: // Datos del Simpatizante
            $recorddataobject = DB::table('militantes.vwsimpatizantes')
                            ->distinct()
                            ->select(['id', 'id_persona', 'cedula','nombre', 'apellido', 'direccion', 'telefono', 'emails'])
                            ->whereNotNull('vwsimpatizantes.id_persona')
                            ->where('vwsimpatizantes.id', '>', 0)
                            ->where('vwsimpatizantes.id', '=', session('id_simpatizante'))
                            ->orderBy('vwsimpatizantes.id')
                            ->get();
            break;              
        case 16:  // Buscar Tipos de Parentescos entre Personas
            $recorddataobject = DB::table('datacenter.tipo_parentesco')
                            ->distinct()
                            ->select(['tipo_parentesco.id', 'tipo_parentesco.descripcion', 'tipo_parentesco.letra'])
                            ->whereNotNull('tipo_parentesco.id')
                            ->where('tipo_parentesco.id', '>', 0)
                            ->orderBy('tipo_parentesco.descripcion')
                            ->get();  
            break;
        case 17:  // Buscar Tipos de Profesiones
            $recorddataobject = DB::table('datacenter.profesion')
                            ->distinct()
                            ->select(['profesion.id', 'profesion.nombre'])
                            ->whereNotNull('profesion.id')
                            ->where('profesion.id', '>', 0)
                            ->orderBy('profesion.nombre')
                            ->get();  
            break;
        case 18:  // Buscar Tipos de Ocupaciones
            $recorddataobject = DB::table('datacenter.ocupacion')
                            ->distinct()
                            ->select(['ocupacion.id', 'ocupacion.descripcion'])
                            ->whereNotNull('ocupacion.id')
                            ->where('ocupacion.id', '>', 0)
                            ->orderBy('ocupacion.descripcion')
                            ->get();  
            break;
        case 19:  // Buscar Tipos de Grados de Instruccion
            $recorddataobject = DB::table('datacenter.tipo_gradoinstruccion')
                            ->distinct()
                            ->select(['tipo_gradoinstruccion.id', 'tipo_gradoinstruccion.descripcion', 'tipo_gradoinstruccion.letra'])
                            ->whereNotNull('tipo_gradoinstruccion.id')
                            ->where('tipo_gradoinstruccion.id', '>', 0)
                            ->orderBy('tipo_gradoinstruccion.id')
                            ->get();  
            break;
        case 20: // Parentesco por id
            $recorddataobject = DB::table('datacenter.tipo_parentesco')
                            ->distinct()
                            ->select(['tipo_parentesco.id', 'tipo_parentesco.descripcion', 'tipo_parentesco.letra'])
                            ->whereNotNull('tipo_parentesco.id')
                            ->where('tipo_parentesco.id', '=', $id_search)
                            ->orderBy('tipo_parentesco.descripcion')
                            ->get();  
            break;            
        case 21: // Grado de Instruccion por id
            $recorddataobject = DB::table('datacenter.tipo_gradoinstruccion')
                            ->distinct()
                            ->select(['tipo_gradoinstruccion.id', 'tipo_gradoinstruccion.descripcion', 'tipo_gradoinstruccion.letra'])
                            ->whereNotNull('tipo_gradoinstruccion.id')
                            ->where('tipo_gradoinstruccion.id', '=', $id_search)
                            ->orderBy('tipo_gradoinstruccion.id')
                            ->get();  
            break;            

        default:
            $recorddataobject = null; // O manejar el caso de opción no válida
    }
    return $recorddataobject;
    }      


// Función para obtener un modelo específico según el ID proporcionado
    public static function GetDataModel($id)
    {
        $dataModel = null;
        switch ($id) {
            case 1:
                $dataModel = new \App\Models\datacenter\personasmdl();
                break;
            case 2:
                $dataModel = new \App\Models\userauth\solicitudmdl();
                break;
            case 3:
                $dataModel   = new \App\Models\userauth\usuadatamdl();
                break;
            default:
                // Manejar el caso en que el ID no coincide con ningún modelo
                throw new \InvalidArgumentException("ID de modelo no válido: " . $id);
        }
        return $dataModel;
    }
}