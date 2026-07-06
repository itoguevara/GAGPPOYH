<div>
  @php

    $opcionvar = $attributes->get('opcionvar') ?? 0;
    $recordsimpatizantes = $attributes->get('recordsimpatizantes') ?? null;
    $id_data_search = $recordsimpatizantes[0]->id_cliente  ?? -1;
    $recordsimpatizante = app()->call('App\Http\Controllers\userauth\Simpatizantesctrl@GetDatasimpatizante', ['id_data_search' => $id_data_search, 'id_opcion' => 1]);    
    $FunctionsPublic = new PublicFunctions();
    $FunctionsPublic->CargaInicialDataRecord();
  
@endphp

          
<!-- Dependiendo de la opcion que se elija en el menu, se mostrara un contenido diferente, 
    se evalua la variable $opcionvar y se muestra el contenido correspondiente a cada caso.   -->
    @switch($opcionvar)
        @case(1) <!--  En este caso se muestra el formulario de solicitud de tramites consulares, el cual es un componente de blade que se encuentra en resources/views/components/userauth/tcsolicitud.blade.php -->
            <x-userauth.reportes.simpatizantes.simpasearchrpt :opcionvar="$opcionvar ?? 1" :recordsimpatizantes="$recordsimpatizantes ?? null" :id_simpatizante="'-1'"/>
             @break
        @case(2) <!--  En este caso se muestra el formulario de edición de solicitud de tramites consulares, el cual es un componente de blade que se encuentra en resources/views/components/userauth/tcsolicitudedit.blade.php -->            
            @break
        @default
    @endswitch


</div>