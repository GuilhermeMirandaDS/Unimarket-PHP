<?php helper('number'); ?>
<?= view('components/header.php', ['notTransp' => 'class="not-transp"']) ?>
<main class="site-main product-page">
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

                            <?php $image_url = $base_url_images . pathinfo($image_name, PATHINFO_FILENAME) . '-600.webp'; ?>

                            <div class="swiper-slide">
                                <img src="<?= $image_url ?>">
                            </div>

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

                            <?php $image_url = $base_url_images . pathinfo($image_name, PATHINFO_FILENAME) . '-128.webp'; ?>

                            <div class="swiper-slide thumb">
                                <img src="<?= $image_url ?>">
                            </div>

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
                                <div class="tag">#<?= $tagList[$i] ?></div>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>

                <input type="hidden" class="estoque-input" name="estoque" value="<?= $product->estoque ?>">

                <form action="" method="POST" class="actions" >

                    <span class="product-price">R$ <?php $preco = str_replace('.', ',', $product->preco) ?> <?= esc($preco) ?></span>

                    <div class="box-quantidade">
                        <button type="button" id="menosBtn" data-type="menos">-</button>
                        <input type="number" name="quantidade" class="quant-input" value="1">
                        <button type="button" id="maisBtn" data-type="mais">+</button>
                    </div>

                    <div class="product-buy">
                        <button type="submit">Comprar agora</button>
                    </div>
                </form>

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