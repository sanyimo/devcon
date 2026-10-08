<?php

use Classes\QRGenerator;

?>

<main>
    <h2 class="page__heading"><?php echo $title ?? t('Administrar'); ?></h2>
    <p class="page__description"><?php echo t('Tickets comprados'); ?></p>

    <?php if(empty($records)) { ?>
        <p class="page__description"><?php echo t('No hay entradas compradas.'); ?></p>
    <?php } else { ?>
        <div class="ticket-virtual">
            <?php foreach($records as $record) {
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

                <div class="ticket__gift">
                    <?php if($record->pack_id === "1") { ?>
                        <form method="POST" action="/manage/gift">
                            <input type="hidden" name="token" value="<?php echo $record->token; ?>">
                            <label for="gift-<?php echo $record->id; ?>"><?php echo t('Regalo'); ?></label>
                            <select id="gift-<?php echo $record->id; ?>" name="gift_id" onchange="this.form.submit()">
                                <?php foreach($gifts as $gift) { ?>
                                    <option value="<?php echo $gift->id; ?>" <?php echo (string) $record->gift_id === (string) $gift->id ? 'selected' : ''; ?> <?php echo $gift->availables <= 0 && (string) $record->gift_id !== (string) $gift->id ? 'disabled' : ''; ?>>
                                        <?php echo $gift->name; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </form>
                    <?php } ?>
                </div>

                <form method="POST" action="/cancel-ticket">
                    <input type="hidden" name="token" value="<?php echo $record->token; ?>">
                    <button type="submit" class="packs__submit" onclick="return confirm('<?php echo t('Esta acción cancelará este ticket. ¿Continuar?'); ?>');">
                        <?php echo t('Cancelar ticket'); ?>
                    </button>
                </form>
            <?php } ?>
        </div>
    <?php } ?>

    <section class="account-manage">
        <h3><?php echo t('Datos de la cuenta'); ?></h3>
        <p><strong><?php echo t('Nombre'); ?>:</strong> <?php echo $_SESSION['name'] ?? ''; ?></p>
        <p><strong><?php echo t('Apellidos'); ?>:</strong> <?php echo $_SESSION['surname'] ?? ''; ?></p>
        <p><strong><?php echo t('E-mail'); ?>:</strong> <?php echo $_SESSION['email'] ?? ''; ?></p>

        <form method="POST" action="/deregister">
            <button type="submit" class="packs__submit" onclick="return confirm('<?php echo t('Esta acción eliminará tu cuenta y tus entradas. ¿Continuar?'); ?>');">
                <?php echo t('Eliminar cuenta'); ?>
            </button>
        </form>
    </section>
</main>