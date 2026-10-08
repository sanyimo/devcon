<?php $events = $events ?? ['conferences_v' => [], 'conferences_s' => [], 'workshops_v' => [], 'workshops_s' => []]; ?>
<main class="agenda">
    <h2 class="agenda__heading"><?php echo t('Workshops & Conferencias'); ?></h2>
    <p class="agenda__description"><?php echo t('Talleres y conferencias dictados por expertos en desarrollo web'); ?></p>

    <div class="events">
        <h3 class="events__heading">&lt;<?php echo t('Conferencias'); ?> /></h3>
        <p class="events__date"><?php echo t('Viernes 8 de Octubre'); ?></p>

        <div class="events__listing slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($events['conferences_v'] as $event) { ?>
                    <?php include __DIR__ . '../../templates/event.php'; ?>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <p class="events__date"><?php echo t('Sábado 9 de Octubre'); ?></p>

        <div class="events__listing slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($events['conferences_s'] as $event) { ?>
                    <?php include __DIR__ . '../../templates/event.php'; ?>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>

    <div class="events events--workshops">
        <h3 class="events__heading">&lt;<?php echo t('Workshops'); ?> /></h3>
        <p class="events__date"><?php echo t('Viernes 8 de Octubre'); ?></p>

        <div class="events__listing slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($events['workshops_v'] as $event) { ?>
                    <?php include __DIR__ . '../../templates/event.php'; ?>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <p class="events__date"><?php echo t('Sábado 9 de Octubre'); ?></p>

        <div class="events__listing slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($events['workshops_s'] as $event) { ?>
                    <?php include __DIR__ . '../../templates/event.php'; ?>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</main>