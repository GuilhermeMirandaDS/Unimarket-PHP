<div class="showcase">
    <div class="container">
        <div class="showcase-name section-title"><?= esc($title) ?></div>
        <div class="eventos-swiper swiper">
            <div class="swiper-wrapper">
                <?php foreach ($eventos as $item): ?>
                    <div class="swiper-slide">
                        <div class="evento">
                            <a href="<?= base_url('/eventos/' . $item->id) ?>">
                                <div class="space-image">
                                    <?php 
                                        // Assumindo que $item é o objeto/array do produto carregado
                                        $image_names = $item->imageCard[0]; 
                                        $base_url_images = base_url('uploads/events/'); // URL base para as imagens

                                        $image_url = $base_url_images . pathinfo($image_names, PATHINFO_FILENAME) . '-600.webp';
                                    ?>

                                    <img src="<?= $image_url ?>">
                                                
                                </div>
                            </a>

                            <div class="evento-info">
                                <a href="<?= base_url('/eventos/' . $item->id) ?>">
                                    <h3 class="evento-name"><?= esc($item->nome) ?></h3>
                                </a>

                                <p class="evento-desc"><?= esc($item->local) ?></p>

                                <p class="evento-data"><?= format_date_br($item->data) ?>, às <?= format_time($item->horario) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>