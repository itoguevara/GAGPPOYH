
@php
    $opcionvar = $attributes->get('opcionvar') ?? 0;
    $recordsimpatizantes = $attributes->get('recordsimpatizantes') ?? null;
@endphp
 
<div>
<x-generic.searchrecord :opcionvar="$opcionvar ?? 1" :recordsimpatizantes="$recordsimpatizantes  ?? null" :clientesdata="$clientesdata ?? null"/>

<flux:heading size="xl">Relacion de Simpatizantes</flux:heading>
<flux:card class="space-y-6">
    <div class="relative flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
        {{$recordsimpatizantes->links()}}
        <form method="get" action="{{ route('simpatizantes.store',['opcionvar' => $opcionvar ?? 0]) }}" class="flex flex-col gap-6">
        @csrf
        <div class="overflow-hidden w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark">
            <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
                <thead class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:text-on-surface-dark-strong" style="background-color:darkgray">
                    <tr>
                        <th scope="col" class="p-1">ID</th>
                        <th scope="col" class="p-1">Nombres</th>
                        <th scope="col" class="p-1">Apellidos</th>
                        <th scope="col" class="p-1">Direccion</th>
                        <th scope="col" class="p-1">telefonos</th>
                        <th scope="col" class="p-1 align-middle text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline dark:divide-outline-dark">
                    @foreach ($recordsimpatizantes as $simpatizante )
                        @if ($simpatizante->id_status == 2) 
                            <tr class="bg-red-100 dark:bg-red-900/20">
                          @else
                            <tr class="bg-green-100 dark:bg-green-900/20">
                        @endif
                            <td class="p-1">{{ $simpatizante->id }}</td>
                            <td class="p-1">{{ $simpatizante->nombre }}</td>
                            <td class="p-1">{{ $simpatizante->apellido }}</td>
                            <td class="p-1">{{ $simpatizante->direccion }}</td>
                            <td class="p-1">{{ $simpatizante->telefono }}</td>
                            <td class="p-1" >
                                <div class="button-group-button">
                                    <flux:menu.radio.group>
                                        <flux:menu.item
                                            as="button"
                                            href="{{ route('simpatizantes.edit', ['id' =>Crypt::encrypt($simpatizante->id),'id_accion' => '1']) }}"
                                            type="submit"
                                            name="edit"
                                            value="{{ $simpatizante->id }}"
                                            icon=""
                                            class="button-accion button-accion-edit button-short"
                                            data-test="edit-button"
                                        >
                                        </flux:menu.item>
                                    </flux:menu.radio.group>
                                    <flux:menu.radio.group>
                                        <flux:menu.item
                                            as="button"
                                            type="submit"
                                            name="printer"
                                            href="{{ route('simpatizantes.edit', ['id' => Crypt::encrypt($simpatizante->id), 'opcionvar' => $opcionvar ?? 0,'id_accion' => '2','report_option' => '1']) }}"
                                            value="{{ $simpatizante->id }}"
                                            icon=""
                                            class="button-accion button-accion-printer button-short"
                                            data-test="printer-button"
                                            >
                                        </flux:menu.item>
                                    </flux:menu.radio.group>
                                    <flux:menu.radio.group>
                                        <flux:menu.item
                                            as="button"
                                            type="submit"
                                            href="{{ route('simpatizantes.edit', ['id' => Crypt::encrypt($simpatizante->id), 'opcionvar' => $opcionvar ?? 0,'id_accion' => '3']) }}"
                                            name="delete"
                                            value="{{ $simpatizante->id }}"
                                            icon=""
                                            class="button-accion button-accion-delete button-short"
                                            data-test="delete-button"
                                        >
                                        </flux:menu.item>
                                    </flux:menu.radio.group>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </form>
    </div>
</flux:card>
    <!-- Because you are alive, everything is possible. - Thich Nhat Hanh -->

</div>