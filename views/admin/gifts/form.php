<fieldset class="form__fieldset">
    <legend class="form__legend"><?php echo t('Información del regalo'); ?></legend>

    <div class="form__field">
        <label for="name" class="form__label"><?php echo t('Nombre'); ?></label>
        <input
            type="text"
            class="form__input"
            id="name"
            name="name"
            placeholder="<?php echo t('Nombre del regalo'); ?>"
            value="<?php echo $gift->name ?? ''; ?>">
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