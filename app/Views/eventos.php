<?= view('components/header.php', ['notTransp' => 'class="not-transp"']) ?>
<main class="site-main">
    <div class="banner-eventos">
        <div class="container">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php
                        foreach($eventos as $item):
                            $image_name = $item->images[0]; 
                            $base_url_images = base_url('uploads/events/'); // URL base para as imagens
    
                            $image_url = $base_url_images . pathinfo($image_name, PATHINFO_FILENAME) . '.png';
                    ?>
                        <?php
                            $banner = $image_url;
                            $link = base_url('eventos/' . $item->id);
                            $title = $item->nome;
                            $date_init = format_date_br($item->data);
                            $hour_init = format_time($item->horario);
                        ?>
    
                        <div class="swiper-slide item">
                            <div class="item">
                                <a href="<?= esc($link) ?>">
                                    <img src="<?= esc($banner) ?>">
                                    <div class="info">
                                        <h2 class="banner-eventos-title"><?= esc($title) ?></h2>
                                        <div class="data-evento">
                                            <div class="data">
                                                <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 7H17M1 7V15.8002C1 16.9203 1 17.4801 1.21799 17.9079C1.40973 18.2842 1.71547 18.5905 2.0918 18.7822C2.5192 19 3.07899 19 4.19691 19H13.8031C14.921 19 15.48 19 15.9074 18.7822C16.2837 18.5905 16.5905 18.2842 16.7822 17.9079C17 17.4805 17 16.9215 17 15.8036V7M1 7V6.2002C1 5.08009 1 4.51962 1.21799 4.0918C1.40973 3.71547 1.71547 3.40973 2.0918 3.21799C2.51962 3 3.08009 3 4.2002 3H5M17 7V6.19691C17 5.07899 17 4.5192 16.7822 4.0918C16.5905 3.71547 16.2837 3.40973 15.9074 3.21799C15.4796 3 14.9203 3 13.8002 3H13M13 1V3M13 3H5M5 1V3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                <span><?= esc($date_init) ?></span>
                                            </div>
                                            |
                                            <div class="hora">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 19L18 21M20 12C20 14.1218 19.1572 16.1566 17.6569 17.6569C16.1566 19.1572 14.1217 20 12 20C9.87829 20 7.84345 19.1572 6.34316 17.6569C4.84287 16.1566 4.00002 14.1218 4.00002 12C3.99649 10.8618 4.23867 9.73613 4.71002 8.70003C5.51172 6.92405 6.93404 5.50173 8.71002 4.70003C9.74682 4.23054 10.8719 3.98769 12.01 3.98769C13.1482 3.98769 14.2732 4.23054 15.31 4.70003C17.086 5.50173 18.5083 6.92405 19.31 8.70003C19.7745 9.73766 20.0098 10.8632 20 12V12ZM6.00002 3.00003C5.32247 3.004 4.66622 3.23721 4.13811 3.66169C3.61 4.08617 3.24114 4.67693 3.09158 5.33778C2.94202 5.99862 3.02057 6.69064 3.31444 7.30115C3.60832 7.91166 4.1002 8.40471 4.71002 8.70003C5.51172 6.92405 6.93404 5.50173 8.71002 4.70003C8.46471 4.18985 8.08007 3.75949 7.60052 3.45867C7.12098 3.15784 6.56611 2.99884 6.00002 3.00003ZM18 3.00003C17.4346 3.00163 16.8811 3.16301 16.4034 3.46556C15.9256 3.76811 15.5432 4.19951 15.3 4.71003C17.076 5.51173 18.4983 6.93405 19.3 8.71003C19.9163 8.41743 20.4144 7.92354 20.7122 7.30982C21.0101 6.69609 21.0898 5.99919 20.9384 5.33403C20.787 4.66887 20.4134 4.07519 19.8792 3.65089C19.345 3.22659 18.6822 2.99702 18 3.00003V3.00003ZM8.00002 19L6.00002 21L8.00002 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 8V12L14 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                <span><?= esc($hour_init) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <?= view('components/eventos-showcase.php', [
        'eventos' => $proximos,
        'title' => 'Próximos eventos:'
    ]) ?>

    <div class="evento-destaque">
        <div class="container">
            <div class="showcase-name section-title">Você pode se interessar:</div>
            <div class="destaque-content">
                <div class="evento-wrapper">
                    <div class="full-image-swiper">
                        <?php
                            foreach ($eventoDestaque as $key => $value) {
                                
                                $image_names = $value->imageCard[0]; 
                                $base_url_images = base_url('uploads/events/'); // URL base para as imagens
                                $image_url = $base_url_images . pathinfo($image_names, PATHINFO_FILENAME) . '-600.webp';
                        ?>
                        
                        <img src="<?= $image_url ?>">
                    </div>
                    <div class="product-info">

                        <h1 class="product-name"><?= $value->nome ?></h1>

                        <p class="product-desc"><?= $value->descricao ?></p>

                        <p class="product-desc"><?= $value->local ?></p>

                        <div class="evento-data">
                            <div class="data">
                                <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 7H17M1 7V15.8002C1 16.9203 1 17.4801 1.21799 17.9079C1.40973 18.2842 1.71547 18.5905 2.0918 18.7822C2.5192 19 3.07899 19 4.19691 19H13.8031C14.921 19 15.48 19 15.9074 18.7822C16.2837 18.5905 16.5905 18.2842 16.7822 17.9079C17 17.4805 17 16.9215 17 15.8036V7M1 7V6.2002C1 5.08009 1 4.51962 1.21799 4.0918C1.40973 3.71547 1.71547 3.40973 2.0918 3.21799C2.51962 3 3.08009 3 4.2002 3H5M17 7V6.19691C17 5.07899 17 4.5192 16.7822 4.0918C16.5905 3.71547 16.2837 3.40973 15.9074 3.21799C15.4796 3 14.9203 3 13.8002 3H13M13 1V3M13 3H5M5 1V3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <span><?= esc($date_init) ?></span>
                            </div>
                            |
                            <div class="hora">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 19L18 21M20 12C20 14.1218 19.1572 16.1566 17.6569 17.6569C16.1566 19.1572 14.1217 20 12 20C9.87829 20 7.84345 19.1572 6.34316 17.6569C4.84287 16.1566 4.00002 14.1218 4.00002 12C3.99649 10.8618 4.23867 9.73613 4.71002 8.70003C5.51172 6.92405 6.93404 5.50173 8.71002 4.70003C9.74682 4.23054 10.8719 3.98769 12.01 3.98769C13.1482 3.98769 14.2732 4.23054 15.31 4.70003C17.086 5.50173 18.5083 6.92405 19.31 8.70003C19.7745 9.73766 20.0098 10.8632 20 12V12ZM6.00002 3.00003C5.32247 3.004 4.66622 3.23721 4.13811 3.66169C3.61 4.08617 3.24114 4.67693 3.09158 5.33778C2.94202 5.99862 3.02057 6.69064 3.31444 7.30115C3.60832 7.91166 4.1002 8.40471 4.71002 8.70003C5.51172 6.92405 6.93404 5.50173 8.71002 4.70003C8.46471 4.18985 8.08007 3.75949 7.60052 3.45867C7.12098 3.15784 6.56611 2.99884 6.00002 3.00003ZM18 3.00003C17.4346 3.00163 16.8811 3.16301 16.4034 3.46556C15.9256 3.76811 15.5432 4.19951 15.3 4.71003C17.076 5.51173 18.4983 6.93405 19.3 8.71003C19.9163 8.41743 20.4144 7.92354 20.7122 7.30982C21.0101 6.69609 21.0898 5.99919 20.9384 5.33403C20.787 4.66887 20.4134 4.07519 19.8792 3.65089C19.345 3.22659 18.6822 2.99702 18 3.00003V3.00003ZM8.00002 19L6.00002 21L8.00002 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 8V12L14 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <span><?= esc($hour_init) ?></span>
                            </div>
                        </div>

                        <div class="actions" >
                            <a href="<?= esc($value->link) ?>" class="evento-link">Inscreva-se</a>
                        </div>

                    </div>
                    <?php }; ?>
                </div>
            </div>
        </div>
    </div>

    <?= view('components/eventos-showcase.php', [
        'eventos' => $eventos,
        'title' => 'Imperdíveis:'
    ]) ?>
</main>

<?= view('components/footer.php') ?>