$(document).ready(function(){

    // $('#registerForm select#tag').on('change', function(){
    //     const val = $(this).val();

    //     if (val == 1){
    //         $('.options-funcionario').removeClass('show');
    //         $('.options-aluno').addClass('show');
    //     } else if(val == 2){
    //         $('.options-aluno').removeClass('show');
    //         $('.options-funcionario').addClass('show');
    //     }
    // });
    
    if ($('.alerta-add').length > 0) {
        $('.alerta-add').addClass('show');

        setTimeout(() => {
            $('.alerta-add').removeClass('show');
        }, 5000);
    }
    
    if ($('.categories-carousel .swiper-wrapper').length > 0) {

        let slidesLen = $('.categories-carousel .swiper-slide').length;

        let centered = false;

        if(slidesLen < 2){
            centered = true;
        }

        new Swiper('.categories-carousel .swiper', {
            preloadImages: false,
            loop: false,
            effect: 'slide',
            slidesPerView: slidesLen > 8 ? 8 : slidesLen,
            centeredSlides: centered,
            spaceBetween: 10
        })
    }

    if ($('.banner-home .swiper-slide').length > 1){
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

    if ($('.banner-eventos .swiper-slide').length > 1){

        let swipLen = $('.banner-eventos .swiper-slide').length;

        new Swiper('.banner-eventos .swiper', {
            preloadImages: false,
            loop: swipLen > 5 ? true : false,
            effect: 'slide',
            autoplay: {
                delay: 5000,
                pauseOnMouseEnter: true
            },
            slidesPerView: 1,
            centeredSlides: true,
            spaceBetween: 30
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

    if ($('.full-image-swiper .swiper-slide'.length > 1)){
        new Swiper('.full-image-swiper.swiper', {
            preloadImages: false,
            loop: false,
            effect: 'slide',
            slidesPerView: 1,
            spaceBetween: 0,
            centeredSlides: true
        })
    };

    if ($('.thumb-swiper .swiper-slide'.length > 1)){
        new Swiper('.thumb-swiper.swiper', {
            preloadImages: false,
            loop: false,
            effect: 'slide',
            slidesPerView: 3.5,
            spaceBetween: 10
        })
    };

    

    // Quantidade de produtos
    const buttons = $('.box-quantidade button');
    const input = $('.quant-input');
    const stock = $('.estoque-input').val();

    $.each(buttons, function(){
        $(this).on('click', function(){
            if($(this).attr('data-type') == 'menos'){
                let val = input.val();

                if(val <= 1){
                    val = 1;
                } else {
                    val = +val - 1;
                }
                
                input.val(val);
            } else if($(this).attr('data-type') == 'mais'){
                let val = input.val();

                if (+val + 1 > stock) {
                    return;
                } else {
                    val = +val + 1;
                }

                input.val(val);
            }
        })
    })
    // Fim da quantidade de produtos
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
    
    $.each(deleteButtons, function(){

        $(this).on('click', function(){
            const id = $(this).find('.hidden').text();

            let prodName = $(this).parent().parent().parent().find('.product-name').text();

            $('.modal-delete .modal-delete-name').text('Tem certeza que deseja excluir o produto: ' + prodName + ' ?' )

            $('.overlay').addClass('show');
            
            $('.modal-delete').addClass('show');

            $('.overlay.show').on('click', function(){
                $('.modal-delete').removeClass('show');
            });

            $('#deleteDenied').on('click', function(){
                $('.modal-delete').removeClass('show');
                $('.overlay').removeClass('show');
            });

            $('#deleteConfirmed').on('click', function(){
                deleteProductById(id);
            });
            
        });

    });

})