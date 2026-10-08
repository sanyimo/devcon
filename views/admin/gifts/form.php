<fieldset class="form__fieldset">
    <legend class="form__legend">Información del regalo</legend>

    <div class="form__field">
        <label for="name" class="form__label">Nombre</label>
        <input
            type="text"
            class="form__input"
            id="name"
            name="name"
            placeholder="Nombre del regalo"
            value="<?php echo $gift->name ?? ''; ?>">
    </div>

    <div class="form__field">
        <label for="quantity" class="form__label">Cantidad</label>
        <input
            type="number"
            class="form__input"
            id="quantity"
            name="quantity"
            placeholder="Cantidad"
            min="0"
            value="<?php echo $gift->quantity ?? ''; ?>">
    </div>
</fieldset>