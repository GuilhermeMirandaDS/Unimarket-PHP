<?= view('components/header.php', ['notTransp' => 'class="not-transp"']) ?>
<main class="site-main event-page">
    <div class="container">
        <div class="evento-wrapper">
            <div class="full-image-swiper">
                <?php
                    $image_names = $evento->imageCard[0]; 
                    $base_url_images = base_url('uploads/events/'); // URL base para as imagens
                    $image_url = $base_url_images . pathinfo($image_names, PATHINFO_FILENAME) . '-600.webp';
                ?>
                
                <img src="<?= $image_url ?>">
            </div>
            <div class="product-info">

                <h1 class="product-name"><?= $evento->nome ?></h1>

                <p class="product-desc"><?= $evento->descricao ?></p>

                <div class="actions" >
                    <div class="product-buy">
                        <a href="<?= $evento->nome ?>" type="submit">Inscrição</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="product-related">

        </div>
    </div>
</main>
<?= view('components/footer.php') ?>