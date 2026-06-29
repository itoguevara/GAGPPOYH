@php
use App\Models\userauth\famisoltmpmdl;
use App\Models\userauth\famisolmdl;
/* $familiares = famisoltmpmdl::all() ?? null; 
dd(get_defined_vars());
*/
 $id_solicitud = $attributes->get('id_solicitud') ?? '-1';
 $swi_solnew = $attributes->get('swi_solnew') ?? false;
$clientesdata = session('clientesdata') ?? [];    
if ($swi_solnew == false) {
    $familiares = famisolmdl::Where('id_solicitud', '=', $id_solicitud)->get() ?? null;
} elseif ($swi_solnew == true) {
    $familiares = famisoltmpmdl::Where('id_clienteempre', '=', $clientesdata[0]->id_clienteempre)->get() ?? null;
} else  
 {   $familiares = null;}
if ($familiares==null) {$cant_fami = 0;} else {$cant_fami = count($familiares);}
@endphp
<div>
     <input type="hidden" name="id_clientefami" value="{{ $clientesdata[0]->id_clienteempre ?? '-1' }}">
        <flux:card class="space-y-6">
        <div><flux:heading size="lg">Integrantes</flux:heading></div>
            <div class="data-entry">
                <form   method="POST" wire:submit="addfamilia" class="flex flex-col gap-6">
                    <div class="col-span-1">
                        <flux:label>Documento de Identidad</flux:label>
                        <flux:description>Tipos de Documentos de Identidad</flux:description>
                        <flux:select required readonly wire:model="tipoperfami" placeholder="Tipo de Documentos." >
                            @forelse ($recordtipopersona  as $tipopersona)
                                <flux:select.option value="{{ $tipopersona->id }}">{{ $tipopersona->descripcion }}</flux:select.option>
                            @empty
                                <flux:select.option disabled>No hay tipos de documentos disponibles</flux:select.option>
                            @endforelse
                        </flux:select>
                        <flux:error name="tipoperfami" />
                    </div>
                    <div class="col-span-1">
                        <flux:field>
                            <flux:label>Documento de Identidad</flux:label>
                            <flux:description>Nro. CI/DNI Usuario Solicitante</flux:description>
                            <flux:input  required name="userdocfami" value="{{ $clientesdata[0]->cedula ?? 'V-99999999' }}"/>
                            <flux:error name="userdocfami" />
                        </flux:field>
                    </div>                
                    <div class="col-span-1">
                        <flux:field  required >
                            <flux:label>Nombre</flux:label>
                            <flux:description>Nombre del Usuario Solicitante</flux:description>
                            <flux:input required name="usernamefami" value="{{ $clientesdata[0]->nombre ?? '' }}"/>
                            <flux:error name="usernamefami" />
                        </flux:field>
                    </div>    
                    <div class="col-span-1">
                        <flux:field  required >
                            <flux:label>Apellidos</flux:label>
                            <flux:description>Apellidos del Usuario Solicitante</flux:description>
                            <flux:input required name="userapefami" value="{{ $clientesdata[0]->apellido ?? '' }} "/>
                            <flux:error name="userapefami" />
                        </flux:field>
                    </div>
                    <div class="col-span-1">
                        <flux:label>Parentesco</flux:label>
                        <flux:description>Relacion Familiar con el Titular de la Solicitud.</flux:description>
                        <flux:select required readonly wire:model="parentesco" placeholder="Parentesco" >
                            @forelse ($recordparentesco  as $tipoparentesco)
                                <flux:select.option value="{{ $tipoparentesco->id }}">{{ $tipoparentesco->descripcion }}</flux:select.option>
                            @empty
                                <flux:select.option disabled>No hay tipos de Parentescos disponibles</flux:select.option>
                            @endforelse
                        </flux:select>
                        <flux:error name="parentesco" />
                    </div>
                    <div class="col-span-1">
                        <flux:label>Grado de Instruccion</flux:label>
                        <flux:description>Nivel Educativo.</flux:description>
                        <flux:select required readonly wire:model="grdoinst" placeholder="Nivel Educativo" >
                            @forelse ($recordgrdoinst  as $grdoinst)
                                <flux:select.option value="{{ $grdoinst->id }}">{{ $grdoinst->descripcion }}</flux:select.option>
                            @empty
                                <flux:select.option disabled>No hay Grados de Instruccion disponibles</flux:select.option>
                            @endforelse
                        </flux:select>
                        <flux:error name="grdoinst" />
                    </div>
                    <div class="col-span-1">
                        <flux:label>Profesiones</flux:label>
                        <flux:description>Profesiones Universitarias.</flux:description>
                        <flux:select required readonly wire:model="profesion" placeholder="Profesion" >
                            @forelse ($recordprofesion  as $profesion)
                                <flux:select.option value="{{ $profesion->id }}">{{ $profesion->nombre }}</flux:select.option>
                            @empty
                                <flux:select.option disabled>No hay profesiones universitarias disponibles</flux:select.option>
                            @endforelse
                        </flux:select>
                        <flux:error name="profesion" />
                    </div>
                    <div class="col-span-1">
                        <flux:label>Ocupaciones</flux:label>
                        <flux:description>Ocupacion del Solicitante.</flux:description>
                        <flux:select  required readonly wire:model="ocupacion" placeholder="Ocupacion" >
                            @forelse ($recordocupacion  as $ocupacion)
                                <flux:select.option value="{{ $ocupacion->id }}">{{ $ocupacion->descripcion }}</flux:select.option>
                            @empty
                                <flux:select.option disabled>No hay Ocupaciones disponibles</flux:select.option>
                            @endforelse
                        </flux:select>
                        <flux:error name="ocupacion" />
                    </div>
                    <div >
                        <flux:menu.radio.group>
                            <flux:menu.item
                                as="button"
                                type="submit"
                                href=""
                                name="agregafamilia"
                                value=""
                                icon=""
                                class="button-accion button-accion-masparen button-short"
                                data-test="agregafamilia-button"
                            >
                            </flux:menu.item>
                        </flux:menu.radio.group>
                    </div>
                </form>      
            </div>    
            <div class="overflow-hidden w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark">
                <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
                    <thead class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:text-on-surface-dark-strong" style="background-color:darkgray">
                        <tr>
                            <th scope="col" class="p-1"></th>
                            <th scope="col" class="p-1">Cedula</th>
                            <th scope="col" class="p-1">Apellidos y Nombres</th>
                            <th scope="col" class="p-1">Parentesco</th>
                            <th scope="col" class="p-1">Grado de Instruccion</th>
                            <th scope="col" class="p-1 align-middle text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline dark:divide-outline-dark">
                        @if($cant_fami>0)
                            @forelse ($familiares as $familia)
                                @php 
                                // dd($familia['id_parentesco'],$familia['id_grdinstru']);
                                    $parentesco=PublicFunctions::GetDataObject(20,'',$familia['id_parentesco']);
                                    $grdinstru=PublicFunctions::GetDataObject(21,'',$familia['id_grdinstru']);
                                @endphp    
                                <tr class="bg-red-100 dark:bg-red-900/20">
                                    <td><input type="hidden" name="id_famisol" value="{{ $familia['id'] ?? '-1' }}"></td>
                                    <td class="p-1">{{$familia['cedula'];}}</td>
                                    <td class="p-1">{{$familia['nombre'].' '.$familia['apellido'];}}</td>
                                    <td class="p-1">{{$parentesco[0]->descripcion;}}</td>
                                    <td class="p-1">{{$grdinstru[0]->descripcion;}}</td>
                                    <td class="p-1" >
                                        <div class="button-group-button">
                                            <flux:menu.radio.group>
                                            <flux:menu.item
                                                as="button"
                                                type="submit"
                                                wire:click="delfamilia"
                                                name="deletefamilia"
                                                value=""
                                                icon=""
                                                class="button-accion button-accion-menosparen button-short"
                                                data-test="deletefamilia-button"
                                            >
                                            </flux:menu.item>
                                            </flux:menu.radio.group>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-red-100 dark:bg-red-900/20">
                                    <td class="p-1" colspan="5">No existen Datos de Familiares </td>
                                </tr>    
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </flux:card>
     
</div>