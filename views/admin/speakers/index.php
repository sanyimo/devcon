<h2 class="dashboard__heading"><?php echo t($title ?? 'Ponentes'); ?></h2>

<div class="dashboard__container-btn">
    <a class="dashboard__btn" href="/admin/speakers/create">
    <i class="fa-solid fa-circle-plus"></i>
    <?php echo t('Añadir ponente'); ?>
    </a>
</div>

<div class="dashboard__container">
    <?php if (!empty($speakers)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th"><?php echo t('Nombre'); ?></th>
                    <th scope="col" class="table__th"><?php echo t('Ubicación'); ?></th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($speakers as $speaker) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $speaker->name . " " . $speaker->surname; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $speaker->city . ", " . $speaker->country; ?>
                        </td>
                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/admin/speakers/edit?id=<?php echo $speaker->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                <?php echo t('Editar'); ?>
                            </a>

                            <form method="POST" action="/admin/speakers/delete" class="table__form" data-confirm-message="<?php echo htmlspecialchars(t('Esta acción eliminará este ponente. ¿Continuar?'), ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="id" value="<?php echo $speaker->id; ?>">
                                <button class="table__action table__action--delete" type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    <?php echo t('Eliminar'); ?>
                                </button>
                            </form>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center"><?php echo t('No hay ponentes aún'); ?></p>
    <?php } ?>
</div>

<?php
if (isset($pagination)) {
    echo $pagination;
}
?>