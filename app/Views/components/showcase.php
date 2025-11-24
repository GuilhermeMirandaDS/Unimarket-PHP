<div class="showcase <?= esc($bg) ?>">
    <div class="container">
        <div class="showcase-name <?= esc($bg) ?> section-title"><?= esc($title) ?></div>
        <div class="products-swiper swiper">
            <div class="swiper-wrapper">
                <?php foreach ($prodShow as $item): ?>
                    <div class="swiper-slide">
                        <?= view('components/product-card', ['product' => $item]) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>