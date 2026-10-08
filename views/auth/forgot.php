<main class="auth">
    <h2 class="auth__heading"><?php echo $title ?? 'Recuperar acceso'; ?></h2>
    <p class="auth__text">Recupera tu acceso a DevCon</p>

    <?php
    require_once __DIR__ . '/../templates/alerts.php';
    ?>

    <form method="POST" action="/forgot" class="form">
        <div class="form__field">
            <label for="email" class="form__label">E-mail</label>
            <input
                type="email"
                class="form__input"
                placeholder="Tu e-mail"
                id="email"
                name="email"
                autocomplete="email">
        </div>

        <input type="submit" class="form__submit" value="Enviar instrucciones">
    </form>

    <div class="actions">
        <a href="/login" class="actions__link Iniciar sesión</a>
        <a href=" /record" class="actions__link">¿Aún no tienes una cuenta? Crea una</a>
    </div>
</main>