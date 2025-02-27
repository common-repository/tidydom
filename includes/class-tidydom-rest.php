<?php
/**
 * The REST functionality of the plugin.
 *
 * @see       https://tidydom.com
 * @since      1.0.0
 *
 * @package    Tidydom
 */

/**
 * The REST functionality of the plugin.
 *
 * @author     Jesse Tolj <jesse@tidydom.com>
 */
class Tidydom_Rest {

	/**
	 * Instance of the service class.
	 *
	 * @var Tidydom_Services
	 */
	private $service;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$options = get_option( 'tidydom_options' );
		$api_key = isset( $options['api_key'] ) ? $options['api_key'] : '';

		$this->service = new Tidydom_Services( $api_key, Tidydom::API_BASE_URL, Tidydom::API_VERSION );
	}

	/**
	 * Initialize the REST endpoints.
	 *
	 * @return void
	 */
	public function init_endpoints() {
		register_rest_route(
			'tidydom/v1',
			'/report',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'report' ),
				'permission_callback' => array( $this, 'access' ),
			)
		);

		register_rest_route(
			'tidydom/v1',
			'/pages',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'pages' ),
				'permission_callback' => array( $this, 'access' ),
			)
		);
	}

	/**
	 * Check for access to the REST endpoints.
	 *
	 * @return bool
	 */
	public function access() {
		$user          = wp_get_current_user();
		$options       = get_option( 'tidydom_options' );
		$allowed_roles = isset( $options['allowed_roles'] ) ?
			array_unique( array_merge( $options['allowed_roles'], array( 'administrator' ) ) ) :
			array( 'administrator' );

		if ( count( array_intersect( $allowed_roles, (array) $user->roles ) ) > 0 ) {
			return true;
		}

		return false;
	}

	/**
	 * Load data from the report endpoint to hydrate the Svelte App.
	 *
	 * @param WP_REST_Request $request
	 *
	 * @return WP_REST_Response|WP_Error
	 */
	public function report( WP_REST_Request $request ) {
		nocache_headers();
		try {
			$response = $this->service->scans();
		} catch ( Exception $e ) {
			$response = new WP_REST_Response( $e->getMessage(), $e->getCode() );
		}
		return rest_ensure_response( $response );
	}

	/**
	 * Load data from the pages endpoint to hydrate the Svelte App.
	 *
	 * @param WP_REST_Request $request
	 *
	 * @return WP_REST_Response|WP_Error
	 */
	public function pages( WP_REST_Request $request ) {
		$for_page = isset( $_GET['page'] ) ? (int) $_GET['page'] : 1;
		nocache_headers();
		try {
			$response = $this->service->pages( $for_page );
		} catch ( Exception $e ) {
			$response = new WP_REST_Response( $e->getMessage(), $e->getCode() );
		}
		return rest_ensure_response( $response );
	}
}
