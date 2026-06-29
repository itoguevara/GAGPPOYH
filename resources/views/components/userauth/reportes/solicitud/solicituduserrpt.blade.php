@php
use Illuminate\Support\Carbon;
$clientesdata = session('clientesdata');
//dd($clientesdata);
@endphp
<html>
<x-userauth.reportes.headerrpt></x-userauth.reportes.headerrpt> 
<body>
<header>
        <div>
            <flux:brand href="#" logo="../public/Back/images/LogoWebFinalNegro.png"  class="logo-rpt" />
        </div>
        <div class="header-rpt-titulo">
            <strong><a>{{ $titulo}}</a></strong>
        </div>
        <div class="header-rpt-fecha">
            <a class="date">{{ 'Fecha : '.Carbon::now()->isoFormat('LL')}}</a><br>
            <a class="time">{{ 'Hora : '.now()->format('h:i A')}}</a>
        </div>    
</header>
<main>
<div class="div-table-solicitud">
        <flux:card class="card-data-cliente">
            <flux:heading  size="xl">Datos del Cliente</flux:heading>
           <table width="100%"> 
                <tbody>
                    <tr>
                        <td style="width:20%;"><strong><a>Cedula : </a></strong></td>
                        <td style="width:20%;"><strong><a>Nombre : </a></strong></td>
                        <td style="width:20%;"><strong><a>Apellidos  : </a></strong></td>
                        <td style="width:20%;"><strong><a>Correo Electronico : </a></strong></td>
                        <td style="width:20%;"><strong><a>Telefono : </a></strong></td>
                    </tr>
                    <tr>
                        <td class="col-span-1"><a>{{trim($clientesdata[0]->cedula)}}</a></td>
                        <td class="col-span-1"><a>{{trim($clientesdata[0]->nombre)}}</a></td>
                        <td class="col-span-1"><a>{{trim($clientesdata[0]->apellido)}}</a></td>
                        <td class="col-span-1"><a>{{trim($clientesdata[0]->emails)}}</a></td>
                        <td class="col-span-1"><a>{{trim($clientesdata[0]->telefono)}}</a></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-center"><a>Dirección : {{trim($clientesdata[0]->direccion)}}</a></td>
                     </tr>
                </tbody>
            </table>            
        </flux:card>    

    <table width="100%" class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
        <thead class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:text-on-surface-dark-strong" style="background-color:darkgray">
            <tr>
                <th scope="col" class="p-1">Numero Solicitud</th>
                <th scope="col" class="p-1">Fecha</th>
                <th scope="col" class="p-1">Tipo</th>
                <th scope="col" class="p-1">Observación</th>
                <th scope="col" class="p-1">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-outline dark:divide-outline-dark">
            @foreach ($solicituduser as $solicitud)
                @if ($solicitud->id_status == 2) 
                    <tr class="bg-red-100 dark:bg-red-900/20">
                @else
                    <tr class="bg-green-100 dark:bg-green-900/20">
                @endif
                    <td class="p-1">{{ $solicitud->nro_sol }}</td>
                    <td class="p-1">{{ $solicitud->fecha }}</td>
                    <td class="p-1">{{ $solicitud->tipo_sol }}</td>
                    <td class="p-1">{{ $solicitud->observacion }}</td>
                    <td class="p-1">{{ $solicitud->status }}</td>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</main>

<footer>
    <strong><a>{{ session('recordempresa')[0]->direccionfiscal}}</a></strong>
</footer>
</body>
</html>