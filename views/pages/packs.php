<main class="packs">
    <h2 class="packs__heading"><?php echo t($title ?? 'Paquetes'); ?></h2>
    <p class="packs__description"><?php echo t('Compara los paquetes de DevCon'); ?></p>

    <div class="packs__grid">
        <div class="pack">
            <h3 class="pack__name"><?php echo t('Entrada gratuita'); ?></h3>
            <ul class="pack__list">
                <li class="pack__element"><?php echo t('Acceso virtual a DevCon'); ?></li>
            </ul>

            <p class="pack__price">0€</p>
        </div>

        <div class="pack">
            <h3 class="pack__name"><?php echo t('Entrada presencial'); ?></h3>
            <ul class="pack__list">
                <li class="pack__element"><?php echo t('Acceso presencial a DevCon'); ?></li>
                <li class="pack__element"><?php echo t('Entrada para 2 días'); ?></li>
                <li class="pack__element"><?php echo t('Acceso a talleres y conferencias'); ?></li>
                <li class="pack__element"><?php echo t('Acceso a las grabaciones'); ?></li>
                <li class="pack__element"><?php echo t('Camisa del evento'); ?></li>
                <li class="pack__element"><?php echo t('Comida y bebida'); ?></li>
            </ul>

            <p class="pack__price">199€</p>
        </div>

        <div class="pack">
            <h3 class="pack__name"><?php echo t('Entrada virtual'); ?></h3>
            <ul class="pack__list">
                <li class="pack__element"><?php echo t('Acceso virtual a DevCon'); ?></li>
                <li class="pack__element"><?php echo t('Entrada para 2 días'); ?></li>
                <li class="pack__element"><?php echo t('Acceso a talleres y conferencias'); ?></li>
                <li class="pack__element"><?php echo t('Acceso a las grabaciones'); ?></li>
            </ul>

            <p class="pack__price">49€</p>
        </div>
    </div>
</main>