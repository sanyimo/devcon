<?php
$eventLanguage = currentLanguage();
?>

<h2 class="dashboard__heading"><?php echo t($title ?? 'Regalos'); ?></h2>

<div class="dashboard__graph">
    <canvas id="gifts-graph" width="400" height="400"></canvas>
</div>

<div class="dashboard__container">
    <div class="dashboard__container-btn">
        <a class="dashboard__btn" href="/admin/gifts/create">
            <i class="fa-solid fa-circle-plus"></i>
            <?php echo t('Crear regalo'); ?>
        </a>
    </div>

    <?php if (!empty($gifts)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th"><?php echo t('Regalo'); ?></th>
                    <th scope="col" class="table__th"><?php echo t('Distribuidos'); ?></th>
                    <th scope="col" class="table__th"><?php echo t('Restantes'); ?></th>
                    <th scope="col" class="table__th"><?php echo t('Total'); ?></th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($gifts as $gift) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $eventLanguage === 'en' && $gift->name_en ? $gift->name_en : $gift->name_es; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $gift->reserved; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $gift->availables; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $gift->quantity; ?>
                        </td>

                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/admin/gifts/edit?id=<?php echo $gift->id; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                <?php echo t('Editar'); ?>
                            </a>

                            <form method="POST" action="/admin/gifts/delete" data-confirm-message="<?php echo htmlspecialchars(t('Esta acción eliminará este regalo. ¿Continuar?'), ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="id" value="<?php echo $gift->id; ?>">

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
        <p class="text-center"><?php echo t('No hay regalos aún'); ?></p>
    <?php } ?>
</div>