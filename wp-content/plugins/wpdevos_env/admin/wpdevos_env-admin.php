<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class wpdevos_env_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        $this->initAjax();

	}

    private function initAjax()
    {
        add_action( 'wp_ajax_add_foobar', function($a) {
            // Handle request then generate response using WP_Ajax_Response

            global $wpdb;

            if (is_writeable(ABSPATH . 'wp-config.php')) {

                /**
                 * LOAD FILES
                 */

                $siteUrl = parse_url(get_option('siteurl'));

                $wpConfig = file_get_contents(__DIR__ . '/envs_skeletons/wp-config.php');
                $defaultConfig = file_get_contents(__DIR__ . '/envs_skeletons/.wpdenv.default.php');
                $sampleConfig = file_get_contents(__DIR__ . '/envs_skeletons/.wpdenv.sample.php');
                $envConfig = file_get_contents(__DIR__ . '/envs_skeletons/.wpdenv.env.php');

                /**
                 * REPLACE WP-CONFIG
                 */
                if (!file_exists(ABSPATH . 'wp-config.backup.php')) {
                    rename(ABSPATH . 'wp-config.php', ABSPATH . 'wp-config.backup.php');
                }

                file_put_contents(ABSPATH . 'wp-config.php', $wpConfig);

                /**
                 * DEFAULT
                 */

                $newKeys = '';

                $keys = array('AUTH_KEY', 'SECURE_AUTH_KEY', 'LOGGED_IN_KEY', 'NONCE_KEY', 'AUTH_SALT', 'SECURE_AUTH_SALT', 'LOGGED_IN_SALT', 'NONCE_SALT');

                foreach ($keys as $key) {
                    $newKeys .= "define('$key', '".constant($key)."');" . PHP_EOL;
                }

                $defaultConfig = preg_replace('/_WP_DEVOS_CONSTANTS_/', $newKeys, $defaultConfig);
                $defaultConfig = preg_replace('/_WP_DEVOS_TABLE_PREFIX_/', $wpdb->prefix, $defaultConfig);
                file_put_contents(ABSPATH . '.wpdenv.default.php', $defaultConfig);

                /**
                 * DEV
                 */

                $dbKeys = array('DB_USER', 'DB_PASSWORD', 'DB_NAME', 'DB_HOST', 'DB_COLLATE', 'DB_CHARSET');

                foreach ($dbKeys as $key) {
                    $sampleConfig = preg_replace("/REPLACE_$key/", constant($key), $sampleConfig);
                }

                file_put_contents(ABSPATH . '.wpdenv.dev.php', $sampleConfig);

                /**
                 * ENV
                 */

                $envConfig = preg_replace('@//ENVREPLACE@', "case '".$siteUrl['host']."': ".PHP_EOL." define('WP_ENV', 'dev');".PHP_EOL."break;".PHP_EOL, $envConfig);
                file_put_contents(ABSPATH . '.wpdenv.env.php', $envConfig);
            }
        } );
    }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpdevos_env-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpdevos_env-admin.js', array( 'jquery' ), $this->version, false );

	}

    public function admin_menu()
    {
        add_options_page( 'WPDevos / Env - Options', 'WPDevos - Env', 'manage_options', 'wpdevos_env', function() {
            if ( !current_user_can( 'manage_options' ) )  {
                wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
            }

            //get settings from dv
            $settings = unserialize(get_option('wpdevos_env_settings', false));

            //check if settings exists in db
            if ($settings == false) {
                $settings = $this->getDefaultSettings();
                $hasConfiguration = false;
            } else {
                $hasConfiguration = true;
            }

            //save form
            if (isset($_POST['wpdevos_env_settings'])) {
                $settings['envs'] = array_merge($settings['envs'], $_POST['wpdevos_env_settings']);
                update_option('wpdevos_env_settings', serialize($settings));
            }

            include __DIR__ . '/partials/wpdevos_env-common.php';
        } );

    }

    private function getDefaultSettings()
    {
        $default_env = array(
            'db' => array(
                'name' => '',
                'user' => '',
                'password' => '',
                'host' => '',
                'charset' => '',
                'collate' => ''
            ),
            'wp' => array(
                'debug' => ''
            ),
            'site' => array(
                'url' => '',
                'protocol' => '',
            )
        );

        return array(
            'envs' => array(
                'default' => $default_env
            )
        );
    }

}
