<?php
/**
 * Provide a admin area view for the plugin.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @see       https://tidydom.com
 * @since      1.0.0
 */
?>


<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<form action="options.php" method="post">
	<?php
	settings_fields( 'tidydom' );
	do_settings_sections( 'tidydom' );
	submit_button( __( 'Save Settings' ) );
	?>
	</form>
</div>

<?php
