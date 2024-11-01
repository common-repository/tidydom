<?php
$options       = get_option( 'tidydom_options' );
$allowed_roles = isset( $options['allowed_roles'] ) ? $options['allowed_roles'] : array();

$roles = wp_roles()->roles;
?>
<fieldset>
<legend style="padding-bottom:12px;font-weight:500;">Roles with access to accessibility reports.</legend>
<?php foreach ( $roles as $key => $r ) { ?>
<label style="display:block">
<div style="display:flex;flex-direction:row-reverse;align-items:center; justify-content:flex-end;">
	<span><?php echo esc_html_e( $r['name'] ); ?></span>
	<input
		type="checkbox"
		name="tidydom_options[allowed_roles][]"
		value="<?php echo esc_attr( $key ); ?>"
		style="margin-top:1px;"
		<?php echo 'administrator' === $key ? 'disabled' : ''; ?>
		<?php echo in_array( $key, $allowed_roles, true ) || 'administrator' === $key ? 'checked' : ''; ?> >
	</div>
</label>
<?php } ?>
</fieldset>
