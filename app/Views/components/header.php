<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/global.css') ?>">
    <link rel="shortcut icon" type="image/png" href="<?= base_url('/assets/img/favicon.png') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="<?= base_url('js/script.js') ?>"></script>
    <title>Unimarket - Home</title>
</head>
<body>
    <header <?= $notTransp ?>>
        <div class="header-mid">
            <a href="<?= base_url('home') ?>" class="flex items-center logo">
                <img src="<?= base_url('/assets/img/unimarket-logo.svg') ?>" alt="Unimarket Logo"/>
            </a>

            <div class="menu-nav">
                <a class="menu-tab" href="<?= base_url('/home') ?>">Página Inicial</a>
                <div class="menu-tab first-level md:flex items-end px-2">
                    Produtos
                    <svg width="20px" height="20px" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h48v48H0z" fill="none"/><g id="Shopicon"><polygon points="24,29.172 9.414,14.586 6.586,17.414 24,34.828 41.414,17.414 38.586,14.586 	" fill="currentColor"/></g></svg>
                    <ul class="second-level">
                        <?php if ($categories != null): ?>
                            <?php foreach($categories as $categorie): ?>
                                <li class="menu-subitem">
                                    <a href="<?= base_url('/category/' . $categorie->id) ?>"><?= esc($categorie->nome) ?></a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
                <a class="menu-tab" href="https://unimar.br/">Sobre a Unimar</a>
                <a href="/eventos" class="menu-tab">Eventos</a>
            </div>

            <form action="<?= url_to('ProductController::search') ?>" class="md:flex flex-1 max-w-xl relative search-bar">
                <Input name="query" type="text" placeholder="O que você está procurando?"/>
                <button type="submit" class="button-search">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 20L15 15M17 10C17 11.3845 16.5895 12.7378 15.8203 13.889C15.0511 15.0401 13.9579 15.9373 12.6788 16.4672C11.3997 16.997 9.99224 17.1356 8.63437 16.8655C7.2765 16.5954 6.02922 15.9287 5.05026 14.9497C4.07129 13.9708 3.4046 12.7235 3.13451 11.3656C2.86441 10.0078 3.00303 8.6003 3.53285 7.32122C4.06266 6.04213 4.95987 4.94888 6.11101 4.17971C7.26216 3.41054 8.61553 3 10 3C11.8565 3 13.637 3.7375 14.9497 5.05025C16.2625 6.36301 17 8.14348 17 10V10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M20.5 20.5L17 17" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </form>

            <div class="flex items-center gap-3 user-info">
                <?php if(session()->get('image')): ?>

                    <?php 
                        $image_name = session()->get('image')[0]; 
                        $base_url_images = base_url('uploads/users/');
                    ?>

                    <?php $image_url = $base_url_images . pathinfo($image_name, PATHINFO_FILENAME) . '-128.webp'; ?>

                    <div class="user-pfp">
                        <img src="<?= $image_url ?>" alt="userPFP"/>
                    </div>

                <?php else: ?>
                    <img src="<?= base_url('/assets/img/no-image.png') ?>" alt="userPFP" class="user-pfp"/>
                <?php endif; ?>

                <div class="user-info-header">
                    <span class="user-name-header"><?= esc(session()->get('name')) ?></span>
                    <p class="user-tag-header"><?= esc(session()->get('curso')) ?></p>
                </div>

                <ul class="second-level-user">
                    <li class="menu-subitem">
                        <a href="<?php redirect()->to(base_url('/users/account')) ?>">Perfil</a>
                    </li>
                    <li class="menu-subitem">
                        <a href="<?= base_url('/my-products/' . session()->get('ra')) ?>">Meus Anúncios</a>
                    </li>
                    <?php if (session()->get('adm') == 1): ?>
                    <li class="menu-subitem">
                        <a href="<?= base_url('/users/admin') ?>">Painel ADM</a>
                    </li>
                    <?php endif; ?>
                    <li class="menu-subitem">
                        <a href="<?= base_url('/logout') ?>" >Sair</a>
                    </li>
                </ul>
            </div>

            <a href="" class="cart">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 4H6.85333C7.17489 3.99637 7.48692 4.10906 7.73194 4.31733C7.97696 4.5256 8.13845 4.8154 8.18667 5.13333L8.82667 9.33333L10.6667 21.3333L25.3333 20L28 9.33333H8.82667" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M14.6001 27.3333H14.7334" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M22.6001 27.3333H22.7334" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="cart-number">0</span>
            </a>
        </div>

    </header>