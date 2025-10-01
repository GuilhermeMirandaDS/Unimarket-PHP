<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unimarket - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/global.css') ?>">
</head>
<body>
    <div class="flex align-center content">
        
        <!-- Painel esquerdo -->
        <div class="hidden md:block md:w-1/2 relative">
            <div class="h-full flex items-center justify-center p-12">
                <div class="text-center">
                    <div class="mb-6">
                        <img src="<?= base_url('assets/img/balanco.svg') ?>" class="img-balanco" />
                    </div>
                    <h1 class="text-slogan">
                        Faça login para navegar pelo 
                        <span class="text-blue-600">Unimarket</span>
                    </h1>
                </div>
            </div>
        </div>

        <!-- Painel direito -->
        <div class="form-login">
            <div class="select-form">
                <button class="select-login active">Login</button>
                <button class="select-register">Cadastrar-se</button>
            </div>
            <div class="login aba show">
                <!-- Login -->
                <div class="campo">
                    <label for="text number">
                        RA
                    </label>
                    <input name="ra" type="text number" class="w-full border rounded p-2" placeholder="Digite seu RA" required>
                </div>

                <div class="campo">
                    <label for="password">
                        Senha
                    </label>
                    <input name="password" type="password" class="w-full border rounded p-2" placeholder="Digite sua senha" required>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white rounded p-2 hover:bg-blue-700">Entrar</button>
            </div>
            <div class="register aba">

                <form method="post" action="" class="space-y-4">
                    
                    <!-- Registro -->
                    <div class="campo">
                        <label for="name">
                            Nome de Usuário
                        </label>
                        <input id="name" name="name" type="text" class="w-full border rounded p-2" placeholder="Digite seu nome completo" required>
                    </div>

                    <div class="campo">
                        <label for="text number">
                            RA
                        </label>
                        <input name="ra" type="text number" class="w-full border rounded p-2" placeholder="Digite seu RA" required>
                    </div>

                    <div class="campo">
                        <label for="password">
                            Senha
                        </label>
                        <input name="password" type="password" class="w-full border rounded p-2" placeholder="Digite sua senha" required>
                    </div>

                    <div class="campo">
                        <label for="tag">
                            Sou
                        </label>
                        <select id="tag" name="tag" class="w-full border rounded p-2" required>
                            <option value="1">Aluno</option>
                            <option value="2">Funcionário</option>
                        </select>
                    </div>

                    <div class="campo">
                        <label for="img">
                            Link da sua imagem de perfil
                        </label>
                        <input id="img" name="img" type="text" class="w-full border rounded p-2" placeholder="Cole o link da sua imagem" required>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white rounded p-2 hover:bg-blue-700">Registrar-me</button>
                </form>
            </div>
        </div>
        
    </div>
</body>
<script>
    let registerBtn = document.querySelector('.select-register');
    let loginBtn = document.querySelector('.select-login');

    registerBtn.addEventListener('click', function(){
        loginBtn.classList.remove('active');
        this.classList.add('active');

        document.querySelector('.login.aba').classList.remove('show');
        document.querySelector('.register.aba').classList.add('show');
    })

    loginBtn.addEventListener('click', function(){
        registerBtn.classList.remove('active');
        this.classList.add('active');

        document.querySelector('.register.aba').classList.remove('show');
        document.querySelector('.login.aba').classList.add('show');
    })
</script>
</html>