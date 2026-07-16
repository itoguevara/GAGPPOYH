@php
    $opcionvar = $attributes->get('opcionvar') ?? 0;
    
@endphp

<div class ="header-menu-config">
    <flux:navbar class="menu-config" >
        
        <flux:navbar.item icon="document-text" href="{{ route('home',[0]) }}" >Home</flux:navbar.item>
         <flux:navbar.item href="{{ route('home', [3]) }}" icon:>Quienes Somos ?</flux:navbar.item>

        <flux:navbar.item icon="chart-bar" href="{{ route('generic.show',['4']) }}"> Objetivos Estratégicos</flux:navbar.item>
        <flux:navbar.item icon="calendar" href="{{ route('generic.show',['5']) }}">Opcion 1</flux:navbar.item>
        <flux:navbar.item icon="chart-bar" href="{{ route('generic.show',['6']) }}"> Opcion 2</flux:navbar.item>

    </flux:navbar>
  </div>
