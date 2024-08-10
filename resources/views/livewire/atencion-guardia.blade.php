@if ($showPopup)
<div class="wrapper bg-red-500 flex space-x-6 items-center justify-center">
    <div class="text-wrapper text-5xl">
        <span class="font-custom text-8xl">ATENCION!</span> Durante la Guardia la prioridad de atención de los tickets será para:
        <span class="font-semibold">Dispensarios:</span> Deje de funcionar un dispensario, marque error o no despache.
        <span class="font-semibold">Facturacion:</span>No permita facturar en ninguno de los medios establecidos.
        <span class="font-semibold">Fletera:</span> Correciones de sistema.
        <span class="font-semibold">Terminales:</span> Dejen de emitir tickets.
        <span class="font-semibold">Volumetricos:</span> Se apague y no encienda, deje de comunicar con los dispensarios o se quede atorado.
        Cualquier otra incidencia <span class="font-semibold">NO</span> listada con anterioridad, <span class="font-semibold">FAVOR</span> de levantar ticket al siguiente día hábil.
    </div>
     <div class="text-wrapper text-5xl">
        <span class="font-custom text-8xl">ATENCION!</span> Durante la Guardia la prioridad de atención de los tickets será para:
        <span class="font-semibold">Dispensarios:</span> Deje de funcionar un dispensario, marque error o no despache.
        <span class="font-semibold">Facturacion:</span>No permita facturar en ninguno de los medios establecidos.
        <span class="font-semibold">Fletera:</span> Correciones de sistema.
        <span class="font-semibold">Terminales:</span> Dejen de emitir tickets.
        <span class="font-semibold">Volumetricos:</span> Se apague y no encienda, deje de comunicar con los dispensarios o se quede atorado.
        Cualquier otra incidencia <span class="font-semibold">NO</span> listada con anterioridad, <span class="font-semibold">FAVOR</span> de levantar ticket al siguiente día hábil.
    </div>
     <div class="text-wrapper text-5xl">
        <span class="font-custom text-8xl">ATENCION!</span> Durante la Guardia la prioridad de atención de los tickets será para:
        <span class="font-semibold">Dispensarios:</span> Deje de funcionar un dispensario, marque error o no despache.
        <span class="font-semibold">Facturacion:</span>No permita facturar en ninguno de los medios establecidos.
        <span class="font-semibold">Fletera:</span> Correciones de sistema.
        <span class="font-semibold">Terminales:</span> Dejen de emitir tickets.
        <span class="font-semibold">Volumetricos:</span> Se apague y no encienda, deje de comunicar con los dispensarios o se quede atorado.
        Cualquier otra incidencia <span class="font-semibold">NO</span> listada con anterioridad, <span class="font-semibold">FAVOR</span> de levantar ticket al siguiente día hábil.
    </div>
     <div class="text-wrapper text-5xl">
        <span class="font-custom text-8xl">ATENCION!</span> Durante la Guardia la prioridad de atención de los tickets será para:
        <span class="font-semibold">Dispensarios:</span> Deje de funcionar un dispensario, marque error o no despache.
        <span class="font-semibold">Facturacion:</span>No permita facturar en ninguno de los medios establecidos.
        <span class="font-semibold">Fletera:</span> Correciones de sistema.
        <span class="font-semibold">Terminales:</span> Dejen de emitir tickets.
        <span class="font-semibold">Volumetricos:</span> Se apague y no encienda, deje de comunicar con los dispensarios o se quede atorado.
        Cualquier otra incidencia <span class="font-semibold">NO</span> listada con anterioridad, <span class="font-semibold">FAVOR</span> de levantar ticket al siguiente día hábil.
    </div>
     <div class="text-wrapper text-5xl">
        <span class="font-custom text-8xl">ATENCION!</span> Durante la Guardia la prioridad de atención de los tickets será para:
        <span class="font-semibold">Dispensarios:</span> Deje de funcionar un dispensario, marque error o no despache.
        <span class="font-semibold">Facturacion:</span>No permita facturar en ninguno de los medios establecidos.
        <span class="font-semibold">Fletera:</span> Correciones de sistema.
        <span class="font-semibold">Terminales:</span> Dejen de emitir tickets.
        <span class="font-semibold">Volumetricos:</span> Se apague y no encienda, deje de comunicar con los dispensarios o se quede atorado.
        Cualquier otra incidencia <span class="font-semibold">NO</span> listada con anterioridad, <span class="font-semibold">FAVOR</span> de levantar ticket al siguiente día hábil.
    </div>
</div>
@endif
<style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    * {
        margin: 0;
    }

    .wrapper {
        width: 100%;
        max-width: 1536px;
        margin-inline: auto;
        position: relative;
        height: 100px;
        overflow: hidden;
        mask-image: linear-gradient(to right,
            rgba(0, 0, 0, 0),
            rgba(0, 0, 0, 1) 20%,
            rgba(0, 0, 0, 1) 80%,
            rgba(0, 0, 0, 0));
    }

    .text-wrapper {
        display: inline-block;
        left: max(calc(400px * 8), 100%);
        white-space: nowrap; /* Prevent text from wrapping to a new line */
        animation: scrollLeft 100s linear infinite;
    }

    @keyframes scrollLeft {
        0% {
            transform: translateX(100%);
        }
        100% {
            transform: translateX(-100%);
        }
    }

    @font-face {
        font-family: "CAUTION";
        src: url("/fonts/CAUTION.ttf");
    }

    .font-custom {
        font-family: "CAUTION", sans-serif;
    }
</style>
