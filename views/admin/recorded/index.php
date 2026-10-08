<h2 class="dashboard__heading"><?php echo t($title ?? 'Registros'); ?></h2>

<div class="dashboard__container">
    <?php if(!empty($records)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th"><?php echo t('Nombre'); ?></th>
                    <th scope="col" class="table__th"><?php echo t('E-mail'); ?></th>
                    <th scope="col" class="table__th"><?php echo t('Plan'); ?></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($records as $record) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $record->user->name . " " . $record->user->surname; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $record->user->email; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $record->pack->name; ?>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center"><?php echo t('No hay registros aún'); ?></p>
    <?php } ?>
</div>

<?php 
    if (isset($pagination)) {
        echo $pagination;
    }
?>