<h2 class="dashboard__heading"><?php echo t($title ?? 'create regalo'); ?></h2>

<div class="dashboard__container-btn">
    <a class="dashboard__btn" href="/admin/gifts">
        <i class="fa-solid fa-circle-arrow-left"></i>
        <?php echo t('Volver'); ?>
    </a>
</div>

<div class="dashboard__form">
    <?php
    include_once __DIR__ . '/../../templates/alerts.php';
    ?>

    <form method="POST" action="/admin/gifts/create" class="form">
        <?php include_once __DIR__ . '/form.php'; ?>

        <input class="form__submit form__submit--register" type="submit" value="<?php echo t('Registrar regalo'); ?>">
    </form>
</div>