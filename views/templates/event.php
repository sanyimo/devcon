<?php
$eventLanguage = currentLanguage();
$eventName = $eventLanguage === 'en' && $event->name_en ? $event->name_en : $event->name_es;
$eventDescription = $eventLanguage === 'en' && $event->description_en ? $event->description_en : $event->description_es;
?>

<div class="event swiper-slide" tabindex="0">
    <p class="event__hour"><?php echo $event->hour->hour; ?></p>
    <div class="event__information">
        <h4 class="event__name"><?php echo $eventName; ?></h4>
        <p class="event__introduction"><?php echo $eventDescription; ?></p>
        <div class="event__autor-info">
            <picture>
                <source srcset="img/speakers/<?php echo $event->speaker->image; ?>.webp" type="image/webp">
                <source srcset="img/speakers/<?php echo $event->speaker->image; ?>.png" type="image/png">
                <img class="event__image-autor" loading="lazy" width="200" height="300" src="img/speakers/<?php echo $event->speaker->image; ?>.png" alt="<?php echo t('Imagen Ponente'); ?>">
            </picture>
            <p class="event__autor-name">
                <?php echo $event->speaker->name . " " . $event->speaker->surname; ?>
            </p>
        </div>
    </div>
</div>
