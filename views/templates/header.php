<header class="header">
    <div class="header__container">
        <nav class="header__navegation">

            <?php if(is_auth()) { ?>
                <a href="<?php echo is_admin() ? '/admin/dashboard' : '/finish-record'; ?>" class="header__link"><?php echo t('Administrar'); ?></a>
                <form method="POST" action="/logout" class="header__form">
                    <input type="submit" value="<?php echo t('Cerrar sesión'); ?>" class="header__submit">
                </form>
            <?php } else { ?>
                <a href="/record" data-aos="zoom-out" class="header__link"><?php echo t('Registro'); ?></a>
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

            <p data-aos="zoom-in-right" class="header__text">8-9 octubre 2027</p>
            <p data-aos="zoom-in-right" class="header__text header__text--modality">En Línea - Presencial</p>

            <a href="/record" class="header__btn">Conseguir entradas</a>
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
        <nav class="navegation">
            <a href="/devcon" class="navegation__link <?php echo current_page('/devcon') ? 'navegation__link--current' : ''; ?>"><?php echo t('Evento'); ?></a>
            <a href="/packs" class="navegation__link <?php echo current_page('/packs') ? 'navegation__link--current' : ''; ?>"><?php echo t('Paquetes'); ?></a>
            <a href="/workshops-conferences" class="navegation__link <?php echo current_page('/workshops-conferences') ? 'navegation__link--current' : ''; ?>"><?php echo t('Workshops / Conferencias'); ?></a>
            <a href="/record" class="navegation__link <?php echo current_page('/record') ? 'navegation__link--current' : ''; ?>"><?php echo t('Entradas'); ?></a>
        </nav>
    </div>
</div>
