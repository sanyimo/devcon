<h2 class="dashboard__heading"><?php echo $title ?? 'Registros'; ?></h2>

<div class="dashboard__container">
    <?php if(!empty($records)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">E-mail</th>
                    <th scope="col" class="table__th">Plan</th>
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
        <p class="text-center">No hay registros aún</p>
    <?php } ?>
</div>

<?php 
    if (isset($pagination)) {
        echo $pagination;
    }
?>