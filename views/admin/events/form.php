<?php
$eventNameEs = isset($event) && is_object($event) ? ($event->name_es ?? '') : '';
$eventNameEn = isset($event) && is_object($event) ? ($event->name_en ?? '') : '';
$eventDescriptionEs = isset($event) && is_object($event) ? ($event->description_es ?? '') : '';
$eventDescriptionEn = isset($event) && is_object($event) ? ($event->description_en ?? '') : '';
?>

<fieldset class="form__fieldset">
    <legend class="form__legend"><?php echo t('Información evento'); ?></legend>

    <div class="form__field">
        <label for="name_es" class="form__label"><?php echo t('Nombre evento'); ?> (ES)</label>
        <input
            type="text"
            class="form__input"
            id="name_es"
            name="name_es"
            placeholder="<?php echo t('Nombre evento en español'); ?>"
            value="<?php echo $eventNameEs; ?>">
    </div>

    <div class="form__field">
        <label for="name_en" class="form__label"><?php echo t('Nombre evento'); ?> (EN)</label>
        <input
            type="text"
            class="form__input"
            id="name_en"
            name="name_en"
            placeholder="<?php echo t('Nombre evento en inglés'); ?>"
            value="<?php echo $eventNameEn; ?>">
    </div>

    <div class="form__field">
        <label for="description_es" class="form__label"><?php echo t('Descripción'); ?> (ES)</label>
        <textarea
            class="form__input"
            id="description_es"
            name="description_es"
            placeholder="<?php echo t('Descripción evento en español'); ?>"
            rows="8"><?php echo $eventDescriptionEs; ?></textarea>
    </div>

    <div class="form__field">
        <label for="description_en" class="form__label"><?php echo t('Descripción'); ?> (EN)</label>
        <textarea
            class="form__input"
            id="description_en"
            name="description_en"
            placeholder="<?php echo t('Descripción evento en inglés'); ?>"
            rows="8"><?php echo $eventDescriptionEn; ?></textarea>
    </div>

    <div class="form__field">
        <label for="category" class="form__label"><?php echo t('Categoría o tipo de evento'); ?></label>
        <select
            class="form__select"
            id="category"
            name="category_id">
            <option value=""><?php echo t('- Seleccionar -'); ?></option>
            <?php foreach (($categories ?? []) as $category) { ?>
                <?php if (!is_object($category)) {
                    continue;
                } ?>
                <option
                    value="<?php echo $category->id; ?>"
                    <?php echo (isset($event) && is_object($event) && isset($event->category_id) && (int) $event->category_id === (int) $category->id) ? 'selected' : ''; ?>>
                    <?php echo t($category->name); ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="form__field">
        <label for="category" class="form__label"><?php echo t('Selecciona el día'); ?></label>

        <div class="form__radio">
            <?php foreach (($days ?? []) as $day) { ?>
                <?php if (!is_object($day) || !isset($day->name, $day->id)) {
                    continue;
                } ?>
                <div>
                    <label for="<?php echo strtolower($day->name); ?>"><?php echo t($day->name); ?></label>
                    <input
                        type="radio"
                        id="<?php echo strtolower($day->name); ?>"
                        name="day"
                        value="<?php echo $day->id; ?>"
                        <?php echo (isset($event) && isset($event->day_id) && (int) $event->day_id === (int) $day->id) ? 'checked' : ''; ?> />
                </div>
            <?php } ?>
        </div>

        <input type="hidden" name="day_id" value="<?php echo isset($event) && isset($event->day_id) ? $event->day_id : ''; ?>">
    </div>

    <div id="hours" class="form__field">
        <label class="form__label"><?php echo t('Seleccionar hora'); ?></label>

        <ul id="hours" class="hours">
            <?php foreach (($hours ?? []) as $hour) { ?>
                <?php if (!is_object($hour) || !isset($hour->id, $hour->hour)) {
                    continue;
                } ?>
                <li data-hour-id="<?php echo $hour->id; ?>" class="hours__hour hours__hour--disabled"><?php echo $hour->hour; ?></li>
            <?php } ?>
        </ul>

        <input type="hidden" name="hour_id" value="<?php echo isset($event) && isset($event->hour_id) ? $event->hour_id : ''; ?>">
    </div>
</fieldset>


<fieldset class="form__fieldset">
    <legend class="form__legend"><?php echo t('Información extra'); ?></legend>

    <div class="form__field">
        <label for="speakers" class="form__label"><?php echo t('Ponente'); ?></label>
        <input
            type="text"
            class="form__input"
            id="speakers"
            placeholder="<?php echo t('Buscar ponente'); ?>">
        <ul id="listing-speakers" class="listing-speakers"></ul>

        <input type="hidden" name="speaker_id" value="<?php echo isset($event) && isset($event->speaker_id) ? $event->speaker_id : ''; ?>">
    </div>

    <div class="form__field">
        <label for="availables" class="form__label"><?php echo t('Cupos disponibles'); ?></label>
        <input
            type="number"
            min="1"
            class="form__input"
            id="availables"
            name="availables"
            placeholder="<?php echo t('Ej. 20'); ?>"
            value="<?php echo isset($event) && isset($event->availables) ? $event->availables : ''; ?>">
    </div>

</fieldset>
