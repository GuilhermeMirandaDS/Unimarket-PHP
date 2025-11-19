<div class="product">
    <div class="space-image">
        <a href="<?= base_url('/products/' . $product->id) ?>">
            <?php 
                // Assumindo que $product é o objeto/array do produto carregado
                $image_names = $product->images; 
                $base_url_images = base_url('uploads/products/'); // URL base para as imagens
            ?>
            <?php foreach ($image_names as $key=>$image_name): ?>

                <?php if($key == 0): ?>

                    <?php $image_url = $base_url_images . pathinfo($image_name, PATHINFO_FILENAME) . '-600.webp'; ?>

                    <img src="<?= $image_url ?>">
                        
                <?php endif; ?>

            <?php endforeach; ?>
        </a>
    </div>

    <div class="product-info">
        <a href="<?= base_url('/products/' . $product->id) ?>">
            <h3 class="product-name"><?= esc($product->nome) ?></h3>
        </a>
        <div class="vendedor">

            <span class="vendedor-text">Vendedor(a):</span>
            
            <div class="vendedor-info">
                <div class="vendedor-image">
                    <?php if($product->vendedor->images[0]): ?>

                        <?php
                            $image_name = $product->vendedor->images[0]; 
                            $base_url_images = base_url('uploads/users/');
                        ?>

                        <?php $image_url = $base_url_images . pathinfo($image_name, PATHINFO_FILENAME) . '-128.webp'; ?>

                        <img src="<?= $image_url ?>" alt="userPFP"/>

                    <?php else: ?>
                        <img src="<?php base_url('/assets/img/no-image.png') ?>" alt="userPFP"/>
                    <?php endif; ?>
                </div>
                <div class="vendedor-name">
                    <span><?= esc($product->vendedor->name) ?></span>
                    <?php
                    
                        $tag = $product->vendedor->tag;

                        if ($tag == 1){
                            $tag = 'Aluno';
                        } elseif ($tag == 2) {
                            $tag = 'Funcionário';
                        }
                    
                    ?>
                    <p><?= esc($tag) ?></p>
                </div>
            </div>

        </div>

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

        <div class="product-footer">
            <p class="product-price">R$ <?php $preco = str_replace('.', ',', $product->preco) ?> <?= esc($preco) ?></p>

            <div class="actions">
                <button type="button" class="fav">
                    <svg fill="#000000" width="20px" height="20px" viewBox="0 0 24 24" id="favourite" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color"><path id="primary" d="M19.57,5.44a4.91,4.91,0,0,1,0,6.93L12,20,4.43,12.37A4.91,4.91,0,0,1,7.87,4a4.9,4.9,0,0,1,3.44,1.44,4.46,4.46,0,0,1,.69.88,4.46,4.46,0,0,1,.69-.88,4.83,4.83,0,0,1,6.88,0Z" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></svg>
                </button>

                <a class="btn-buy-card" href="<?= base_url('/products/' . $product->id) ?>">
                    <svg width="30" height="30" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.875 16.25C4.42812 16.25 4.04557 16.0909 3.72734 15.7727C3.40911 15.4544 3.25 15.0719 3.25 14.625C3.25 14.1781 3.40911 13.7956 3.72734 13.4773C4.04557 13.1591 4.42812 13 4.875 13C5.32187 13 5.70443 13.1591 6.02266 13.4773C6.34088 13.7956 6.5 14.1781 6.5 14.625C6.5 15.0719 6.34088 15.4544 6.02266 15.7727C5.70443 16.0909 5.32187 16.25 4.875 16.25ZM13 16.25C12.5531 16.25 12.1706 16.0909 11.8523 15.7727C11.5341 15.4544 11.375 15.0719 11.375 14.625C11.375 14.1781 11.5341 13.7956 11.8523 13.4773C12.1706 13.1591 12.5531 13 13 13C13.4469 13 13.8294 13.1591 14.1477 13.4773C14.4659 13.7956 14.625 14.1781 14.625 14.625C14.625 15.0719 14.4659 15.4544 14.1477 15.7727C13.8294 16.0909 13.4469 16.25 13 16.25ZM4.18437 3.25L6.13437 7.3125H11.8219L14.0562 3.25H4.18437ZM3.4125 1.625H15.3969C15.7083 1.625 15.9453 1.7638 16.1078 2.04141C16.2703 2.31901 16.2771 2.6 16.1281 2.88437L13.2437 8.08437C13.0948 8.35521 12.8951 8.5651 12.6445 8.71406C12.394 8.86302 12.1198 8.9375 11.8219 8.9375H5.76875L4.875 10.5625H14.625V12.1875H4.875C4.26562 12.1875 3.80521 11.9201 3.49375 11.3852C3.18229 10.8503 3.16875 10.3188 3.45312 9.79063L4.55 7.8L1.625 1.625H0V0H2.64062L3.4125 1.625Z" fill="white"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>