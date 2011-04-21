<?php
/*
Plugin Name: little-wp-to-twitter
Plugin URI: http://www.qiqiboy.com/plugins/
Description: When you update your wp post, a new tweet will be update to your twitter at the same time. 
Version: 1.2.4
Author: QiQiBoY
Author URI: http://www.qiqiboy.com
*/
load_plugin_textdomain('little-wp-to-twitter', false, basename(dirname(__FILE__)) . '/lang');
require_once(dirname(__FILE__).'/func/function.php');
function lwtt_the_options() {
?>
<div class="wrap">
<h2><?php _e('Little-wp-to-twitter Options','little-wp-to-twitter');?></h2>
<form method="post" action="options.php">
<h3>This plugin has not worked. Please go to <a href="http://wordpress.org/extend/plugins/social-medias-connect/">Social Medias Connect</a> page to download the newest plugin.</h3>
<?php wp_nonce_field('update-options'); ?>
<h3><?php _e('Enable little wp to twitter?','little-wp-to-twitter');?></h3>
<label>
<input name="enable_lwtt" type="checkbox" value="checkbox" <?php if(get_option("enable_lwtt")) echo "checked='checked'"; ?> />
<?php _e('Enable little wp to twitter.', 'little-wp-to-twitter'); ?>
</label>
<label>
<input name="lwtt_tags" type="checkbox" value="checkbox" <?php if(get_option("lwtt_tags")) echo "checked='checked'"; ?> />
<?php _e('Enable tags to twitter.', 'little-wp-to-twitter'); ?>
</label>
<br/><label>
<input name="lwtt_sina" type="checkbox" value="checkbox" <?php if(get_option("lwtt_sina")) echo "checked='checked'"; ?> />
<?php _e('Enable wp to sina.', 'little-wp-to-twitter'); ?>
</label>
<h3><?php _e('Twitter ID and PASSWORD','little-wp-to-twitter');?></h3>

<p><?php _e('Enter your Twitter username and password.','little-wp-to-twitter');?></p>

<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e('Twitter Username','little-wp-to-twitter');?></th>
<td><input type="text" name="lwtt_username" value="<?php echo get_option('lwtt_username'); ?>" /></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Twitter Password','little-wp-to-twitter');?></th>
<td><input type="password" name="lwtt_password" value="<?php echo get_option('lwtt_password'); ?>" /></td>
</tr>

</table>

<p><?php _e('Enter your sina username and password.','little-wp-to-twitter');?></p>

<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e('Sina Username','little-wp-to-twitter');?></th>
<td><input type="text" name="lwtt_username_sina" value="<?php echo get_option('lwtt_username_sina'); ?>" /></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Sina Password','little-wp-to-twitter');?></th>
<td><input type="password" name="lwtt_password_sina" value="<?php echo get_option('lwtt_password_sina'); ?>" /></td>
</tr>

</table>
<h3><?php _e('Custom prefix','little-wp-to-twitter');?></h3>

<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Prefix for a new post:','little-wp-to-twitter');?></th>
<td><input type="text" name="lwtt_new_prefix" size="40" value="<?php echo get_option('lwtt_new_prefix'); ?>" /></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Prefix for updated a post:','little-wp-to-twitter');?></th>
<td><input type="text" name="lwtt_update_prefix" size="40" value="<?php echo get_option('lwtt_update_prefix'); ?>" /></td>
</tr>

</table>
<h3><?php _e('The time leave the first publish','little-wp-to-twitter');?></h3>

<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('input the number(seconds):','little-wp-to-twitter');?></th>
<td><input type="text" name="lwtt_time" size="40" value="<?php echo get_option('lwtt_time'); ?>" /><?php _e('example: 3600', 'little-wp-to-twitter'); ?></td>

</tr>

</table>
<h3><?php _e('Custom your shorten url api','little-wp-to-twitter');?></h3>

<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('input urlShorten-service api:','little-wp-to-twitter');?></th>
<td><input type="text" name="lwtt_api" size="40" value="<?php echo get_option('lwtt_api'); ?>" /><?php _e('example: http://example.com/api.php?url=', 'little-wp-to-twitter'); ?></td>

</tr>

</table>
<h3><?php _e('Custom twitter proxy','little-wp-to-twitter');?></h3>
<label>
<input name="lwtt_proxy" type="checkbox" value="checkbox" <?php if(get_option("lwtt_proxy")) echo "checked='checked'"; ?> />
<?php _e('use a proxy?(If your host put in China).', 'little-wp-to-twitter'); ?>
</label>
<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e('you can also use your twitter proxy:','little-wp-to-twitter');?></th>
<td><input type="text" name="lwtt_custom_proxy" size="40" value="<?php echo get_option('lwtt_custom_proxy'); ?>" /><?php _e('example: http://nest.onedd.net/api/statuses/update.xml', 'little-wp-to-twitter'); ?></td>

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