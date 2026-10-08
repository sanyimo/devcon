<fieldset class="form__fieldset">
    <legend class="form__legend">Información personal</legend>

    <div class="form__field">
        <label for="name" class="form__label">Nombre</label>
        <input
            type="text"
            class="form__input"
            id="name"
            name="name"
            placeholder="Nombre"
            value="<?php echo $speaker->name ?? ''; ?>">
    </div>

    <div class="form__field">
        <label for="surname" class="form__label">Apellidos</label>
        <input
            type="text"
            class="form__input"
            id="surname"
            name="surname"
            placeholder="surname"
            value="<?php echo $speaker->surname ?? ''; ?>">
    </div>

    <div class="form__field">
        <label for="city" class="form__label">Ciudad</label>
        <input
            type="text"
            class="form__input"
            id="city"
            name="city"
            placeholder="Ciudad"
            value="<?php echo $speaker->city ?? ''; ?>">
    </div>

    <div class="form__field">
        <label for="country" class="form__label">País</label>
        <input
            type="text"
            class="form__input"
            id="country"
            name="country"
            placeholder="País"
            value="<?php echo $speaker->country ?? ''; ?>">
    </div>
    <div class="form__field">
        <label for="image" class="form__label">Imagen</label>
        <input
            type="file"
            class="form__input form__input--file"
            id="image"
            name="image">
    </div>

    <?php if (isset($speaker->current_image)) { ?>
        <p class="form__text">Imagen actual:</p>
        <div class="form__image">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'] . '/img/speakers/' . $speaker->image; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'] . '/img/speakers/' . $speaker->image; ?>.png" type="image/png">
                <img src="<?php echo $_ENV['HOST'] . '/img/speakers/' . $speaker->image; ?>.png" alt="Imagen ponente">
            </picture>
        </div>

    <?php } ?>
</fieldset>


<fieldset class="form__fieldset">
    <legend class="form__legend">Información extra</legend>

    <div class="form__field">
        <label for="tags_input" class="form__label">Áreas de experiencia (separadas por la tecla &laquo;espacio&raquo;)</label>
        <input
            type="text"
            class="form__input"
            id="tags_input"
            placeholder="Ej. Node.js, PHP, CSS, Laravel, UX / UI">

        <div id="tags" class="form__listing"></div>
        <input type="hidden" name="tags" value="<?php echo $speaker->tags ?? ''; ?>">
    </div>
</fieldset>

<fieldset class="form__fieldset">
    <legend class="form__legend">Redes sociales</legend>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-facebook"></i>
            </div>
            <input
                type="text"
                class="form__input--socials"
                name="social_networks[facebook]"
                placeholder="Facebook"
                value="<?php echo $social_networks->facebook ?? ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-twitter"></i>
            </div>
            <input
                type="text"
                class="form__input--socials"
                name="social_networks[twitter]"
                placeholder="Twitter"
                value="<?php echo $social_networks->twitter ?? ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <input
                type="text"
                class="form__input--socials"
                name="social_networks[youtube]"
                placeholder="YouTube"
                value="<?php echo $social_networks->youtube ?? ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-instagram"></i>
            </div>
            <input
                type="text"
                class="form__input--socials"
                name="social_networks[instagram]"
                placeholder="Instagram"
                value="<?php echo $social_networks->instagram ?? ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-tiktok"></i>
            </div>
            <input
                type="text"
                class="form__input--socials"
                name="social_networks[tiktok]"
                placeholder="Tiktok"
                value="<?php echo $social_networks->tiktok ?? ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-github"></i>
            </div>
            <input
                type="text"
                class="form__input--socials"
                name="social_networks[github]"
                placeholder="GitHub"
                value="<?php echo $social_networks->github ?? ''; ?>">
        </div>
    </div>

</fieldset>