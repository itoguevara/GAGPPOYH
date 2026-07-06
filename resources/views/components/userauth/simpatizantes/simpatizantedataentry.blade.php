@php
    
    $opcionvar = $attributes->get('opcionvar') ?? '-1';
    $recordsimpatizante = session('recordsimpatizante') ?? [];   
    $id_simpatizante = $recordsimpatizante[0]->id ?? '-1';
    if ($id_simpatizante != '-1') {
        $swi_solnew = false;
    } else {
        $swi_solnew = true;
    }
    $recordtipopersona = session('recordtipopersona') ?? []; 
    $tiposolicitud = session('tiposolicitud') ?? [];
    $recordstatusconfirmacion = session('recordstatusconfirmacion') ?? [];
@endphp

<div>    
    <form method="POST" action="{{ route('simpatizante.store',['opcionvar' => $opcionvar]) }}" class="flex flex-col gap-6">
    @csrf
        <flux:card class="space-y-6">
            <div>
                <flux:heading size="xl">Ingreso de Solicitud de Interesados</flux:heading>
                <flux:text class="mt-2">Por favor, llene el formulario de Datos Para procesar su solicitud</flux:text>
            </div>
            <div><flux:heading size="lg">Datos del Simpatizante</flux:heading></div>
            <input type="hidden" name="id_cliente" value="{{ $clientesdata[0]->id_clienteempre ?? '-1' }}">
            <div class="data-entry">
                <div class="col-span-1">
                    <flux:label>Documento de Identidad</flux:label>
                    <flux:description>Tipos de Documentos de Identidad</flux:description>
                    <flux:select readonly wire:model="tipoper" placeholder="Tipo de Documentos." >
                        @forelse ($recordtipopersona  as $tipopersona)
                            <flux:select.option value="{{ $tipopersona->id }}">{{ $tipopersona->descripcion }}</flux:select.option>
                        @empty
                            <flux:select.option disabled>No hay tipos de documentos disponibles</flux:select.option>
                        @endforelse
                    </flux:select>
                    <flux:error name="tipodoc" />
                </div>
                <div class="col-span-1">
                    <flux:field required >
                        <flux:label>Documento de Identidad</flux:label>
                        <flux:description>Nro. CI/DNI Usuario Solicitante</flux:description>
                        <flux:input readonly name="userdoc" value="{{ $clientesdata[0]->cedula ?? 'V-99999999' }}"/>
                        <flux:error name="userdoc" />
                    </flux:field>
                </div>
                <div class="col-span-1">
                    <flux:field  required >
                        <flux:label>Nombre</flux:label>
                        <flux:description>Nombre del Usuario Solicitante</flux:description>
                        <flux:input readonly name="username" value="{{ $clientesdata[0]->nombre ?? '' }}"/>
                        <flux:error name="username" />
                    </flux:field>
                </div>    
                <div class="col-span-1">
                    <flux:field  required >
                        <flux:label>Apellidos</flux:label>
                        <flux:description>Apellidos del Usuario Solicitante</flux:description>
                        <flux:input readonly name="userape" value="{{ $clientesdata[0]->apellido ?? '' }} "/>
                        <flux:error name="userape" />
                    </flux:field>
                </div>
                <div class="col-span-1">
                    <flux:field  required >
                        <flux:label>Correo Electronico</flux:label>
                        <flux:description>Usuario Solicitante</flux:description>
                        <flux:input readonly type="email" name="useremail" value="{{ $clientesdata[0]->emails ?? '' }}"/>
                        <flux:error name="useremail" />
                    </flux:field>
                </div>   
                <div class="col-span-1">
                    <flux:field  required >
                        <flux:label>Telefono</flux:label>
                        <flux:description>Telefono del Usuario Solicitante</flux:description>
                        <flux:input readonly type="phone" placeholder="(555) 555-5555" mask="(999) 999-9999" name="usertel" value="{{ $clientesdata[0]->telefono ?? '' }}"/>
                        <flux:error name="usertel" />
                           
                    </flux:field>
                </div>
                <div class="col-span-4">
                    <flux:field  required >
                        <flux:label>Dirección</flux:label>
                        <flux:description>Dirección del Usuario Solicitante</flux:description>
                        <flux:input readonly name="userdir" value="{{ $clientesdata[0]->direccion ?? '' }}"/>
                        <flux:error name="userdir" />
                    </flux:field>
                </div>        
            </div>
        </flux:card>    
        <flux:card class="space-y-6">
            <div><flux:heading size="lg">Datos de la Solicitud</flux:heading></div>
            <div class="data-entry">
                <div class="col-span-0">
                    <flux:field  required >
                        <flux:label>Numero de Solicitud</flux:label>
                        <flux:description>Nro. de Solicitud</flux:description>
                        <flux:input readonly name="nro_sol" value="{{ PublicFunctions::GetNextNroSol() }}"/>
                        <flux:error name="nro_sol" />
                    </flux:field>
                </div>
                <div class="col-span-1">
                    <flux:field >
                        <flux:label>Fecha de Solicitud</flux:label>
                        <flux:description>Fecha de Solicitud</flux:description>
                        <flux:input required type="date" name="fecha"/>
                        <flux:error name="fecha" />
                    </flux:field>
                </div>
                <div class="col-span-1">
                    <flux:label>Tipo de Solicitud</flux:label>
                    <flux:description>Tipos de documento a Tramitar en su Solicitud</flux:description>                    
                    <flux:select required readonly wire:model="id_tipo_sol" placeholder="Tipo de Solicitud." >
                        @forelse ($tiposolicitud as $tiposol)
                            <flux:select.option value="{{ $tiposol->id }}">{{ $tiposol->descripcion }}</flux:select.option>
                        @empty
                            <flux:select.option value="">No hay tipos de solicitud disponibles</flux:select.option>
                        @endforelse
                    </flux:select>
                    <flux:error name="id_tipo_sol" />
                </div>
                <div class="col-span-1">
                    <flux:label>Status</flux:label>
                    <flux:description>Status del procesamiento de la solicitud</flux:description>
                    <flux:select required readonly wire:model="id_status" placeholder="Status." >
                        @forelse ($recordstatusconfirmacion as $statusdoc)
                            <flux:select.option value="{{ $statusdoc->id }}">{{ $statusdoc->descripcion }}</flux:select.option>
                        @empty
                            <flux:select.option value="">No hay status disponibles</flux:select.option>
                        @endforelse
                    </flux:select>
                    <flux:error name="id_status " />
                </div>
                <div class="col-span-4">
                    <flux:field  required >
                        <flux:label>Observaciones</flux:label>
                        <flux:description>Observaciones de la Solicitud</flux:description>
                        <flux:input name="observacion" value="Solicitud Creada desde Portal Web."/>
                        <flux:error name="observacion" />
                    </flux:field>
            </div>
        </flux:card>
        
        <div class="button-group-button">
            <flux:menu.radio.group>
                <flux:menu.item
                    as="button"
                    type="submit"
                    name="save"
                    value="save"
                    icon=""
                    class="button-accion button-accion-save"
                    data-test="save-button"
                >
                </flux:menu.item>
            </flux:menu.radio.group>
            <flux:menu.radio.group>
                <flux:menu.item
                    as="button"
                    type="submit"
                    name="delete"
                    value="delete"
                    icon=""
                    class="button-accion button-accion-delete"
                    data-test="delete-button"
                >
                </flux:menu.item>
            </flux:menu.radio.group>
            <flux:menu.radio.group>
                <flux:menu.item
                    as="button"
                    type="submit"
                    name="exit"
                    value="exit"
                    icon=""
                    class="button-accion button-accion-exit"
                    data-test="exit-button"
                >
                </flux:menu.item>
            </flux:menu.radio.group>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
     </form>

</div>