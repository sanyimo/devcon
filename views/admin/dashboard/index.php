<?php
$eventLanguage = currentLanguage();
?>

<h2 class="dashboard__heading"><?php echo t($title ?? ''); ?></h2>

<main class="blocks">
    <div class="blocks__grid">
        <div class="block">
            <h3 class="block__heading"><?php echo t('Últimos registros'); ?></h3>

            <?php foreach (($records ?? []) as $index => $record) { ?>
                <div class="block__content">
                    <p class="block__text">
                        <?php
                        $user = $users[$index] ?? null;

                        if ($user) {
                            echo htmlspecialchars(
                                $user->name . ' ' . $user->surname,
                                ENT_QUOTES,
                                'UTF-8'
                            );
                        }
                        ?>
                    </p>
                </div>
            <?php } ?>
        </div>

        <div class="block">
            <h3 class="block__heading"><?php echo t('Ingresos'); ?></h3>
            <p class="block__text--quantity"><?php echo $income ?? 0; ?> €</p>
        </div>

        <div class="block">
            <h3 class="block__heading"><?php echo t('Eventos con menos cupos disponibles'); ?></h3>
            <?php foreach (($less_availables ?? []) as $event) { ?>
                <div class="block__content">
                    <p class="block__text">
                        <?php if (is_object($event)) {
                            echo '<span class="block__name">' . htmlspecialchars(
                                ($eventLanguage === 'en' && $event->name_en)
                                    ? $event->name_en
                                    : $event->name_es,
                                ENT_QUOTES,
                                'UTF-8'
                            ) . '</span> ➤ <strong>' . htmlspecialchars((string) ($event->availables ?? ''), ENT_QUOTES, 'UTF-8') . ' ' . t('Disponibles') . '</strong>';
                        } ?>
                    </p>
                </div>
            <?php } ?>
        </div>

        <div class="block">
            <h3 class="block__heading"><?php echo t('Eventos con más cupos disponibles'); ?></h3>
            <?php foreach (($more_availables ?? []) as $event) { ?>
                <div class="block__content">
                    <p class="block__text">
                        <?php if (is_object($event)) {
                            echo '<span class="block__name">' . htmlspecialchars(
                                ($eventLanguage === 'en' && $event->name_en)
                                    ? $event->name_en
                                    : $event->name_es,
                                ENT_QUOTES,
                                'UTF-8'
                            ) . '</span> ➤ <strong>' . htmlspecialchars((string) ($event->availables ?? ''), ENT_QUOTES, 'UTF-8') . ' ' . t('Disponibles') . '</strong>';
                        } ?>
                    </p>
                </div>
            <?php } ?>
        </div>
    </div>
</main>