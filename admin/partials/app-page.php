<?php
$options = get_option( 'tidydom_options' );
?>

<?php if ( ! empty( $options['api_key'] ) ) { ?>
	<div id="tidydom-app"></div>
<?php } else { ?>
	<div>Please set up your <a href="<?php echo esc_url( site_url( '/wp-admin/admin.php?page=tidydom-settings' ) ); ?>">API Key</a> to access statistics and reports.</div>
<?php } ?>
