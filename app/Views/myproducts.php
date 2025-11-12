<?= view('components/header.php', ['notTransp' => 'class="not-transp"']) ?>
<div class="site-main">
    <div class="container">
        <div class="presentation">
            <div class="pres-text">
                <h1>Olá, <b><?= esc($user->name) ?></b>!</h1>
                <p>Bem-vindo(a) ao perfil de vendedor</p>
            </div>
            <button id="addProduct">Adicionar produto +</button>
        </div>
        <div class="products">
            <div class="section-title">Meus produtos:</div>
            <div class="list-product">
                <?php foreach ($products as $item): ?>
                    <div class="item">
                        <div class="space-image">
                            <img src="<?= base_url('assets/img/no-image.png') ?>">
                            <!-- esc($item->linked->image) ?? base_url('assets/img/no-image.png') -->
                        </div>

                        <div class="product-info">
                            <h3 class="product-name"><?= esc($item->nome) ?></h3>
                    
                            <div class="product-footer">
                                <p class="product-price">R$ <?php $preco = str_replace('.', ',', $item->preco) ?> <?= esc($preco) ?></p>
                    
                                <div class="actions">
                                    <button type="button" class="fav">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.47 6.9958L12.71 11.2358L5.24 18.7058H1V14.4658L8.47 6.9958ZM18.41 4.1158L15.59 1.2958C15.497 1.20207 15.3864 1.12768 15.2646 1.07691C15.1427 1.02614 15.012 1 14.88 1C14.748 1 14.6173 1.02614 14.4954 1.07691C14.3736 1.12768 14.263 1.20207 14.17 1.2958L11.29 4.1758L15.53 8.4158L18.41 5.5358C18.5037 5.44284 18.5781 5.33223 18.6289 5.21037C18.6797 5.08852 18.7058 4.95781 18.7058 4.8258C18.7058 4.69379 18.6797 4.56308 18.6289 4.44122C18.5781 4.31936 18.5037 4.20876 18.41 4.1158V4.1158Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                    
                                    <button class="btn-buy-card">
                                        <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 9V15M1 5H17H1ZM13 5V2C13 1.73478 12.8946 1.48043 12.7071 1.29289C12.5196 1.10536 12.2652 1 12 1H6C5.73478 1 5.48043 1.10536 5.29289 1.29289C5.10536 1.48043 5 1.73478 5 2V5H13ZM14.07 18.07L15 5H3L3.93 18.07C3.94775 18.3229 4.06089 18.5596 4.24653 18.7323C4.43218 18.9049 4.67648 19.0006 4.93 19H13.07C13.3235 19.0006 13.5678 18.9049 13.7535 18.7323C13.9391 18.5596 14.0523 18.3229 14.07 18.07V18.07Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="overlay"></div>
<div class="modal-product">
    <div class="modal-title">
        <h2 class="section-title">Adicionar Produto</h2>
        <button id="closeModal"><svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.86667 18.6667L0 16.8L7.46667 9.33333L0 1.86667L1.86667 0L9.33333 7.46667L16.8 0L18.6667 1.86667L11.2 9.33333L18.6667 16.8L16.8 18.6667L9.33333 11.2L1.86667 18.6667Z" fill="#1D1B20"/></svg></button>
    </div>
    <div class="modal-content">
        <form action="/my-products/add" method="post" class="add-product" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="left">
                <input type="hidden" name="vendedor" value="<?= $user->ra ?>">
                <div class="campo">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nomeProduct" placeholder="Digite o nome do seu produto" required>
                </div>

                <div class="campo">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" id="descProduct" placeholder="Digite a descrição do seu produto" required></textarea>
                </div>

                <div class="campo">
                    <label for="categoria">Categoria</label>
                    <select name="categoria" id="catProduct">
                        <option selected disable>Escolha a categoria do seu produto</option>
                        <?php foreach($categories as $categorie): ?>
                        <option value="<?= esc($categorie->id) ?>"><?= esc($categorie->nome) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="campo">
                    <label for="estoque">Quantidade em Estoque</label>
                    <input type="number" name="estoque" id="estoqueProd" placeholder="Ex.: 15" required>
                </div>

                <div class="campo">
                    <label for="preco">Preço</label>
                    <input type="number" name="preco" id="precoProd" placeholder="Ex.: 100.00" required>
                </div>
            </div>

            <div class="right">
                <div class="campo">
                    <label for="images">Fotos do Produto</label>
                    <div class="msg">Adicione até 5 imagens (a primeira imagem será a principal)</div>
                    <div class="box-upload">
                        <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 2V16C19 16.2652 18.8946 16.5196 18.7071 16.7071C18.5196 16.8946 18.2652 17 18 17H2C1.73478 17 1.48043 16.8946 1.29289 16.7071C1.10536 16.5196 1 16.2652 1 16V2C1 1.73478 1.10536 1.48043 1.29289 1.29289C1.48043 1.10536 1.73478 1 2 1H18C18.2652 1 18.5196 1.10536 18.7071 1.29289C18.8946 1.48043 19 1.73478 19 2ZM8.51 11.8L13.71 17H18C18.2652 17 18.5196 16.8946 18.7071 16.7071C18.8946 16.5196 19 16.2652 19 16V12.73L13.29 7L8.51 11.8ZM1 13.71V16C1 16.2652 1.10536 16.5196 1.29289 16.7071C1.48043 16.8946 1.73478 17 2 17H13.71L5.71 9L1 13.71Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Arraste a imagem aqui</span>
                        <p>ou</p>
                        <input type="file" name="images" id="fotosProduct" accept="image/jpg">
                    </div>
                    <div class="aviso-fotos">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.0003 8.99996V13V8.99996ZM10.2503 4.18996L2.6303 18C2.45398 18.3053 2.36153 18.6519 2.36231 19.0045C2.36309 19.3571 2.45708 19.7032 2.63475 20.0078C2.81242 20.3124 3.06745 20.5645 3.374 20.7388C3.68054 20.913 4.02771 21.0031 4.3803 21H19.6203C19.9729 21.0031 20.3201 20.913 20.6266 20.7388C20.9332 20.5645 21.1882 20.3124 21.3659 20.0078C21.5435 19.7032 21.6375 19.3571 21.6383 19.0045C21.6391 18.6519 21.5466 18.3053 21.3703 18L13.7503 4.18996C13.5773 3.87735 13.3238 3.61679 13.0161 3.43534C12.7083 3.2539 12.3576 3.1582 12.0003 3.1582C11.643 3.1582 11.2923 3.2539 10.9845 3.43534C10.6768 3.61679 10.4233 3.87735 10.2503 4.18996Z" stroke="#E43235" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12.0502 17H11.9502" stroke="#E43235" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Utilize fotos reais para divulgar seu produto!
                    </div>
                </div>
    
                <div class="campo">
                    <label for="tags">Palavras-chave (separadas por 1 espaço)</label>
                    <input type="text" name="tags" id="tagsProd" placeholder="Ex.: Roupa Uniforme">
                </div>
    
                <button type="submit" id="productSubmit">Adicionar produto</button>
            </div>
        </form>
    </div>
</div>
<?= view('components/footer.php') ?>