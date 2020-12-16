<?php
class Termene_Admin_Auth_Screen {

    public function register_fields() {
        # for login
        register_setting(
            'termene_plugin_options',
            'termene_plugin_options'
        );
        add_settings_section(
            'termene_plugin_login','',
            array('Termene_Admin_Auth_Screen','termene_plugin_login_section_text'),'termene_plugin'
        );
        add_settings_field(
            'termene_plugin_options_username', __('Nume utilizator', 'termene-woocommerce'),
            array('Termene_Admin_Auth_Screen', 'termene_settings_display_username'), 'termene_plugin','termene_plugin_login'
        );
        add_settings_field(
            'termene_plugin_options_password',__('Parola', 'termene-woocommerce'),
            array('Termene_Admin_Auth_Screen', 'termene_settings_display_password'),'termene_plugin','termene_plugin_login'
        );
    }


    public function termene_show_login_form(){
    ?>
        <div class="wrap">
            <h2>
                <?php _e('Termene', 'termene-woocommerce'); ?>
                <?php _e(' versiunea ', 'termene-woocommerce'); echo TERMENE_PLUGIN_VERSION; ?>
                <?php _e(' - Autentificare', 'termene-woocommerce'); ?>
            </h2>
            <?php settings_errors(); ?>
            <form action="<?php echo admin_url('options.php');?>" method="post">
                <?php settings_fields('termene_plugin_options'); ?>
                <?php do_settings_sections('termene_plugin');
                 ?>

                <input name="Submit" type="submit" class="button button-primary" value="<?php _e('Autentificare', 'termene-woocommerce'); ?>" />
            </form>
        </div>
    <?php
    }

    public static function termene_plugin_login_section_text(){
        //Exista 2 logo-uri
        // echo 
        // '<div>
        //     <img src="'.plugin_dir_url(__FILE__).'../assets/logo.png" style="max-width: 376px;background-color:#23527C; padding:10px 20px;" />
        // </div>';

        echo 
        '<div>
            <img src="'.plugin_dir_url(__FILE__).'../assets/logo2.svg" style="max-width: 376px; padding:20px 0px;" />
        </div>';
    }

    public static function termene_settings_display_username(){
        $options = get_option('termene_plugin_options');
        if (!empty($options) && is_array($options) && isset($options['username'])) {
            $username = $options['username'];
        } else {
            $username = '';
        }
        echo '
        <input id="termene_settings_username" name="termene_plugin_options[username]" type="text" value="'.$username.'" style="width: 400px;" />';  
    }

    public static function termene_settings_display_password(){
        $options = get_option('termene_plugin_options');
        $isLoggedIn = self::termene_validate_connection();
        $options['connected'] = $isLoggedIn;
        update_option('termene_plugin_options', $options);
        $connected = $options['connected'];

        if (!empty($options) && is_array($options) && isset($options['password'])) {
            $password = $options['password'];
        } else {
            $password = '';
        }

        echo '
        <input id="termene_settings_password" name="termene_plugin_options[password]" type="password" value="'.esc_attr($password).'" style="width: 400px;" />';
    
        if (!empty($connected) && !empty($options['username']) && !empty($options['password'])) {
            echo '<div style="color: green"><strong>'.__('Conectare cu succes la Termene', 'termene-woocommerce').'</strong></div>';
        }else{
            echo '<div style="color: red"><strong>'.__('Datele de conectare nu sunt valide', 'termene-woocommerce').'</strong></div>';
        }
    }


    public static function termene_validate_connection($input = null){
        $options = get_option('termene_plugin_options');
        try {
            if ( empty($options['username']) || empty($options['password'])){
                $returns_value=false;
                throw new Exception(__('Va rugam sa completati toate datele din sectiunea de autentificare.', 'termene-woocommerce'));
            };
            $client = new Termene_REST_Client($options['username'], $options['password']);
            $company=$client->getDataByCUI('33034700');
            $returns_value = true;
        }catch(Exception $e){
            $returns_value = false;
            add_settings_error('termene-woocommerce', '', $e->getMessage(), 'error');
        }

        return $returns_value;
    }
   
}

    