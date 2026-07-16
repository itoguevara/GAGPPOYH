
@php
    //dump('Hola 04',get_defined_vars(),$opcionvar);
    $opcionvar = $attributes->get('opcionvar') ?? 0;
    $recordsimpatizantes = $attributes->get('recordsimpatizantes') ?? null;

    
@endphp
    @auth <!--  Verificacion de la Autorizacion-->
    @else
        @switch($opcionvar)
            @case(0)
                <x-generic.pageini :opcionvar="$opcionvar ?? 0" :recordsimpatizante="$recordsimpatizante ?? null" :recordsimpatizantes="$recordsimpatizantes ?? null"></x-generic.pageini>
                @break

            @case(3) 
                <x-generic.quienessomos :opcionvar="$opcionvar ?? 0" :recordsimpatizante="$recordsimpatizante ?? null" :recordsimpatizantes="$recordsimpatizantes ?? null"></x-generic.quienessomos>
                @break

            @case(2) 
                <p>Tienes acceso de edición.</p>
                @break

            @default
                <p>Acceso restringido.</p>
        @endswitch
    @endauth
