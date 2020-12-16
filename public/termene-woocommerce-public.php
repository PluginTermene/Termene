<?php

    class Termene_Woocommerce_Public {
        private $plugin_name;
        private $version;

  
        public function __construct( $plugin_name, $version ) {
    
            $this->plugin_name = $plugin_name;
            $this->version = $version;
    
        }
    
        public function enqueue_styles() {
            if(is_checkout()){
                wp_enqueue_style('custom', plugin_dir_url( __FILE__ ) . 'custom.css', array(),$this->version, 'all');
            }
        }
    
        public function enqueue_scripts() {
            if(is_checkout()){
                $termene['security'] = wp_create_nonce('termene_nonce');
                $termene['ajaxurl']=admin_url( '/admin-ajax.php' );
                wp_enqueue_script($this->plugin_name, plugin_dir_url( __FILE__ ).'brunomag-termene.js', array('jquery') ,$this->version, time(), false);
                wp_localize_script($this->plugin_name, 'termene', $termene);
            }
        }

        public function register_fields( $checkout ) {
            $loginOptions = get_option('termene_plugin_options');
            if($loginOptions['connected']){
                echo "<div>";
                woocommerce_form_field( 'termene_search_cui', array(
                    'type'          => 'text',
                    'class'         => array('search-cui-class form-row-wide'),
                    'required'  => true,
                    'label'         => __('Cod fiscal'),
                    'placeholder'   => __('Cod fiscal'),
                    ), $checkout->get_value( 'termene_search_cui' ));
                echo "
                <button type='button' value='search_cui' name='search_cui' id='brunomag-termene-search-cui-btn'>
                <div class='brmg-underline'>Completeaza datele firmei automat</div>
                <div id='brunomag-termene-pow-by'>powerd by  <img src='".plugin_dir_url(__FILE__)."../assets/logo2.svg' width=100px height=100px></img></div>
                </button> 
                </div>";
                echo "<small style='color:red;' id='termene-search-validation-message'></small>",
                woocommerce_form_field( 'termene_reg_com', array(
                    'type'          => 'text',
                    'class'         => array('reg-com-class form-row-wide'),
                    'required'  => true,
                    'label'         => __('Registrul comertului'),
                    'placeholder'   => __('Registrul comertului'),
                ), $checkout->get_value( 'termene_reg_com' ));
            }
        }
    }
    
?>