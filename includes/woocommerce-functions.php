<?php
function brunomag_termene_search_cui(){
    check_ajax_referer('termene_nonce', 'security');
    $data = $_POST['data'];
    $code = (int) $data['code_comp'];
    if (! is_numeric($code) || ($code <= 0)){
        $return['error'] = sprintf( __('Codul fiscal %1$s este invalid !', 'termene-woocommerce'),$code);
    }
    else {
        $return = termene_get_company_data_by_cui($code);
    }
    echo json_encode($return);   
    die();
}

function termene_get_company_data_by_cui($code){
    try{
        $loginOptions = get_option('termene_plugin_options');
        if($loginOptions['connected']){
            $client = new Termene_REST_Client($loginOptions['username'], $loginOptions['password']);
            $return=$client->getDataByCUI($code);
        }else{
            $return['error'] =  __('Credentiale invalide!', 'termene-woocommerce');
        }
        return $return;

    }catch(Exception $e){
        $return['error'] = sprintf( __('Codul fiscal %1$s este invalid!', 'termene-woocommerce'),$code);
        return $return;
    }
}

add_action('wp_ajax_brunomag_termene_search_cui', 'brunomag_termene_search_cui');
add_action('wp_ajax_nopriv_brunomag_termene_search_cui', 'brunomag_termene_search_cui');
?>