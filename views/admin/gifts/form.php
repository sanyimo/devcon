<fieldset class="form__fieldset">
    <legend class="form__legend"><?php echo t('Información del regalo'); ?></legend>

    <div class="form__field">
        <label for="name_es" class="form__label"><?php echo t('Nombre del regalo'); ?> (ES)</label>
        <input
            type="text"
            class="form__input"
            id="name_es"
            name="name_es"
            placeholder="<?php echo t('Nombre del regalo en español'); ?>"
            value="<?php echo $gift->name_es ?? ''; ?>">
    </div>

    <div class="form__field">
        <label for="name_en" class="form__label"><?php echo t('Nombre del regalo'); ?> (EN)</label>
        <input
            type="text"
            class="form__input"
            id="name_en"
            name="name_en"
            placeholder="<?php echo t('Nombre del regalo en inglés'); ?>"
            value="<?php echo $gift->name_en ?? ''; ?>">
    </div>

    <div class="form__field">
        <label for="quantity" class="form__label"><?php echo t('Cantidad'); ?></label>
        <input
            type="number"
            class="form__input"
            id="quantity"
            name="quantity"
            placeholder="<?php echo t('Cantidad'); ?>"
            min="0"
            value="<?php echo $gift->quantity ?? ''; ?>">
    </div>
</fieldset>