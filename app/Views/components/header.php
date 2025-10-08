<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/global.css') ?>">
    <title>Unimarket - Home</title>
</head>
<body>
    <header>
        <div class="header-mid">
            <a href="" class="flex items-center">
                <img src="<?= base_url('/public/assets/img/logosvg.svg') ?>" alt="Unimarket Logo"/>
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

            <div class="hidden md:flex flex-1 max-w-xl relative">
                <form class="w-full">
                    <Input type="text"placeholder="O que você está procurando?"/>
                    <button type="submit"class="absolute right-3 top-1/2 -translate-y-1/2 h-5 w-5 text-muted-foreground">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 20L15 15M17 10C17 11.3845 16.5895 12.7378 15.8203 13.889C15.0511 15.0401 13.9579 15.9373 12.6788 16.4672C11.3997 16.997 9.99224 17.1356 8.63437 16.8655C7.2765 16.5954 6.02922 15.9287 5.05026 14.9497C4.07129 13.9708 3.4046 12.7235 3.13451 11.3656C2.86441 10.0078 3.00303 8.6003 3.53285 7.32122C4.06266 6.04213 4.95987 4.94888 6.11101 4.17971C7.26216 3.41054 8.61553 3 10 3C11.8565 3 13.637 3.7375 14.9497 5.05025C16.2625 6.36301 17 8.14348 17 10V10Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M20.5 20.5L17 17" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="flex items-center gap-3">
        <?php 
        
            $userLogged = false;
            
            if ($userLogged == true) { 
        
        ?>
            <Button>
                    <svg fill="#000000" width="20px" height="20px" viewBox="0 0 36 36" version="1.1"  preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>user-line</title><path d="M18,17a7,7,0,1,0-7-7A7,7,0,0,0,18,17ZM18,5a5,5,0,1,1-5,5A5,5,0,0,1,18,5Z" class="clr-i-outline clr-i-outline-path-1"></path><path d="M30.47,24.37a17.16,17.16,0,0,0-24.93,0A2,2,0,0,0,5,25.74V31a2,2,0,0,0,2,2H29a2,2,0,0,0,2-2V25.74A2,2,0,0,0,30.47,24.37ZM29,31H7V25.73a15.17,15.17,0,0,1,22,0h0Z" class="clr-i-outline clr-i-outline-path-2"></path><rect x="0" y="0" width="36" height="36" fill-opacity="0"/></svg>
                    <span class="sr-only">Perfil</span>
            </Button>
        <?php
            } else { 
        ?>
            <Button class="user-btn first-level-user" size="icon">
                <img src={user?.avatar} alt={user?.name} class="user-pfp"/>
                <div class="user-info-header">
                <span class="user-name-header">{user?.name}</span>
                <p class="user-tag-header">{user?.tag}</p>
                </div>
                <ul class="second-level-user">
                <li class="menu-subitem">
                    <span>Perfil</span>
                </li>
                <li class="menu-subitem">
                    <Link to="/user">
                    Meus Anúncios
                    </Link>
                </li>
                <li class="menu-subitem">
                    <a onClick={logOut}>
                    Sair
                    </a>
                    </li>
                </ul>
            </Button>
        <?php
            }
        ?>

            <Button variant="ghost" size="icon" class="relative" asChild>
            <Link to="/cart">
                <ShoppingCart class="h-5 w-5" />
                <span class="sr-only">Carrinho</span>
                <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white">0</span>
            </Link>
            </Button>
        </div>
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
    </header>