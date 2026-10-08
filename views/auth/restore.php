<main class="auth">
    <h2 class="auth__heading"><?php echo t($title ?? 'Restablecer contraseña'); ?></h2>
    <p class="auth__text"><?php echo t('Coloca tu nueva contraseña'); ?></p>

    <?php
    require_once __DIR__ . '/../templates/alerts.php';
    ?>

    <?php if ($token_valid ?? false) { ?>
        <form method="POST" class="form">
            <div class="form__field">
                <label for="password" class="form__label"><?php echo t('Nueva contraseña'); ?></label>
                <input
                    type="password"
                    class="form__input"
                    placeholder="<?php echo t('Tu nueva contraseña'); ?>"
                    id="password"
                    name="password">
            </div>
            <div class="form__field">
                <label for="password2" class="form__label"><?php echo t('Repite contraseña'); ?></label>
                <input
                    type="password"
                    class="form__input"
                    placeholder="<?php echo t('Repite contraseña'); ?>"
                    id="password2"
                    name="password2">
            </div>

            <input type="submit" class="form__submit" value="<?php echo t('Guardar'); ?>">
        </form>
    <?php } ?>

    <div class="actions">
        <a href="/login" class="actions__link"><?php echo t('Iniciar sesión'); ?></a>
        <a href="/record" class="actions__link"><?php echo t('¿Aún no tienes una cuenta? Crear una'); ?></a>
    </div>
</main>