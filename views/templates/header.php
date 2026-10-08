<?php

    use Model\Record;

    $record = null;

    if(is_auth() && !is_admin()) {
        $record = Record::where('user_id', $_SESSION['id']);
    }
?>

<header id="top" class="header">
    <div class="header__container">
        <nav class="header__navigation">

            <?php if(is_auth()) { ?>
                <a href="<?php echo is_admin() ? '/admin/dashboard' : ($record ? '/ticket?id=' . urlencode($record->token) : '/purchase'); ?>" class="header__link"><?php echo t('Administrar'); ?></a>
                <form method="POST" action="/logout" class="header__form">
                    <input type="submit" value="<?php echo t('Cerrar sesión'); ?>" class="header__submit">
                </form>
            <?php } else { ?>
                <a href="/register" data-aos="zoom-out" class="header__link"><?php echo t('Registro'); ?></a>
                <a href="/login" data-aos="zoom-out" class="header__link"><?php echo t('Iniciar sesión'); ?></a>
            <?php } ?>

            <div class="language-selector">
                <button type="button" class="language-selector__button <?php echo currentLanguage() === 'es' ? 'language-selector__button--active' : ''; ?>" data-language="es" aria-pressed="<?php echo currentLanguage() === 'es' ? 'true' : 'false'; ?>" title="<?php echo t('Español'); ?>">ES</button>
                <button type="button" class="language-selector__button <?php echo currentLanguage() === 'en' ? 'language-selector__button--active' : ''; ?>" data-language="en" aria-pressed="<?php echo currentLanguage() === 'en' ? 'true' : 'false'; ?>" title="<?php echo t('Inglés'); ?>">EN</button>
            </div>
        </nav>

        <div class="header__content">
            <a href="/">
                <h1 data-aos="zoom-in-right" class="header__logo">
                    &#60;DevCon />
                </h1>
            </a>

            <p data-aos="zoom-in-right" class="header__text"><?php echo t('8-9 octubre 2027'); ?></p>
            <p data-aos="zoom-in-right" class="header__text header__text--modality"><?php echo t('En Línea - Presencial'); ?></p>

            <a href="<?php echo is_auth() ? '/purchase' : '/register'; ?>" class="header__btn"><?php echo t('Conseguir entradas'); ?></a>
        </div>
    </div>
</header>

<div class="bar">
    <div class="bar__content">
        <a href="/">
            <h2 class="bar__logo">
                &#60;DevCon />
            </h2>
        </a>
        <nav class="navigation">
            <a href="/devcon" class="navigation__link <?php echo current_page('/devcon') ? 'navigation__link--current' : ''; ?>"><?php echo t('Evento'); ?></a>
            <a href="/packs" class="navigation__link <?php echo current_page('/packs') ? 'navigation__link--current' : ''; ?>"><?php echo t('Paquetes'); ?></a>
            <a href="/workshops-conferences" class="navigation__link <?php echo current_page('/workshops-conferences') ? 'navigation__link--current' : ''; ?>"><?php echo t('Workshops / Conferencias'); ?></a>
            <a href="<?php echo is_auth() ? '/purchase' : '/register'; ?>" class="navigation__link <?php echo current_page('/purchase') ? 'navigation__link--current' : ''; ?>"><?php echo t('Entradas'); ?></a>
        </nav>
    </div>
</div>