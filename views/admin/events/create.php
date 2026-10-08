<h2 class="dashboard__heading"><?php echo t($title ?? 'create evento'); ?></h2>

<div class="dashboard__container-btn">
    <a class="dashboard__btn" href="/admin/events">
        <i class="fa-solid fa-circle-arrow-left"></i>
        <?php echo t('Volver'); ?>
    </a>
</div>

<div class="dashboard__form">
    <?php 
        include_once __DIR__ . './../../templates/alerts.php';
    ?>

    <form method="POST" action="/admin/events/create" class="form">
        <?php include_once __DIR__ . '/form.php'; ?>

        <input class="form__submit form__submit--register" type="submit" value="<?php echo t('Registrar evento'); ?>">
    </form>
</div>