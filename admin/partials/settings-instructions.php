<?php
$options = get_option( 'tidydom_options' );
?>
<div style="padding:16px; background:white;border:1px solid #ccc;border-radius:12px; margin-top: 12px;">
<p>Connecting with your <strong>API Key</strong> allows you to display accessibility statistics and reports from <a href="https://tidydom.com" target="_blank" rel="noopener">tidyDOM</a> directly in your WordPress Dashboard.</p>
<?php if ( empty( $options['api_key'] ) ) { ?>
<p>Need an account? Sign up for a <a href="https://tidydom.com" target="_blank" rel="noopener">30-day trial</a> today.</p>
<?php } ?>
</div>
