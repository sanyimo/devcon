<main class="auth">
    <h2 class="auth__heading"><?php echo $title ?? ''; ?></h2>
    <p class="auth__text"><?php echo t('Regístrate en DevCon'); ?></p>

    <?php
    require_once __DIR__ . '/../templates/alerts.php';
    ?>

    <form method="POST" action="/record" class="form">
        <div class="form__field">
            <label for="name" class="form__label"><?php echo t('Nombre'); ?></label>
            <input
                type="text"
                class="form__input"
                placeholder="<?php echo t('Tu nombre'); ?>"
                id="name"
                name="name"
                value="<?php echo isset($user) && is_object($user) && property_exists($user, 'name') ? $user->name : ''; ?>"
                autocomplete="name">
        </div>

        <div class="form__field">
            <label for="surname" class="form__label"><?php echo t('Apellidos'); ?></label>
            <input
                type="text"
                class="form__input"
                placeholder="<?php echo t('Tus apellidos'); ?>"
                id="surname"
                name="surname"
                value="<?php echo $user->surname ?? ''; ?>">
        </div>

        <div class="form__field">
            <label for="email" class="form__label">E-mail</label>
            <input
                type="email"
                class="form__input"
                placeholder="<?php echo t('Tu e-mail'); ?>"
                id="email"
                name="email"
                value="<?php echo $user->email ?? ''; ?>" autocomplete="email">
        </div>

        <br>
        <div class="form__field">
            <label for="password" class="form__label"><?php echo t('Contraseña'); ?></label>
            <input
                type="password"
                class="form__input"
                placeholder="<?php echo t('Tu contraseña'); ?>"
                id="password"
                name="password">
        </div>

        <div class="form__field">
            <label for="password2" class="form__label"><?php echo t('Repetir contraseña'); ?></label>
            <input
                type="password"
                class="form__input"
                placeholder="<?php echo t('Repetir contraseña'); ?>"
                id="password2"
                name="password2">
        </div>

        <input type="submit" class="form__submit" value="<?php echo t('Crear cuenta'); ?>">
    </form>

    <div class="actions">
        <a href="/login" class="actions__link"><?php echo t('Iniciar sesión'); ?></a>
        <a href="/forgot" class="actions__link"><?php echo t('He olvidado mi contraseña'); ?></a>
    </div>
</main>