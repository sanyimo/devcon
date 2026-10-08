<?php

use Classes\QRGenerator;

$qrData = sprintf(
    "DevCon\nPack: %s\nCódigo: #%s\nCliente: %s %s",
    $record?->pack?->name ?? '',
    $record?->token ?? '',
    $record?->user?->name ?? '',
    $record?->user?->surname ?? ''
);

$qrCode = QRGenerator::generate($qrData);
?>

<main class="pagina">
    <h2 class="page__heading"><?php echo $title ?? t('Ticket de entrada'); ?></h2>
    <?php if($preview ?? false) { ?>
        <p class="page__description"><?php echo t('Aquí tienes tu ticket de entrada.'); ?> <br> <?php echo t('Lo puedes localizar fácilmente pulsando la pestaña'); ?> <strong>"<?php echo t('Administrar'); ?>"</strong> <?php echo t('de arriba.'); ?></p>
    <?php } ?>

    <div class="ticket-virtual">

        <div class="ticket ticket--<?php echo strtolower($record?->pack?->name ?? ''); ?> ticket--access">
            <div class="ticket__content">
                <h4 class="ticket__logo">&#60;DevCon /></h4>
                <p class="ticket__plan"><?php echo $record?->pack?->name ?? ''; ?></p>
                <p class="ticketo__name"><?php echo ($record?->user?->name ?? '') . " " . ($record?->user?->surname ?? ''); ?></p>
            </div>
            
            <img src="<?php echo $qrCode; ?>" alt="<?php echo t('QR del ticket'); ?>" class="ticket__qr">

            <p class="ticket__code"><?php echo '#' . ($record->token ?? ''); ?></p>
        </div>
    </div>
</main>

<?php if($preview ?? false) { ?>
<script>
    const navigation = performance.getEntriesByType('navigation')[0];

    if(navigation?.type === 'reload') {
        window.location.replace('/purchase');
    }

    window.history.replaceState(null, '', '/purchase');

    window.addEventListener('pageshow', function(event) {
        if(event.persisted) {
            window.location.replace('/purchase');
        }
    });
</script>
<?php } ?>