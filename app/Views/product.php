<?php helper('number'); ?>
<?= view('components/header.php', ['notTransp' => 'class="not-transp"']) ?>
<main class="site-main">
    <div class="container">
        <div class="product-wrapper">
            <div class="product-gallery">
                <div class="full-image-swiper swiper">
                    <div class="swiper-wrapper">
                        <?php
                            $image_names = $product->images; 
                            $base_url_images = base_url('uploads/products/'); // URL base para as imagens
                        ?>
                        <?php foreach ($image_names as $key=>$image_name): ?>

                            <?php if($key == 0): ?>

                                <?php $image_url = $base_url_images . pathinfo($image_name, PATHINFO_FILENAME) . '-600.webp'; ?>

                                <div class="swiper-slide">
                                    <img src="<?= $image_url ?>">
                                </div>
                                    
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="thumb-swiper swiper">
                    <div class="swiper-wrapper">
                        <?php
                            $image_names = $product->images; 
                            $base_url_images = base_url('uploads/products/'); // URL base para as imagens
                        ?>
                        <?php foreach ($image_names as $key=>$image_name): ?>

                            <?php if($key == 0): ?>

                                <?php $image_url = $base_url_images . pathinfo($image_name, PATHINFO_FILENAME) . '-128.webp'; ?>

                                <div class="swiper-slide thumb">
                                    <img src="<?= $image_url ?>">
                                </div>
                                    
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="product-info">

                <h1 class="product-name"><?= $product->nome ?></h1>

                <p class="product-desc"><?= $product->descricao ?></p>

                <?php if ($product->tags): 
                    $tagList = explode(" ", $product->tags);
                ?>
                    <div class="tags">
                        <?php for ($i=0; $i < sizeof($tagList); $i++): ?>
                            <a href="<?php echo base_url('/products?query=' . $tagList[$i]) ?>">
                                <div class="tag"><?= $tagList[$i] ?></div>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>

                <div class="actions">
                    <form action="" method="POST" >

                        <span class="product-price"><?= number_to_currency((float)$product->preco, 'BRL', 'en-US') ?></span>

                        <div class="box-quantidade">
                            <input type="number" name="quantidade">
                        </div>

                        <button type="submit">Comprar agora</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="product-related">

        </div>
    </div>

    <div class="container">
        <?= view('components/avaliacoes.php') ?>
    </div>
</main>
<?= view('components/footer.php') ?>