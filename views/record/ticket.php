<main class="pagina">
    <h2 class="page__heading"><?php echo $title ?? 'Ticket de entrada'; ?></h2>
    <p class="page__description">Aquí tienes tu ticket de entrada. <br> Lo puedes localizar fácilmente pulsando la pestaña <strong>"Administrar"</strong> de arriba.</p>

    <div class="ticket-virtual">

        <div class="ticket ticket--<?php echo strtolower($record?->pack?->name ?? ''); ?> ticket--access">
            <div class="ticket__content">
                <h4 class="ticket__logo">&#60;DevCon /></h4>
                <p class="ticket__plan"><?php echo $record?->pack?->name ?? ''; ?></p>
                <p class="ticketo__name"><?php echo ($record?->user?->name ?? '') . " " . ($record?->user?->surname ?? ''); ?></p>
            </div>

            <p class="ticket__code"><?php echo '#' . ($record->token ?? ''); ?></p>
        </div>
    </div>
</main>