<?php
class Termene_Woocommerce {
    protected $plugin_name;
    protected $version;
    protected $loader;

    public function __construct() {
        if ( defined( 'TERMENE_PLUGIN_VERSION' ) ) {
            $this->version = TERMENE_PLUGIN_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'Termene Woocommerce';

        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    public function run() {
        $this->loader->run();
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_loader() {
        return $this->loader;
    }

    public function get_version() {
        return $this->version;
    }

    private function load_dependencies() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/termene-loader.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/termene-rest-client.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/termene-admin.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/termene-admin-auth-screen.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/termene-woocommerce-public.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/woocommerce-functions.php';

        $this->loader = new Termene_Loader();
    }

    private function define_admin_hooks() {
        $plugin_admin = new Termene_Admin( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'admin_init', $plugin_admin->get_auth_screen(), 'register_fields' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu_pages' );
    }

    private function define_public_hooks() {
        $plugin_public = new Termene_Woocommerce_Public( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'woocommerce_before_checkout_billing_form',$plugin_public, 'register_fields' );

    }


}