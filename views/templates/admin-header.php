<header class="dashboard__header">
    <div class="dashboard__header-grid">
        <a href="/">
            <h2 class="dashboard__logo">
                &#60;DevCon />
            </h2>
        </a>

        <nav class="dashboard__nav">
            <div class="language-selector">
                <button type="button" class="language-selector__button <?php echo currentLanguage() === 'es' ? 'language-selector__button--active' : ''; ?>" data-language="es" aria-pressed="<?php echo currentLanguage() === 'es' ? 'true' : 'false'; ?>" title="<?php echo t('Español'); ?>">ES</button>
                <button type="button" class="language-selector__button <?php echo currentLanguage() === 'en' ? 'language-selector__button--active' : ''; ?>" data-language="en" aria-pressed="<?php echo currentLanguage() === 'en' ? 'true' : 'false'; ?>" title="<?php echo t('Inglés'); ?>">EN</button>
            </div>
            <form method="POST" action="/logout" class="dashboard__form">
                <input type="submit" value="<?php echo t('Cerrar sesión'); ?>" class="dashboard__submit--logout">
            </form>
        </nav>
    </div>
</header>
