<?php
class Termene_Admin {
    private $auth_screen = null;
    private $menu_slug = 'termene-woocommerce';
    private $capability = 'manage_options';
    private $plugin_name;
  

    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->auth_screen = new Termene_Admin_Auth_Screen();
    }

    public function get_auth_screen(){
        return $this->auth_screen;
    }

    public function add_menu_pages(){
        $page_title = $menu_title = __('Termene', 'termene-woocommerce');
        $ter_auth_screen = $this->get_auth_screen();
        $main_function_auth = array($ter_auth_screen, 'termene_show_login_form');
        $menu_title_settings = __('Setari', 'termene-woocommerce');
        $position = 98;
        $icon_url=plugin_dir_url(__FILE__).'../assets/icon-16x16.png';
        add_menu_page( $page_title, $menu_title, $this->capability, $this->menu_slug, $main_function_auth,$icon_url, $position );
    }

}