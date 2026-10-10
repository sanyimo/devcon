<?php
$eventLanguage = currentLanguage();

use Classes\QRGenerator;

$gifts = $gifts ?? [];

?>

<main class="management">
    <h2 class="page__heading"><?php echo $title ?? t('Administrar'); ?></h2>
    <p class="page__description"><?php echo t('Tickets comprados'); ?></p>

    <?php if (empty($records)) { ?>
        <p class="page__description"><?php echo t('No hay entradas compradas.'); ?></p>
    <?php } else { ?>
        <div class="tickets-grid">
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
                <dev class="ticket-group">
                    <div class="ticket ticket--<?php echo strtolower($record?->pack?->name ?? ''); ?> ticket--access">
                        <div class="ticket__content">
                            <h4 class="ticket__logo">&#60;DevCon /></h4>
                            <p class="ticket__plan"><?php echo $record?->pack?->name ?? ''; ?></p>
                            <p class="ticketo__name"><?php echo ($_SESSION['name'] ?? '') . " " . ($_SESSION['surname'] ?? ''); ?></p>
                        </div>

                        <img src="<?php echo $qrCode; ?>" alt="<?php echo t('QR del ticket'); ?>" class="ticket__qr">

                        <p class="ticket__code"><?php echo '#' . ($record->token ?? ''); ?></p>
                    </div>

                    <div class="ticket__actions">
                        <div class="ticket__gift">
                            <?php if ($record->pack_id === "1") { ?>
                                <form method="POST" action="/manage/gift">
                                    <input type="hidden" name="token" value="<?php echo $record->token; ?>">
                                    <label for="gift-<?php echo $record->id; ?>"><?php echo t('Regalo'); ?></label>
                                    <select id="gift-<?php echo $record->id; ?>" name="gift_id" onchange="this.form.submit()">
                                        <option value=""  <?php echo empty($record->gift_id) ? 'selected' : ''; ?>>
                                            <?php echo t('- Seleccionar -'); ?>
                                        </option>

                                        <?php foreach ($gifts as $gift) { ?>
                                            <?php if (is_object($gift) && isset($gift->id, $gift->name_es, $gift->name_en)) { ?>
                                                <option
                                                    value="<?php echo $gift->id; ?>"
                                                    <?php echo (string) $record->gift_id === (string) $gift->id ? 'selected' : ''; ?>
                                                    <?php echo $gift->availables <= 0 && (string) $record->gift_id !== (string) $gift->id ? 'disabled' : ''; ?>>
                                                    <?php echo $eventLanguage === 'en' && $gift->name_en ? $gift->name_en : $gift->name_es; ?>
                                                </option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>                                    
                                </form>
                            <?php } ?>
                        </div>

                        <form method="POST" action="/cancel-ticket" data-confirm-message="<?php echo htmlspecialchars(t('Esta acción cancelará este ticket. ¿Continuar?'), ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="token" value="<?php echo $record->token; ?>">
                            <button type="submit" class="cancel-ticket">
                                <?php echo t('Cancelar ticket'); ?>
                            </button>
                        </form>
                    </div>
                </dev>
            <?php } ?>
        </div>
    <?php } ?>

    <section class="manage-account">
        <h3><?php echo t('Datos de la cuenta'); ?></h3>
        <div class="account-details">
            <p><strong><?php echo t('Nombre'); ?>:</strong> <?php echo $_SESSION['name'] ?? ''; ?></p>
            <p><strong><?php echo t('Apellidos'); ?>:</strong> <?php echo $_SESSION['surname'] ?? ''; ?></p>
            <p><strong><?php echo t('E-mail'); ?>:</strong> <?php echo $_SESSION['email'] ?? ''; ?></p>
        </div>

        <form method="POST" action="/unregister" data-confirm-message="<?php echo htmlspecialchars(t('Esta acción eliminará tu cuenta y tus entradas. ¿Continuar?'), ENT_QUOTES, 'UTF-8'); ?>">
            <button type="submit" class="delete-account">
                <?php echo t('Eliminar cuenta'); ?>
            </button>
        </form>
    </section>
</main>