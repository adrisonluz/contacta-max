$(document).ready(function(){
    if($('#formProduct').length){
        var productId = $('input[name=id]').val();

        $(document).on('blur', '#sku', function(){
            $('#submit').attr('disabled','disabled');
            $('#feedbackSku').slideUp().remove();

            var sku = $(this).val();
            $.ajax({
                url: "/produtos/buscar-por-sku",
                data: {sku: sku}
            }).done(function(result) {
                if(result.id != productId && result.length !== 0){
                    if(result.deleted_at !== null){
                        var alertMsg = 'Um produto foi encontado com este sku mas encontra-se excluído. Deseja restaurá-lo? Clique <a href="/produtos/restaurar/' + result.id + '" title="Restaurar ' + result.name + '">aqui</a>.';
                    } else {
                        var alertMsg = 'Um produto foi encontado com este sku. Clique <a href="/produtos/editar/' + result.id + '" title="Editar ' + result.name + '">aqui</a> para editá-lo ou escolha outro sku para este produto.';
                    }

                    $('#sku').addClass('is-invalid').after('<div id="feedbackSku" class="invalid-feedback">' + alertMsg +'</div>');
                } else {
                    $('#feedbackSku').slideUp().remove();
                    $('#sku').removeClass('is-invalid');
                    $('#submit').removeAttr('disabled');
                }
            });
        });

        $(document).on('blur', '#remove_products', function(){
            $('#submit').attr('disabled','disabled');
            $('#feedbackQuantity').slideUp().remove();

            var quantity = $(this).val();
            $.ajax({
                url: "/produtos/verifica-estoque/" + productId,
                data: {quantity: quantity}
            }).done(function(result) {
                if(result == 'error'){
                    $('#remove_products').addClass('is-invalid').parent().after('<div id="feedbackQuantity" class="invalid-feedback">A quantidade de produtos a ser dado baixa deve ser menor ou igual a quantidade de produtos existente no estoque.</div>');
                } else {
                    $('#feedbackQuantity').slideUp().remove();
                    $('#remove_products').removeClass('is-invalid');
                    $('#submit').removeAttr('disabled');
                }
            });
        });
    }
});