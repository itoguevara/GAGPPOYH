<flux:sidebar sticky collapsible="mobile"  class="sidebar-principal" :heading="__('Menu')">
            <flux:sidebar.nav>
                @php $RutaName = Route::currentRouteName();
   
                 @endphp
                @if($RutaName == 'home' or $RutaName == 'solicitud' or $RutaName == 'solicitud.search' or $RutaName == 'solicitud.edit' or $RutaName == 'solicitud.store' )
                    @auth
                        <flux:sidebar.group :heading="__('Opciones del Usuario')" class="grid" >
                            <flux:card class="ml-2 border-2 border-amber-100" > <!--  Etiquetas del Menu de Usuarios-->
                                <x-desktop-user-menu :opcionvar="$opcionvar ?? '0'" :id_user="auth()->user()->id ?? '0'" />  
                                
                            </flux:card>
                        </flux:sidebar.group>
                    @else    
                        <flux:sidebar.group :heading="__('Acceso a Datos')" class="grid">
                            <flux:card class="card-login"> <!--  Etiquetas del Login-->
                                <x-auth.login>  </x-auth.login>
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
