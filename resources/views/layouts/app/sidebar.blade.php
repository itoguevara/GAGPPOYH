<flux:sidebar sticky collapsible="mobile"  class="sidebar-principal" :heading="__('Menu')">
    <flux:sidebar.nav>
        @php $RutaName = Route::currentRouteName();
            @endphp
        @if($RutaName == 'home' or $RutaName == 'simpatizante' or $RutaName == 'simpatizante.search' or $RutaName == 'simpatizante.edit' or $RutaName == 'simpatizante.store' )
            @auth
                        
            <flux:sidebar.group :heading="__('Opciones del Usuario')" class="grid" >
                <flux:card class="card-login" > <!--  Etiquetas del Menu de Usuarios-->
                    <x-desktop-user-menu :opcionvar="$opcionvar ?? '0'" :id_user="auth()->user()->id ?? '0'" />  
                </flux:card>
            </flux:sidebar.group>
            @else    
                <flux:sidebar.group :heading="__('Acceso a Datos')" class="grid">
                    <flux:card class="card-login"> <!--  Etiquetas del Login-->
                        <x-auth.login  :opcionvar="$opcionvar ?? '0'">  </x-auth.login>
                    </flux:card>
                </flux:sidebar.group>
            @endauth
            <flux:separator />
        @else
        @endif 
        
    </flux:sidebar.nav>

    </flux:sidebar>

    {{ $slot }}

    @fluxScripts
