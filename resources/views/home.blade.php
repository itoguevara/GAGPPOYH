
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
 
    <body >
        
        <x-layouts::app :title="__('Guayana Productiva en Positivo')" :opcionvar="0 ?? 0" :solicituduser="$solicituduser ?? null" class="layout-app">
            <x-generic.header />   
            @auth <!--  Verificacion de la Autorizacion-->
            @php
                $opcionvar = 1 ?? 0;
                $recordsimpatizantes = $recordsimpatizantes ?? null;
            @endphp
                <x-userauth.bodydata :opcionvar="1 ?? 0" :recordsimpatizantes="$recordsimpatizantes ?? null"></x-userauth.bodydata>
            @else
                <flux:separator />
                <x-generic.bodydata :opcionvar="0 ?? 0" :recordsimpatizantes="$recordsimpatizantes ?? null"></x-generic.bodydata> 

            @endauth
            <x-generic.footer />           
        </x-layouts::app>
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
