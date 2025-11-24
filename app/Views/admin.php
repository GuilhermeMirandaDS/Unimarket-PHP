<?= view('components/header.php', ['notTransp' => 'class="not-transp"']) ?>
<main class="site-main">
    <div class="form-container container">
        <form action="<?= url_to('CategoryController::add') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="campo">
                <label for="nome">Nome da Categoria:</label>
                <input type="text" name="nome" id="catNomeInput" required>
            </div>
            <div class="campo">
                <label for="image">Imagem da Categoria (Tamanho recomendado: 200px x 200px)</label>
                <div class="box-upload">
                    <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 2V16C19 16.2652 18.8946 16.5196 18.7071 16.7071C18.5196 16.8946 18.2652 17 18 17H2C1.73478 17 1.48043 16.8946 1.29289 16.7071C1.10536 16.5196 1 16.2652 1 16V2C1 1.73478 1.10536 1.48043 1.29289 1.29289C1.48043 1.10536 1.73478 1 2 1H18C18.2652 1 18.5196 1.10536 18.7071 1.29289C18.8946 1.48043 19 1.73478 19 2ZM8.51 11.8L13.71 17H18C18.2652 17 18.5196 16.8946 18.7071 16.7071C18.8946 16.5196 19 16.2652 19 16V12.73L13.29 7L8.51 11.8ZM1 13.71V16C1 16.2652 1.10536 16.5196 1.29289 16.7071C1.48043 16.8946 1.73478 17 2 17H13.71L5.71 9L1 13.71Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>Arraste a imagem aqui</span>
                    <p>ou</p>
                    <input type="file" name="image" id="catImageInput" accept="image/*">
                </div>
            </div>
            <button type="submit" id="submitCategory">Adicionar</button>
        </form>

        <form action="<?= url_to('EventController::add') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="campo">
                <label for="nome">Nome do Evento:</label>
                <input type="text" name="nome" id="eventNomeInput" required>
            </div>
            <div class="campo">
                <label for="data">Data do Evento:</label>
                <input type="date" name="data" id="eventDataInput">
            </div>
            <div class="campo">
                <label for="horario">Horário do Evento:</label>
                <input type="time" name="horario" id="eventHorarioInput">
            </div>
            <div class="campo">
                <label for="descricao">Descrição do Evento (Local, Conteúdo, etc)</label>
                <textarea name="descricao" id="eventDescricaoInput"></textarea>
            </div>
            <div class="campo">
                <label for="link">Link de inscrição do Evento:</label>
                <input type="text" name="link" id="eventLinkInput">
            </div>
            <div class="campo">
                <label for="local">Local do Evento:</label>
                <input type="text" name="local" id="eventLocalInput" required>
            </div>
            <div class="campo">
                <label for="imageEvent">Banner do Evento (Tamanho recomendado: 1900px x 1000px)</label>
                <div class="box-upload">
                    <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 2V16C19 16.2652 18.8946 16.5196 18.7071 16.7071C18.5196 16.8946 18.2652 17 18 17H2C1.73478 17 1.48043 16.8946 1.29289 16.7071C1.10536 16.5196 1 16.2652 1 16V2C1 1.73478 1.10536 1.48043 1.29289 1.29289C1.48043 1.10536 1.73478 1 2 1H18C18.2652 1 18.5196 1.10536 18.7071 1.29289C18.8946 1.48043 19 1.73478 19 2ZM8.51 11.8L13.71 17H18C18.2652 17 18.5196 16.8946 18.7071 16.7071C18.8946 16.5196 19 16.2652 19 16V12.73L13.29 7L8.51 11.8ZM1 13.71V16C1 16.2652 1.10536 16.5196 1.29289 16.7071C1.48043 16.8946 1.73478 17 2 17H13.71L5.71 9L1 13.71Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>Arraste a imagem aqui</span>
                    <p>ou</p>
                    <input type="file" name="imageEvent" id="imageEvent" accept="image/*">
                </div>
            </div>
            <div class="campo">
                <label for="imageCard">Imagem para card do Evento (Tamanho recomendado: 600px x 500px)</label>
                <div class="box-upload">
                    <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 2V16C19 16.2652 18.8946 16.5196 18.7071 16.7071C18.5196 16.8946 18.2652 17 18 17H2C1.73478 17 1.48043 16.8946 1.29289 16.7071C1.10536 16.5196 1 16.2652 1 16V2C1 1.73478 1.10536 1.48043 1.29289 1.29289C1.48043 1.10536 1.73478 1 2 1H18C18.2652 1 18.5196 1.10536 18.7071 1.29289C18.8946 1.48043 19 1.73478 19 2ZM8.51 11.8L13.71 17H18C18.2652 17 18.5196 16.8946 18.7071 16.7071C18.8946 16.5196 19 16.2652 19 16V12.73L13.29 7L8.51 11.8ZM1 13.71V16C1 16.2652 1.10536 16.5196 1.29289 16.7071C1.48043 16.8946 1.73478 17 2 17H13.71L5.71 9L1 13.71Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>Arraste a imagem aqui</span>
                    <p>ou</p>
                    <input type="file" name="imageCard" id="imageCardEvent" accept="image/*">
                </div>
            </div>
            <button type="submit" id="submitEvent">Adicionar</button>
        </form>
    </div>
</main>