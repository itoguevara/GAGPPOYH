<x-layouts::auth>
  <div class="absolute left-0 top-2 w-full" >
    <img src="../../../imgweb/logoGPP.png" alt="Guayana Productiva en Positivo" width="500" height="300">
  </div>            

<div class="">
        <form method="POST" action="{{ route('login.store') }}" >
            @csrf
            <div class="absolute left-5 top-60 w-full md:w-3/4">
                <flux:heading size="xl">Iniciar Sesión</flux:heading>
                <flux:text class="mt-2">Ingrese sus credenciales para acceder a su cuenta</flux:text>
            </div>
            <!-- Password -->
            <div class="absolute left-5 top-80 w-full md:w-3/4">
                <!-- Email Address -->
                <flux:input
                    name="email"
                    :label="__('Email address')"
                    :value="old('email')"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="email@example.com"
                />
            </div>
            <!-- Password -->
            <div class="absolute left-5 top-100 w-full md:w-3/4 size-min">
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                    viewable
                />
            </div>
            <div class="absolute left-25 top-100 w-full">
             <!-- Remember Me -->
                <flux:checkbox name="remember" :label="__('Recordarme')" :checked="old('remember')" />
            </div>
            
                @if (Route::has('password.request'))
                <div class="absolute left-5 top-117 w-full">
                    <flux:link  :href="route('password.request')" wire:navigate>
                        {{ __('Recuperar contraseña') }}
                    </flux:link>
                </div>   
                @endif

            <div class="absolute left-22 top-130 w-full">
                <flux:button  type="submit" class="boton-session" data-test="login-button">
                    {{ __('') }}
                </flux:button>
            </div>
        </form>

        @if (Route::has('register') && config('flux.auth.allow_registration'))
            <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
                <span>{{ __('No tienes Cuenta?') }}</span>
                <flux:link :href="route('register')" wire:navigate>{{ __('Registrarse') }}</flux:link>
            </div>
        @endif
    </div>
</x-layouts::auth>
