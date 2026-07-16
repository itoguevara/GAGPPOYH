@php
    //dump('Hola 03',get_defined_vars(),$opcionvar);
    $opcionvar = $opcionvar ?? 0;
    $recordsimpatizante = $recordsimpatizante ?? null;
    $recordsimpatizantes = $recordsimpatizantes ?? null;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
 
    <body >

    
   
        <div class ="Container">

           <x-layouts::app :title="__('Guayana en Positivo')" :opcionvar="0 ?? 0" :solicituduser="$solicituduser ?? null" >
            <x-generic.header :opcionvar="$opcionvar ?? 0"/> 
            @auth <!--  Verificacion de la Autorizacion-->
                <x-userauth.bodydata :opcionvar="$opcionvar ?? 0" :recordsimpatizante="$recordsimpatizante ?? null" :recordsimpatizantes="$recordsimpatizantes ?? null"></x-userauth.bodydata>
            @else
                <x-generic.bodydata :opcionvar="$opcionvar ?? 0" :recordsimpatizantes="$recordsimpatizantes ?? null"></x-generic.bodydata> 

            @endauth
            <x-generic.footer />

            </x-layouts::app>
      
        </div>                
        @livewireScripts
       <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script> 
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../../../Back/respon/lib/easing/easing.min.js"></script>
    <script src="../../../Back/respon/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="../../../Back/respon/mail/jqBootstrapValidation.min.js"></script>
    <script src="../../../Back/respon/mail/contact.js"></script>

    <!-- Template Javascript -->
     
    <script src="../../../Back/respon/js/app.js "></script> 
    <script src="../../../Back/respon/js/main.js"></script>      
    </body>
    
</html>        
