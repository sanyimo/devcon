<h2 class="page__heading"><?php echo $title ?? t('Registro'); ?></h2>
<p class="page__description"><?php echo t('Elige los eventos para asistir de forma presencial.'); ?></p>

<div class="events-record">
    <main class="events-record__listing">
        <h3 class="events-record__heading--conferences">&lt;<?php echo t('Conferencias'); ?> /></h3>
        <p class="events-record__date"><?php echo t('Viernes, 8 de Octubre'); ?></p>

        <div class="events-record__grid">
            <?php foreach (($events['conferences_v'] ?? []) as $event) { ?>
                <?php include __DIR__ . '/event.php'; ?>
            <?php } ?>
        </div>

        <p class="events-record__date"><?php echo t('Sábado, 9 de Octubre'); ?></p>
        <div class="events-record__grid">
            <?php foreach (($events['conferences_s'] ?? []) as $event) { ?>
                <?php include __DIR__ . '/event.php'; ?>
            <?php } ?>
        </div>

        <h3 class="events-record__heading--workshops">&lt;<?php echo t('Workshops'); ?> /></h3>
        <p class="events-record__date"><?php echo t('Viernes, 8 de Octubre'); ?></p>

        <div class="events-record__grid events--workshops">
            <?php foreach (($events['workshops_v'] ?? []) as $event) { ?>
                <?php include __DIR__ . '/event.php'; ?>
            <?php } ?>
        </div>

        <p class="events-record__date"><?php echo t('Sábado, 9 de Octubre'); ?></p>
        <div class="events-record__grid events--workshops">
            <?php foreach (($events['workshops_s'] ?? []) as $event) { ?>
                <?php include __DIR__ . '/event.php'; ?>
            <?php } ?>
        </div>

    </main>

    <aside class="record">
        <h2 class="record__heading"><?php echo t('Tu registro'); ?></h2>

        <div id="record-summary" class="record__summary"></div>

        <div class="record__gift">
            <label for="gift" class="record__label"><?php echo t('Elige un regalo'); ?></label>
            <select id="gift" class="record__select">
                <option value="">--<?php echo t('Elige'); ?>--</option>
                <?php foreach (($gifts ?? []) as $gift) { ?>
                    <?php if (is_object($gift) && isset($gift->id, $gift->name)) { ?>
                        <option value="<?php echo $gift->id; ?>"><?php echo $gift->name; ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>

        <form id="record" class="form">
            <div class="form__field">
                <input type="submit" class="form__submit form__submit--full" value="<?php echo t('Registrarme'); ?>">
            </div>
        </form>
    </aside>
</div>