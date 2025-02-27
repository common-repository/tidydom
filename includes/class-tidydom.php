<?php
/**
 * The file that defines the core plugin class.
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @see       https://tidydom.com
 * @since      1.0.0
 *
 * @package Tidydom
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 *
 * @author     Jesse Tolj <jesse@tidydom.com>
 */
class Tidydom {

	const API_BASE_URL = 'https://api.tidydom.com';
	const API_VERSION  = 'v1';

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 *
	 * @var Tidydom_Loader maintains and registers all hooks for the plugin
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 *
	 * @var string the string used to uniquely identify this plugin
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 *
	 * @var string the current version of the plugin
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'TIDYDOM_VERSION' ) ) {
			$this->version = TIDYDOM_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'tidydom';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_rest_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Tidydom_Loader. Orchestrates the hooks of the plugin.
	 * - Tidydom_i18n. Defines internationalization functionality.
	 * - Tidydom_Admin. Defines all hooks for the admin area.
	 * - Tidydom_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tidydom-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tidydom-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-tidydom-admin.php';

		/**
		 * The class responsible for defining the API services.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tidydom-services.php';

		/**
		 * The class responsible for defining all rest endpoints.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tidydom-rest.php';

		$this->loader = new Tidydom_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Tidydom_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	private function set_locale() {
		$plugin_i18n = new Tidydom_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Tidydom_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'init_menus' );
		$this->loader->add_action( 'admin_post_tidydom_download_report', $plugin_admin, 'handle_report_download' );
	}

	/**
	 * Register all of the hooks related to the REST functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	private function define_rest_hooks() {
		$plugin_rest = new Tidydom_Rest( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'rest_api_init', $plugin_rest, 'init_endpoints' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 *
	 * @return string the name of the plugin
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 *
	 * @return Tidydom_Loader orchestrates the hooks of the plugin
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 *
	 * @return string the version number of the plugin
	 */
	public function get_version() {
		return $this->version;
	}
}
