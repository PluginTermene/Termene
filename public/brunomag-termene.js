(function( $ ) {
    'use strict';
    $(document).ready(function(){
        $('#termene_reg_com_field').addClass('hide');
        if(window.location.href=='http://woobill2.alpha.brunomag.ro/checkout/'){
            $('#brunomag-termene-search-cui-btn').click(function(e){
                var code=$('#termene_search_cui').val();
                var payload = {
                      data:{
                         code_comp:code
                     },
                     security: termene.security,
                     action: 'brunomag_termene_search_cui'
                };
                $.post(termene.ajaxurl,payload, function (response) {
                    response=JSON.parse(response);
                    if(response.hasOwnProperty('error')){
                        $('#termene-search-validation-message').text(response.error);
                    }else{
                        $('#termene_reg_com_field').removeClass('hide');
                        $('#termene_reg_com_field').addClass('show');
                        $('#termene-search-validation-message').text('');  
                        $('#termene_reg_com').val(response.DateGenerale.cod_inmatriculare);
                        $('#billing_company').val(response.DateGenerale.nume);
                        $('#billing_address_1').val(response.DateGenerale.adresa);
                        $('#billing_city').val(response.DateGenerale.localitate);
                        $('#billing_phone').val( response.DateGenerale.telefon);
                        $('#billing_state option').each(function(){
                        if($(this).text().toLowerCase()==response.DateGenerale.judet.toLowerCase()){
                            $('#billing_state').val($(this).val());
                            $('#billing_state').change();
                        }
                        });
                    }
                });
            });
        }
    }); 
})( jQuery );

