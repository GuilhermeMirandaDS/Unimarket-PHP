<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/global.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="<?= base_url('js/script.js') ?>"></script>
    <title>Unimarket - Home</title>
</head>
<body>
    <header>
        <div class="header-mid">
            <a href="" class="flex items-center logo">
                <img src="<?= base_url('/assets/img/logosvg.svg') ?>" alt="Unimarket Logo"/>
            </a>

            <div class="menu-nav">
                <a class="menu-tab" href="/">Página Inicial</a>
                <div class="menu-tab first-level md:flex items-end px-2">
                    Produtos
                    <svg width="20px" height="20px" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h48v48H0z" fill="none"/><g id="Shopicon"><polygon points="24,29.172 9.414,14.586 6.586,17.414 24,34.828 41.414,17.414 38.586,14.586 	"/></g></svg>
                    <ul class="second-level">
                        <li class="menu-subitem">Apostilas</li>
                        <li class="menu-subitem">Doces</li>
                        <li class="menu-subitem">Roupas</li>
                        <li class="menu-subitem">Livros</li>
                        <li class="menu-subitem">Comida</li>
                        <li class="menu-subitem">Eletrônicos</li>
                        <li class="menu-subitem">Atlética</li>
                    </ul>
                </div>
                <a class="menu-tab" href="/">Sobre Nós</a>
                <a class="menu-tab" href="/">Sobre a Unimar</a>
            </div>

            <div class="hidden md:flex flex-1 max-w-xl relative search-bar">
                <Input name="queryString" type="text" placeholder="O que você está procurando?"/>
                <button type="submit" class="button-search">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 20L15 15M17 10C17 11.3845 16.5895 12.7378 15.8203 13.889C15.0511 15.0401 13.9579 15.9373 12.6788 16.4672C11.3997 16.997 9.99224 17.1356 8.63437 16.8655C7.2765 16.5954 6.02922 15.9287 5.05026 14.9497C4.07129 13.9708 3.4046 12.7235 3.13451 11.3656C2.86441 10.0078 3.00303 8.6003 3.53285 7.32122C4.06266 6.04213 4.95987 4.94888 6.11101 4.17971C7.26216 3.41054 8.61553 3 10 3C11.8565 3 13.637 3.7375 14.9497 5.05025C16.2625 6.36301 17 8.14348 17 10V10Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M20.5 20.5L17 17" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>

            <div class="flex items-center gap-3 user-info">
            <?php 
            
                $userLogged = session()->get('logged_in');
                
                if (!$userLogged) { 
            
            ?>
                <a href="<?php base_url('/enter') ?>">
                    <span class="sr-only">Login</span>
                </a>
            <?php
                } else { 
            ?>
                <img src="" alt="userPFP" class="user-pfp"/>

                <div class="user-info-header">
                    <span class="user-name-header"></span>
                    <p class="user-tag-header"></p>
                </div>

                <ul class="second-level-user">
                    <li class="menu-subitem">
                        <a href="<?php redirect()->to(base_url('/users/account')) ?>">Perfil</a>
                    </li>
                    <li class="menu-subitem">
                        <Link href="<?php redirect()->to(base_url('/storage')) ?>">Meus Anúncios</Link>
                    </li>
                    <li class="menu-subitem">
                        <button id="logOut">Sair</button>
                    </li>
                </ul>
            <?php
                }
            ?>

                <a href="" class="cart">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 4H6.85333C7.17489 3.99637 7.48692 4.10906 7.73194 4.31733C7.97696 4.5256 8.13845 4.8154 8.18667 5.13333L8.82667 9.33333L10.6667 21.3333L25.3333 20L28 9.33333H8.82667" stroke="#1E1E1E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M14.6001 27.3333H14.7334" stroke="#1E1E1E" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M22.6001 27.3333H22.7334" stroke="#1E1E1E" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span class="cart-number">0</span>
                </a>
            </div>
            
            <?php
                if ($isMobile) {
            ?>

            <form onSubmit={handleSearch} class="mt-2 relative">
                <Input
                type="text"
                placeholder="O que você está procurando?">
                <button
                type="submit"
                class="absolute right-3 top-1/2 -translate-y-1/2 h-5 w-5 text-muted-foreground"
                >
                <Search class="h-5 w-5" />
                </button>
            </form>
                    
            <?php
                }
            ?>
        </div>

    </header>