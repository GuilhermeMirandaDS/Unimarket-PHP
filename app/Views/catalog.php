<?= view('components/header.php', ['notTransp' => 'class="not-transp"']) ?>
<div class="catalog">
    <div class="smartfilter">

    </div>

    <div class="products">
        <div class="section-title"> Resultados de: <b><?= esc($query) ?></b></div>
        <div class="list-product">
            <?php foreach ($products as $item): ?>
                <div class="product-20">
                    <?= view('components/product-card', ['product' => $item]) ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= view('components/footer.php') ?>