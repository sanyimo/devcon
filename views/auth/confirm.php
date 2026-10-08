<main class="auth">
    <h2 class="auth__heading"><?php echo t($title ?? 'Confirmar cuenta'); ?></h2>
    <p class="auth__text"><?php echo t('Tu cuenta DevCon'); ?></p>

    <?php
    require_once __DIR__ . '/../templates/alerts.php';
    ?>

    <?php if (isset($alerts['success'])) { ?>
        <div class="actions--center">
            <a href="/login" class="actions__link"><?php echo t('Iniciar sesión'); ?></a>
        </div>
    <?php } ?>

</main>