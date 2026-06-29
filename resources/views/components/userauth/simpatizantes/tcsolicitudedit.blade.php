    @php
        $opcionvar = $attributes->get('opcionvar') ?? '0';
        $solicituduser = $attributes->get('solicituduser') ?? null;
        $clientesdata = $attributes->get('clientesdata') ?? null;
        // Buscar Datos para CombosBox
        $status = PublicFunctions::GetDataObject(0);
        $tipodocs = PublicFunctions::GetDataObject(1);
        $tiposolicitud = PublicFunctions::GetDataObject(9);        
    @endphp
<div>    

        <flux:card class="space-y-6">
            <div>
                <flux:heading size="xl">Edición de Solicitud de Tramites Consulares</flux:heading>
                <flux:text class="mt-2">Por favor, revise y modifique los datos de su solicitud de tramites consulares</flux:text>
            </div>
            <div><flux:heading size="lg">Datos del Cliente</flux:heading></div>
            <input type="hidden" name="id_cliente" value="{{ $clientesdata[0]->id_clienteempre ?? '-1' }}">
            <div class="data-entry">
                <div class="col-span-1">
                    <flux:field required >
                        <flux:label>Documento de Identidad</flux:label>
                        <flux:description>Nro. CI/DNI Usuario Solicitante</flux:description>
                        <flux:input readonly name="userdoc" value="{{ $clientesdata[0]->id_clienteempre ?? 'V-99999999' }}"/>
                        <flux:error name="userdoc" />
                    </flux:field>
                </div>
                <div class="col-span-1">
                    <flux:label>Documento de Identidad</flux:label>
                    <flux:description>Tipos de Documentos de Identidad</flux:description>
                    <flux:select readonly wire:model="tipodoc" placeholder="Tipo de Documentos." >
                      <flux:select.option value=""></flux:select.option>
                    </flux:select>
                    <flux:error name="tipodoc" />
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
                        <flux:input readonly name="userphone" value="{{ $clientesdata[0]->telefono ?? '' }}"/>
                        <flux:error name="userphone" />
                    </flux:field>
                </div>   
            </div>
        </flux:card>
    <form method="POST" action="{{ route('solicitud.edit',['opcionvar' => $opcionvar, 'clientesdata' => $clientesdata, 'solicituduser' => $solicituduser]) }}" class="flex flex-col gap-6">
    @csrf        
        <flux:card class="space-y-6">
            <div><flux:heading size="lg">Datos de la Solicitud</flux:heading></div>
            <div class="data-entry">
                <div class="col-span-0">
                    <flux:field  required >
                        <flux:label>Numero de Solicitud</flux:label>
                        <flux:description>Nro. de Solicitud</flux:description>
                        <flux:input readonly name="nro_sol" value="{{ $solicituduser[0]->nro_sol ?? 'SO-00000' }}"/>
                        <flux:error name="nro_sol" />
                    </flux:field>
                </div>
                <div class="col-span-1">
                    <flux:field  required >
                        <flux:label>Fecha de Solicitud</flux:label>
                        <flux:description>Fecha de Solicitud</flux:description>
                        <flux:input type="date" name="fecha" value="{{ $solicituduser[0]->fecha ?? '' }}"/>
                        <flux:error name="fecha" />
                    </flux:field>
                </div>
                <div class="col-span-1">
                    <flux:label>Tipo de Solicitud</flux:label>
                    <flux:description>Tipos de documento a Tramitar en su Solicitud</flux:description>                    
                    <flux:select name="id_tipo_sol" wire:model="id_tipo_sol" placeholder="{{ $solicituduser[0]->tipo_sol ?? 'Tipo de Solicitud.' }}">
                        @forelse ($tiposolicitud as $tiposol)
                            <flux:select.option value="{{ $tiposol->id }}">{{ $tiposol->descripcion }}</flux:select.option>
                        @empty
                            <flux:select.option value="">No hay tipos de solicitud disponibles</flux:select.option>
                        @endforelse
                    </flux:select>
                    <flux:error name="tipo_sol" />
                </div>
                <div class="col-span-1">
                    <flux:label>Status</flux:label>
                    <flux:description>Status del procesamiento de la solicitud</flux:description>
                    <flux:select name="id_status" wire:model="id_status" placeholder="{{ $solicituduser[0]->status ?? 'Status.' }}">
                        @forelse ($status as $statusdoc)
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
                        <flux:input name="observacion" value="{{ $solicituduser[0]->observacion ?? '' }}"/>
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
                        data-test="save-button">
                    </flux:menu.item>
                </flux:menu.radio.group>
                <flux:menu.radio.group>
                    <flux:menu.item
                        as="button"
                        type="submit"
                        name="cancel"
                        value="cancel"
                        icon=""
                        class="button-accion button-accion-cancel"
                        data-test="cancel-button">
                    </flux:menu.item>
                </flux:menu.radio.group>
            </div>


    </form>
</div>  
