<h2 class="dashboard__heading"><?php echo $title ?? 'Editar evento'; ?></h2>

<div class="dashboard__container-btn">
    <a class="dashboard__btn" href="/admin/events">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__form">
    <?php 
        include_once __DIR__ . './../../templates/alerts.php';
    ?>

    <form method="POST" class="form">
        <?php include_once __DIR__ . '/form.php'; ?>

        <input class="form__submit form__submit--register" type="submit" value="Guardar cambios ">
    </form>
</div>