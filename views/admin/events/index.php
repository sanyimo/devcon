<h2 class="dashboard__heading"><?php echo t($title ?? 'Eventos'); ?></h2>

<div class="dashboard__container-btn
    <a class=" dashboard__btn" href="/admin/events/create">
    <i class="fa-solid fa-circle-plus"></i>
    <?php echo t('Añadir evento'); ?>
    </a>
</div>


<div class="dashboard__container">
    <?php if (!empty($events)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th"><?php echo t('Evento'); ?></th>
                    <th scope="col" class="table__th"><?php echo t('Categoría'); ?></th>
                    <th scope="col" class="table__th"><?php echo t('Día y hora'); ?></th>
                    <th scope="col" class="table__th"><?php echo t('Ponente'); ?></th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($events as $event) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $event->name; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $event->category->name; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $event->day->name . ", " . $event->hour->hour; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $event->speaker->name . " " . $event->speaker->surname; ?>
                        </td>
                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/admin/events/edit?id=<?php echo $event->id; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                <?php echo t('Editar'); ?>
                            </a>

                            <form method="POST" action="/admin/events/delete" class="table__form">
                                <input type="hidden" name="id" value="<?php echo $event->id; ?>">
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
        <p class="text-center"><?php echo t('No hay eventos aún'); ?></p>
    <?php } ?>
</div>

<?php echo $pagination ?? ''; ?>