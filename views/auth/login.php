<main class="auth">
    <h2 class="auth__heading"><?php echo $title ?? 'Inicia sesión'; ?></h2>
    <p class="auth__text">Inicia sesión en DevCon</p>

    <?php
    require_once __DIR__ . '/../templates/alerts.php';
    ?>

    <form method="POST" action="/login" class="form">
        <div class="form__field">
            <label for="email" class="form__label">E-mail</label>
            <input
                type="email"
                class="form__input"
                placeholder="Tu e-mail"
                id="email"
                name="email" />
        </div>
        <div class="form__field">
            <label for="password" class="form__label">Contraseña</label>
            <input
                type="password"
                class="form__input"
                placeholder="Tu contraseña"
                id="password"
                name="password" />
        </div>

        <input type="submit" class="form__submit" value="Iniciar sesión">
    </form>

    <div class="actions">
        <a href="/record" class="actions__link">¿Aún no tienes una cuenta? Crea una</a>
        <a href="/forgot" class="actions__link">He olvidado mi contraseña</a>
    </div>
</main>