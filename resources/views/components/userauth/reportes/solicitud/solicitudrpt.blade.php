@php
use Illuminate\Support\Carbon;
// Datos de la Empresa

$razonsocial = session('recordempresa')[0]->razonsocial;
$docfiscal = session('recordempresa')[0]->docfiscal;
$direccionfiscal = session('recordempresa')[0]->direccionfiscal;
$emails = session('recordempresa')[0]->emails;
$telefono= session('recordempresa')[0]->telefono;
$representante= session('recordempresa')[0]->representante;
// Datos del Cliente
$cliente = session('clientesdata')[0]->nombre.' '.session('clientesdata')[0]->apellido;
$clienteced = session('clientesdata')[0]->cedula;
$clientedire = session('clientesdata')[0]->direccion;
$clientetelf = session('clientesdata')[0]->telefono;
$clienteemails = session('clientesdata')[0]->emails;
// Datos de la Solicitud
//dd(get_defined_vars(),$solicituduser[0]->cliente,session('recordempresa'));
$nro_sol = $solicituduser[0]->nro_sol;
$fecha_sol = $solicituduser[0]->fecha;
$tipo_sol = $solicituduser[0]->tipo_sol;
$status_sol = $solicituduser[0]->status;

   //dd(get_defined_vars(),$solicituduser[0]->cliente,session('recordempresa'));
     
@endphp


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
 <body>
    <div >
        <header>
            <address style="text-align: right;">
                <strong>{{$razonsocial}}</strong><br>
                {{$docfiscal}}<br>
                {{$direccionfiscal}}<br>
                {{$telefono.' - '.$emails}}
            </address>
            <p class="date"> {{ 'Fecha : '.Carbon::now()->isoFormat('LL');}}</p>
        </header>

    </div>    
    <div>
        <p><strong>Destinatario:</strong><br>
        {{$cliente}}<br>
        {{$clienteced}}<br>
        {{$clientedire}}<br>
        {{$clientetelf}}<br>
        {{$clienteemails}}</p>
    </div> 
    <div>     
        <p><strong>Asunto: Respuesta a Solicitud Nro : {{ $nro_sol}} </strong><br></p>
    </div>
   <div>
        <article>

        <h3>Estimado/a Cliente:</h3>

        <p>Mediante el presente le informo que su solicitud de fecha <b>{{$fecha_sol}}</b>, correspondiente a <b>{{$tipo_sol}}</b> ha sido <b>{{$status_sol}}</b>
        Proximamente le haremos llegar a su correo electronico <strong>{{$clienteemails}}</strong>, Los documentos que avalan la desicion tomada por el
        consulado donde se ha tramitado sus solicitud.
        

        <p><small>Atentamente,</small></p>  

        </article>
        
   </div>
   <div class="signature">
      <p>____________________<br>
      <strong>Firma</strong><br>
       {{$representante}}</p>
   </div   

    <div>
                <p><small><mark>Nota: Cualquier Observacion Estamos a sus ordenes</mark></small></p>    

   </div>
</body>
    
</html>  