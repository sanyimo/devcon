<main class="devcon">
    <h2 class="devcon__heading"><?php echo $title ?? 'DevCon'; ?></h2>
    <p class="devcon__description">Conoce la conferencia más importante de Europa</p>

    <div class="devcon__grid">
        <div <?php aos_animation(); ?> class="devcon__image">
            <picture>
                <source srcset="build/img/about_devcon.avif" type="image/avif">
                <source srcset="build/img/about_devcon.webp" type="image/webp">
                <img loading="lazy" width="200" height="300" src="build/img/about_devcon.jpg" alt="Imagen DevCon">
            </picture>
        </div>

        <div class="devcon__content">
            <p <?php aos_animation(); ?> class="devcon__text">Aliquam est elit, condimentum a justo vitae, fringilla dignissim tortor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam quis lorem eget felis dignissim dignissim. Praesent ac lorem convallis, ultrices neque quis, cursus lorem.</p>

            <p <?php aos_animation(); ?> class="devcon__text">Aliquam est elit, condimentum a justo vitae, fringilla dignissim tortor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam quis lorem eget felis dignissim dignissim. Praesent ac lorem convallis, ultrices neque quis, cursus lorem.</p>
        </div>
    </div>
</main>