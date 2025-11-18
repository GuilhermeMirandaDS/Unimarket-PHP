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
        <div class="md:block md:w-1/2 relative image-login-container">
            <img src="<?= base_url('assets/img/banner-login.png') ?>" class="img-login" />
        </div>

        <!-- Painel direito -->
        <div class="form-login">
            <div class="login-text">
                <h1>Bem-vindo(a) de volta! 👋</h1>
                <p>Insira seus dados para realizar seu login</p>
            </div>
            <div class="select-form">
                <button class="select-login active">Login</button>
                <button class="select-register">Cadastrar-se</button>
            </div>

            <?php if (session()->getFlashData('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashData('error') ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('users/login') ?>" class="login aba show" id="loginForm">
                <!-- Login -->
                <div class="campo">
                    <label for="ra">RA</label>
                    <input name="ra" type="text" id="ra" class="w-full border rounded p-2" placeholder="Digite seu RA" required>
                </div>

                <div class="campo">
                    <label for="password">Senha</label>
                    <input name="password" type="password" id="password" class="w-full border rounded p-2" placeholder="Digite sua senha" required>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white rounded p-2 hover:bg-blue-700">Entrar</button>
            </form>

            <form method="post" action="<?= base_url('users/register') ?>" class="register aba" id="registerForm">
                    
                <!-- Registro -->
                <div class="campo">
                    <label>RA</label>
                    <input name="ra" type="text" class="w-full border rounded p-2" placeholder="Digite seu RA" required>
                </div>

                <div class="campo">
                    <label>Nome de Usuário</label>
                    <input id="name" name="name" type="text" class="w-full border rounded p-2" placeholder="Digite seu nome completo" required>
                </div>

                <div class="campo">
                    <label>Email</label>
                    <input name="email" type="email" class="w-full border rounded p-2" placeholder="Digite seu Email" required>
                </div>

                <div class="campo">
                    <label>Senha</label>
                    <input name="password" type="password" class="w-full border rounded p-2" placeholder="Digite sua senha" required>
                </div>

                <div class="campo">
                    <label>Sou</label>
                    <select id="tag" name="tag" class="w-full border rounded p-2" required>
                        <option value="1">Aluno</option>
                        <option value="2">Funcionário</option>
                    </select>
                </div>

                <div class="campo">
                    <label for="images">Foto de Perfil</label>
                    <div class="box-upload">
                        <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 2V16C19 16.2652 18.8946 16.5196 18.7071 16.7071C18.5196 16.8946 18.2652 17 18 17H2C1.73478 17 1.48043 16.8946 1.29289 16.7071C1.10536 16.5196 1 16.2652 1 16V2C1 1.73478 1.10536 1.48043 1.29289 1.29289C1.48043 1.10536 1.73478 1 2 1H18C18.2652 1 18.5196 1.10536 18.7071 1.29289C18.8946 1.48043 19 1.73478 19 2ZM8.51 11.8L13.71 17H18C18.2652 17 18.5196 16.8946 18.7071 16.7071C18.8946 16.5196 19 16.2652 19 16V12.73L13.29 7L8.51 11.8ZM1 13.71V16C1 16.2652 1.10536 16.5196 1.29289 16.7071C1.48043 16.8946 1.73478 17 2 17H13.71L5.71 9L1 13.71Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Arraste a imagem aqui</span>
                        <p>ou</p>
                        <input type="file" name="images[]" id="images" id="fotosProduct" accept="image/*">
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white rounded p-2 hover:bg-blue-700">Registrar-me</button>
            </form>
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

    document.getElementById('registerForm').addEventListener('submit', function(e) {

        e.preventDefault();

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.redirected) {
                sessionStorage.setItem('logged_in', 'true');
                window.location.href = response.url;
            } else {
                alert('Login inválido');
            }
        });

    });
</script>
</html>