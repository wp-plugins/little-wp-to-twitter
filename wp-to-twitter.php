<?php
/*
Plugin Name: little-wp-to-twitter
Plugin URI: http://www.qiqiboy.com/plugins/
Description: When you update your wp post, a new tweet will be update to your twitter at the same time. 
Version: 1.1
Author: QiQiBoY
Author URI: http://www.qiqiboy.com
*/

require_once(dirname(__FILE__).'/func/function.php');

function lwtt_the_options() {
?>
<div class="wrap">
<h2>Little-wp-to-twitter Options</h2>
<form method="post" action="options.php">

<?php wp_nonce_field('update-options'); ?>
<h3>Enable little wp to twitter?</h3>
<label>
<input name="enable_lwtt" type="checkbox" value="checkbox" <?php if(get_option("enable_lwtt")) echo "checked='checked'"; ?> />
<?php _e('Enable little wp to twitter.', 'qiqiboy'); ?>
</label>
<label>
<input name="lwtt_tags" type="checkbox" value="checkbox" <?php if(get_option("lwtt_tags")) echo "checked='checked'"; ?> />
<?php _e('Enable tags to twitter.', 'qiqiboy'); ?>
</label>
<br/><label>
<input name="lwtt_sina" type="checkbox" value="checkbox" <?php if(get_option("lwtt_sina")) echo "checked='checked'"; ?> />
<?php _e('Enable wp to sina.', 'qiqiboy'); ?>
</label>
<h3>Twitter ID and PASSWORD</h3>

<p>Enter your Twitter username and password.</p>

<table class="form-table">
<tr valign="top">
<th scope="row">Twitter Username</th>
<td><input type="text" name="lwtt_username" value="<?php echo get_option('lwtt_username'); ?>" /></td>
</tr>

<tr valign="top">
<th scope="row">Twitter Password</th>
<td><input type="password" name="lwtt_password" value="<?php echo get_option('lwtt_password'); ?>" /></td>
</tr>

</table>

<p>Enter your sina username and password.</p>

<table class="form-table">
<tr valign="top">
<th scope="row">Sina Username</th>
<td><input type="text" name="lwtt_username_sina" value="<?php echo get_option('lwtt_username_sina'); ?>" /></td>
</tr>

<tr valign="top">
<th scope="row">Sina Password</th>
<td><input type="password" name="lwtt_password_sina" value="<?php echo get_option('lwtt_password_sina'); ?>" /></td>
</tr>

</table>
<h3>Custom prefix</h3>

<table class="form-table">

<tr valign="top">
<th scope="row">Prefix for a new post:</th>
<td><input type="text" name="lwtt_new_prefix" size="40" value="<?php echo get_option('lwtt_new_prefix'); ?>" /></td>
</tr>

<tr valign="top">
<th scope="row">Prefix for updated a post:</th>
<td><input type="text" name="lwtt_update_prefix" size="40" value="<?php echo get_option('lwtt_update_prefix'); ?>" /></td>
</tr>

</table>
<h3>The time leave the first publish</h3>

<table class="form-table">

<tr valign="top">
<th scope="row">input the number(seconds):</th>
<td><input type="text" name="lwtt_time" size="40" value="<?php echo get_option('lwtt_time'); ?>" /><?php _e('example: 3600', 'qiqiboy'); ?></td>

</tr>

</table>
<h3>Custom your shorten url api</h3>

<table class="form-table">

<tr valign="top">
<th scope="row">input urlShorten-service api:</th>
<td><input type="text" name="lwtt_api" size="40" value="<?php echo get_option('lwtt_api'); ?>" /><?php _e('example: http://example.com/api.php?url=', 'qiqiboy'); ?></td>

</tr>

</table>
<h3>Custom twitter proxy</h3>
<label>
<input name="lwtt_proxy" type="checkbox" value="checkbox" <?php if(get_option("lwtt_proxy")) echo "checked='checked'"; ?> />
<?php _e('use a proxy?(If your host put in China).', 'qiqiboy'); ?>
</label>
<table class="form-table">
<tr valign="top">
<th scope="row">you can also use your twitter proxy:</th>
<td><input type="text" name="lwtt_custom_proxy" size="40" value="<?php echo get_option('lwtt_custom_proxy'); ?>" /><?php _e('example: http://nest.onedd.net/api/statuses/update.xml', 'qiqiboy'); ?></td>

</tr>

</table>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="lwtt_sina,lwtt_username_sina,lwtt_password_sina,lwtt_custom_proxy,lwtt_proxy,lwtt_time,lwtt_tags,enable_lwtt,lwtt_username,lwtt_api,lwtt_password,lwtt_new_prefix,lwtt_update_prefix" />

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>

<?php
}
?>