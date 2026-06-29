<div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
            <flux:avatar
                :name="auth()->user()->name"
                :initials="auth()->user()->initials()"
            />
            <div class="grid flex-1 text-start text-sm leading-tight">
                <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
            </div>
        </div>
        <!--  Consulta de Modulos del Usuario-->
        @php $modulosuser = app('App\Http\Controllers\userauth\usuadatactrl')->getModulosUser(); @endphp 
         <flux:separator />
       <flux:sidebar.nav class="user-menu">
            @forelse ($modulosuser as $modulo)
                @php $modulosSonuser = app('App\Http\Controllers\userauth\usuadatactrl')->getModulosSonUser01($modulo->nodo, 1); @endphp 
                    @if(count($modulosSonuser) > 0)
                        <flux:sidebar.group  heading="{{ $modulo->modulo }}" icon="{{ $modulo->icon }}" class="grid" target="_blank">
                             @foreach ($modulosSonuser as $moduloHijo)
                                @php
                                    $ruta = route($moduloHijo->pathweb, ['opcionvar' => $moduloHijo->id_opcion_datos]);
                                @endphp
                               <flux:sidebar.item  class="user-menu-item" href="{{ $ruta }}"  icon="{{ $moduloHijo->icon }}">{{ $moduloHijo->modulo }}</flux:sidebar.item> 
                            @endforeach
                        </flux:sidebar.group>
                    @else
                        @php
                            $ruta = route($modulo->pathweb, ['opcionvar' => $modulo->id_opcion_datos]);
                        @endphp
                        <flux:sidebar.item class="user-menu-item" href="{{ $ruta }}" icon="{{ $modulo->icon }}">{{ $modulo->modulo }}</flux:sidebar.item>
                    @endif
            @empty
                <p>No modules</p>
            @endforelse
        </flux:sidebar.nav>
        <flux:separator />
        <div class="px-1 py-1.5">
            <form method="POST" action="{{ route('logout') }}" class="boton-session-item">
                @csrf
                <flux:menu.item 
                    as="button"
                    type="submit"
                    icon=""
                    class="boton-session"
                    data-test="logout-button"
                    position="center"
                >
                  </flux:menu.item>
            </form>
        </div>


