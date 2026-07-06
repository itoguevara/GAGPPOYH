@php

    $id_simpatizante = session(['id_simpatizante']) ?? -1;
    $status = session('recordstatus') ?? [];
    $tiposolicitud = session('recordtiposolicitud') ?? [];
    $tiposimpatizante = session('recordtiposimpatizante') ?? [];
@endphp
<form method="get" action="{{ route('simpatizante.search',['opcionvar' => $opcionvar ?? 0]) }}" class="flex flex-col gap-6">
    @csrf
    <flux:table container:class="search-table" >
        <flux:table.rows >
            <flux:table.row >
                <flux:table.cell class="align-middle text-center mt-0" colspan="7">
                    <flux:radio.group wire:model="search_field" variant="segmented" size="sm" label="Buscar En :"  name="search_field">
                        <flux:radio value="0" label="Nombres" icon="wrench" checked />
                        <flux:radio value="1" label="Apellidos" icon="document-text" />
                        <flux:radio value="2" label="Fecha" icon="calendar" />
                        <flux:radio value="3" label="Tipo" icon="tag" />
                        <flux:radio value="4" label="Status" icon="check-circle" />
                    </flux:radio.group>
                </flux:table.cell>
            </flux:table.row>
            <flux:table.row >
                <flux:table.cell class="align-middle text-center">
                    <flux:label>Tipo de Tramite</flux:label>
                        <flux:select name="id_tipo_sol" wire:model="id_tipo_sol" placeholder="Tipo de Solicitud." >
                            @forelse ($tiposimpatizante as $tiposimpat)
                                <flux:select.option value="{{ $tiposimpat->id }}">{{ $tiposimpat->descripcion }}</flux:select.option>
                            @empty
                                <flux:select.option value="">No hay tipos de solicitud disponibles</flux:select.option>
                            @endforelse
                        </flux:select>
                        <flux:error name="id_tipo_sol" />                            
                    </flux:table.cell>
                <flux:table.cell class="align-middle text-center">
                    <flux:label>Status</flux:label>
                    <flux:select name="id_status" wire:model="id_status" placeholder="Status." >
                        @forelse ($status as $statusdoc)
                            <flux:select.option value="{{ $statusdoc->id }}">{{ $statusdoc->descripcion }}</flux:select.option>
                        @empty
                            <flux:select.option value="">No hay status disponibles</flux:select.option>
                        @endforelse
                    </flux:select>
                    <flux:error name="id_status" />                            
                </flux:table.cell>
                <flux:table.cell class="align-middle text-center">
                    <flux:field  required >
                        <flux:label>Fecha Desde :</flux:label>
                        <flux:input type="date" name="fecha_desde"/>
                        <flux:error name="fecha_desde" />
                    </flux:field>  
                </flux:table.cell>
                <flux:table.cell class="align-middle text-center">
                    <flux:field  required >
                        <flux:label>Fecha Hasta :</flux:label>
                        <flux:input type="date" name="fecha_hasta"/>
                        <flux:error name="fecha_hasta" />
                    </flux:field>
                </flux:table.cell>
                <flux:table.cell class="align-middle text-center">
                    <flux:label>Data a Buscar</flux:label>
                    <flux:field required >
                        <flux:input name="data_search" placeholder="" />
                        <flux:error name="data_search" />
                    </flux:field>
                </flux:table.cell>
                <flux:table.cell class="align-middle text-center">
                    <flux:label></flux:label>
                    <flux:menu.radio.group>
                        <flux:menu.item
                            as="button"
                            type="submit"
                            name="search"
                            value="search"
                            icon=""
                            class="button-accion button-accion-search button-short"
                            data-test="search-button"
                        >
                        </flux:menu.item>
                    </flux:menu.radio.group>
                </flux:table.cell>
                <flux:table.cell class="align-middle text-center">
                    <flux:label></flux:label>
                    <flux:menu.radio.group>
                        <flux:menu.item
                            as="button"
                            type="submit"
                            name="printer"
                            value="printer"
                            icon=""
                            class="button-accion button-accion-printer button-short"
                            data-test="printer-button"
                        >
                        </flux:menu.item>
                    </flux:menu.radio.group>
                </flux:table.cell>
            </flux:table.row>
            <flux:table.row >
                <flux:table.cell class="align-middle text-center" colspan="7">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @elseif (session('success'))    
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                </flux:table.cell>
            </flux:table.row>
        </flux:table.rows>
    </flux:table>

    <div><input type="hidden" name="id_simpatizante" value="{{$id_simpatizante}}"></div >
</form>


