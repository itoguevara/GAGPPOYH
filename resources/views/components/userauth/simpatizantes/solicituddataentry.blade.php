<div>
   <form method="POST" action="{{ route('solicitud.store',['opcionvar' => $opcionvar]) }}" class="flex flex-col gap-6">
    @csrf
        <flux:card class="space-y-6">
            <div>
                <flux:heading size="xl">Ingreso de Solicitud de Interesados</flux:heading>
                <flux:text class="mt-2">Por favor, llene el formulario de Datos Para procesar su solicitud</flux:text>
            </div>
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