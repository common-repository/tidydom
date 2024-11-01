<?php
/**
 * Fired during plugin deactivation.
 *
 * @see       https://tidydom.com
 * @since      1.0.0
 *
 * @package    Tidydom
 * @subpackage Tidydom/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 *
 * @author     Jesse Tolj <jesse@tidydom.com>
 */
class Tidydom_Deactivator {

	/**
	 * Short Description. (use period).
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option( 'tidydom_options' );
	}
}
