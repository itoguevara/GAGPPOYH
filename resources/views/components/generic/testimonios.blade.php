<!-- Testimonios Start -->
<flux:card class="card">
  <div class="space-y-4">
      <flux:spacer></flux:spacer>
      <flux:heading level="2" class="text-center">¿TIE, NIE o DNI? </flux:heading>
      <flux:separator></flux:separator>
        <flux:text class="text-center text-lg text-gray-600 dark:text-gray-400">
              Aunque suelen confundirse, no son lo mismo y cada uno cumple una función distinta en España 🇪🇸
            <flux:checkbox.group wire:model="notifications" label="Explicacion de cada documento:">
                <flux:spacer></flux:spacer>
                <flux:checkbox label="👉El NIE es tu número de identificación como extranjero" value="nie" checked />
                <flux:checkbox label="👉El TIE es la tarjeta que acredita tu residencia legal" value="tie" checked />
                <flux:checkbox label="👉l DNI es exclusivo para ciudadanos españoles" value="dni" checked />
            </flux:checkbox.group>              
            <flux:spacer></flux:spacer>
          📌 Conocer la diferencia evita errores y retrasos en tus trámites migratorios.
            <flux:separator></flux:separator>  
            <flux:spacer></flux:spacer>
              <div class=".card-testimonios-img">
                <img src="../../../Back/presentacion/images/clientescontentos/docespana.png" alt="" >
              </div>             
            <flux:spacer></flux:spacer> 
            <flux:text level="2" class="text-center">
                📲 En Ágreda y Asociados te asesoramos de forma clara y personalizada en cada etapa de tu proceso. 
            </flux:text>       
          
        </flux:text>
   

  </div>
</flux:card>

<flux:card  class="card-testimonios" title="Testimonios de Clientes Satisfechos" description="Nuestros clientes satisfechos son nuestra mejor carta de presentación. Aquí compartimos algunos de sus testimonios sobre nuestros servicios de asesoría migratoria y tramitación de documentos.">
<section class="testi-card-section">
  <div class="testi-card-img">
      <img src="../../../Back/presentacion/images/clientescontentos/clientecontento01.png"  >
  </div>   
  <div class="testi-card-text">
    <p class="testi-card-text-msg">"Gracias a Agreda y Asociados, mi proceso de migración fue mucho más sencillo y rápido de lo que esperaba. Su equipo de expertos me guió en cada paso, asegurándose de que cumpliera con todos los requisitos. ¡Recomiendo sus servicios a cualquiera que necesite asesoría migratoria!"</p>
    <p class="testi-card-text-title">- María López</p>  
   
  </div>
</section>    

   
</flux:card>
 

<!-- Testimonios End -->