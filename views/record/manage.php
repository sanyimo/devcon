<?php

use Classes\QRGenerator;

?>

<main class="manage-ticket">
    <h2 class="page__heading"><?php echo $title ?? t('Administrar'); ?></h2>
    <p class="page__description"><?php echo t('Tickets comprados'); ?></p>

    <?php if (empty($records)) { ?>
        <p class="page__description"><?php echo t('No hay entradas compradas.'); ?></p>
    <?php } else { ?>
        <div class="ticket-virtual">
            <?php foreach ($records as $record) {
                $qrData = sprintf(
                    "DevCon
                    Pack: %s
                    Código: #%s
                    Cliente: %s %s",
                    $record?->pack?->name ?? '',
                    $record?->token ?? '',
                    $_SESSION['name'] ?? '',
                    $_SESSION['surname'] ?? ''
                );

                $qrCode = QRGenerator::generate($qrData);
            ?>
                <div class="ticket ticket--<?php echo strtolower($record?->pack?->name ?? ''); ?> ticket--access">
                    <div class="ticket__content">
                        <h4 class="ticket__logo">&#60;DevCon /></h4>
                        <p class="ticket__plan"><?php echo $record?->pack?->name ?? ''; ?></p>
                        <p class="ticketo__name"><?php echo ($_SESSION['name'] ?? '') . " " . ($_SESSION['surname'] ?? ''); ?></p>
                    </div>

                    <img src="<?php echo $qrCode; ?>" alt="<?php echo t('QR del ticket'); ?>" class="ticket__qr">

                    <p class="ticket__code"><?php echo '#' . ($record->token ?? ''); ?></p>
                </div>


            <?php } ?>
        </div>
    <?php } ?>
    <div class="ticket__actions">
        <form method="POST" action="/cancel-ticket">
            <input type="hidden" name="token" value="<?php echo $record->token ?? ''; ?>">
            <button type="submit" class="cancel-ticket" onclick="return confirm('<?php echo t('Esta acción cancelará este ticket. ¿Continuar?'); ?>');">
                <?php echo t('Cancelar ticket'); ?>
            </button>
        </form>

        <form method="POST" action="/deregister">
            <button type="submit" class="delete_account" onclick="return confirm('<?php echo t('Esta acción eliminará tu cuenta y tus entradas. ¿Continuar?'); ?>');">
                <?php echo t('Eliminar cuenta'); ?>
            </button>
        </form>
    </div>
</main>