$(document).ready(function(){
    
    if ($('.alerta-add').length > 0) {
        $('.alerta-add').addClass('show');

        setTimeout(() => {
            $('.alerta-add').removeClass('show');
        }, 5000);
    }

    if ($('.banner-home .swiper-slide'.length > 1)){
        new Swiper('.banner-home .swiper', {
            preloadImages: false,
            loop: true,
            effect: 'slide',
            autoplay: {
                delay: 5000,
                pauseOnMouseEnter: true
            },
            slidesPerView: 1,
            centeredSlides: true,
            spaceBetween: 0
        })
    };

    if ($('.showcase .swiper-slide'.length > 1)){
        new Swiper('.showcase .swiper', {
            preloadImages: false,
            loop: true,
            effect: 'slide',
            slidesPerView: 5,
            spaceBetween: 10
        })
    };

    $('#addProduct').on('click', function(){
        $('.overlay').addClass('show');
        $('.modal-product').addClass('show');
    });

    function closeModal(){
        if($('.modal-product.show')){
            $('.overlay').removeClass('show');
            $('.modal-product').removeClass('show');
        }
    };

    $('#closeModal').on('click', function(){
        closeModal();
    });

    $('.overlay').on('click', function(){
        closeModal();
    });

    let fileList = [];
    const $fileInput = $('#images');
    const $form = $('#uploadForm');

    $fileInput.on('change', function(event) {

        fileList.push(...Array.from(event.target.files));
        

        $fileInput.val(''); 
        

        $('.quantidade-upload').html(`${fileList.length} arquivos selecionados`);
    });


    $form.on('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this); 

        const csrfName = $('input[name^="csrf_"]').attr('name');
        const csrfHash = $('input[name^="csrf_"]').val();

        const precoInput = $('#precoProdInput');
        const precoFormatado = precoInput.val();

        // Remove TUDO que não for dígito ou vírgula
        let precoLimpo = precoFormatado.replace(/[^\d,]/g, ''); 

        // Troca a vírgula por ponto (padrão SQL)
        precoLimpo = precoLimpo.replace(',', '.');

        // Sobrescreve o valor do campo 'preco' com o valor limpo
        formData.set('preco', precoLimpo);
        
        if (csrfName && csrfHash) {
            formData.append(csrfName, csrfHash);
        }

        fileList.forEach((file) => {
            formData.append('images[]', file, file.name);
        });

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            
            success: function(response) {
                
                fileList = [];

                if (response.status === 'success' && response.redirect_url) {

                    window.location.href = response.redirect_url;
                }

                console.log('Produto Adicionado');
            },
            error: function(xhr, status, error) {
                console.error('Erro:', xhr.responseText);
            }
        });
    });

    function priceCurrencyInput(input){
        let val = input.val().toString();

        val = val.replace(/\D/g, '');

        if (val.length === 0) {
            input.val('');
            return;
        }

        while (val.length < 3) {
            val = '0' + val;
        }

        // 5. Insere a vírgula antes dos dois últimos dígitos
        // Ex: '12345' -> '123,45'
        let integerPart = val.substring(0, val.length - 2);
        let decimalPart = val.substring(val.length - 2);

        integerPart = parseInt(integerPart, 10).toString();
        
        // 6. Formata a parte inteira com pontos (milhares)
        // Ex: '12345' -> '12.345'
        integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        // 7. Concatena e define o novo valor no input
        input.val('R$' + integerPart + ',' + decimalPart);
    };

    $('#precoProdInput').on('change', function(){
        priceCurrencyInput($(this));
    });

    $('#precoProdInput').on('keyup', function() {
        priceCurrencyInput($(this));
    });

    function deleteProductById(id){
        $.ajax({
            url: '/products/remove/' + id,
            type: 'DELETE',
            
            success: function(response) {
                
                if (response.status === 'success' && response.redirect_url) {

                    window.location.href = response.redirect_url;
                }

                console.log('Produto Removido');
                
            },
            error: function(xhr, status, error) {
                console.error('Erro:', xhr.responseText);
            }
        });
    }

    const deleteButtons = $('.deleteProduct');
    
    $.each(deleteButtons, function(key, item){

        item.addEventListener('click', function(){
            const id = item.querySelector('.hidden').hmtl;

            let prodName = item.parentElement.parentElement.parentElement.querySelector('.product-name').textContent;

            $('.modal-delete .modal-delete-name').html('Tem certeza que deseja excluir o produto: ' + prodName + ' ?' )

            $('.overlay').addClass('show');
            
            $('.modal-delete').addClass('show');

            $('.overlay.show').on('click', function(){
                $('.modal-delete').removeClass('show');
            });

            $('#deleteDenied').on('click', function(){
                $('.modal-delete').removeClass('show');
            });

            $('#deleteConfirmed').on('click', function(){
                deleteProductById(id);
            });
            
        });

    });

})