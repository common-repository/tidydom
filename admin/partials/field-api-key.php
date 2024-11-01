<?php
$options = get_option( 'tidydom_options' );
?>
<div style="position:relative;">
<input
<?php ( empty( $options['api_key'] ) ? 'required' : '' ); ?>
style="width:400px"
<?php if ( ! empty( $options['api_key'] ) ) { ?>
placeholder="********************************"
onfocus="this.placeholder = ''"
onblur="this.placeholder = '********************************'"
<?php } ?>
id="api_key"
name="tidydom_options[api_key]"
>

<?php if ( ! empty( $options['api_key'] ) ) { ?>
	<?php if ( isset( $options['api_key_valid'] ) && $options['api_key_valid'] ) { ?>
<span style="position:absolute;margin-left:12px;color:white;background-color:green;padding:4px 6px;border-radius:12px;font-size:12px;">✓</span>
<p>
<strong>Your API Key has been set. It is not displayed here for security purposes.</strong>
</p>
<?php } else { ?>
	<span style="position:absolute;margin-left:12px;color:white;background-color:red;padding:4px 8px;border-radius:12px;font-size:12px;">x</span>
<p>
<strong>There was an error connecting to tidyDOM with your API key.</strong>
</p>
<?php } ?>
<?php } ?>
</div>
