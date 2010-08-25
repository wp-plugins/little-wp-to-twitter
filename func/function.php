<?php

add_action('admin_menu', 'lwtt_add_options');

if((get_option('lwtt_username') == "" || get_option('lwtt_password') == "") && get_option("enable_lwtt")) {
	add_action('admin_notices', 'lwtt_warning');
}
if((get_option('lwtt_username_sina') == "" || get_option('lwtt_password_sina') == "") && get_option("lwtt_sina")) {
	add_action('admin_notices', 'lwtt_warning_sina');
}

	add_action('publish_post', 'lwtt_get_update_post_info');
	add_action('edit_form_advanced', 'lwtt_show_post_option');
	add_action('save_post', 'lwtt_save_postmeta');
	add_action('save_post', 'lwtt_save_customtext');


function lwtt_add_options() {
	add_options_page('little-wp-to-twitter options', __("little-wp-to-twitter","little-wp-to-twitter"), 8, __FILE__, 'lwtt_the_options');
}

function lwtt_warning() {
	echo "<div class=\"error\"><p>";
	echo _e("Please update your ","little-wp-to-twitter");
	echo "<a href=\"".get_bloginfo('wpurl')."/wp-admin/options-general.php?page=little-wp-to-twitter/func/function.php\">";
	echo _e("little-wp-to-twitter username and password","little-wp-to-twitter");
	echo "</a>.</p></div>";
}

function lwtt_enable_warning() {
	echo "<div class=\"error\"><p>";
	echo _e('Please go to ','little-wp-to-twitter');
	echo "<a href=\"".get_bloginfo('wpurl')."/wp-admin/options-general.php?page=little-wp-to-twitter/func/function.php\">";
	echo _e('little-wp-to-twitter','little-wp-to-twitter');
	echo "</a>";
	echo _e(' to enable the options.','little-wp-to-twitter');
	echo "</p></div>";
}

function lwtt_warning_sina() {
	echo "<div class=\"error\"><p>";
	echo _e('Please enter your sina username and password.','little-wp-to-twitter');
	echo "</p></div>";
}

function lwtt_save_postmeta($id) {
	if($_POST['lwtt_to_twitter'] != "")
	{
		lwtt_update_postmeta($id, $_POST['lwtt_to_twitter']);
	}
}

function lwtt_update_postmeta($id, $value)
{
	if (!update_post_meta($id, '_lwtt_value', $value)) {
		add_post_meta($id, '_lwtt_value', $value);
	}
}

function lwtt_save_customtext($id) {
	if($_POST['lwtt_to_twitter_custom'] != "")
	{
		lwtt_update_customtext($id, $_POST['lwtt_to_twitter_custom']);
	}
}

function lwtt_update_customtext($id, $value)
{
	if (!update_post_meta($id, '_lwtt_text', $value)) {
		add_post_meta($id, '_lwtt_text', $value);
	}
}

function lwtt_show_post_option() {
	global $post;

	$notify = get_post_meta($post->ID, '_lwtt_value', true);

	echo "<div class=\"postbox\">";
	echo "<h3 class=\"hndle\"><span>Little-wp-to-twitter</span></h3>";
	echo "<div class=\"inside\">";
	echo _e("Tweet this post to Twitter?","little-wp-to-twitter");
	echo "<input id=\"skip_tb_post\" type=\"radio\" name=\"lwtt_to_twitter\" value=\"yes\"";
	if($notify == "yes" || $notify == "")
	{
		echo " checked=\"checked\"";
	}
	echo " /> <label for=\"skip_tb_post\">";
	echo _e('Yes','little-wp-to-twitter');
	echo "</label> ";


	echo "<input id=\"lwtt_to_twitter\" type=\"radio\" name=\"lwtt_to_twitter\" value=\"no\"";

	if($notify == "no")
	{
		echo " checked=\"checked\"";
	}

	echo " /> <label for=\"lwtt_to_twitter\">";
	echo _e('No','little-wp-to-twitter');
	echo "</label>";

	echo "</div>";
	
	$lwtttext = get_post_meta($post->ID, '_lwtt_text', true);
	echo "<div class=\"inside\">";
	echo _e('You can add this after the tweet.','little-wp-to-twitter');
	echo "<input size=\"80%\" type=\"text\" name=\"lwtt_to_twitter_custom\" value=\"";
	echo $lwtttext."\"";
	echo " /> ";

	echo "</div>";
	echo "</div>";
}

function lwtt_cut_str($str, $len) {
    if (!isset($str[$len])) {
    } else {
        if (seems_utf8($str[$len-1])) 
            $str = substr($str, 0, $len); 
        else { 
            if(seems_utf8($str[$len-3].$str[$len-2].$str[$len-1]))
                $str = substr($str, 0, $len-3) . $str[$len-3] . $str[$len-2] . $str[$len-1];

            elseif(seems_utf8($str[$len-2].$str[$len-1].$str[$len]))
                $str = substr($str, 0, $len-2) . $str[$len-2].$str[$len-1].$str[$len];

            elseif(seems_utf8($str[$len-1].$str[$len].$str[$len+1]))
                $str = substr($str, 0, $len-1) . $str[$len-1].$str[$len].$str[$len+1];

            else 
                $str = substr($str, 0, $len);
        }
    }
    return $str;
}

function lwtt_str_len($str)
{
    $length = strlen(preg_replace('/[\x00-\x7F]/', '', $str));

    if ($length)
    {
        return strlen($str) - $length + intval($length / 3) ;
    }
    else
    {
        return strlen($str);
    }
}
function lwtt_get_update_post_info($id)
{
	if($_POST['action'] != "autosave" and $_POST['post_status'] != "draft")
	{
		$mypost = get_post($id);
		$title = strip_tags(get_the_title($id));
		$postlink = get_permalink($id);
		if ($_POST['lwtt_to_twitter'] == "no") {
			return;
		} else {
			$_POST['lwtt_to_twitter'] == "yes";
		}
		lwtt_update_postmeta($id, $_POST['lwtt_to_twitter']);
		
		if($_POST['original_post_status'] == 'publish')
		{
			$leavetime = 60*60*1;
			if (get_option('lwtt_time')) {
				$leavetime = intval(get_option('lwtt_time'));
			}
			if (time() - strtotime($mypost->post_date) < $leavetime )
			{
				return;
			}
			$title = get_option('lwtt_update_prefix') . $title;
			
		}
		else
		{
			$title = get_option('lwtt_new_prefix') . $title;
		}
		
		$shortlink = $mypost->u_boy;
		$url_contents = $shortlink;
		if ($shortlink=="") 
		{
			$shortapi = "http://ye.pe/api.php?format=simple&action=shorturl&url=";
			if (get_option('lwtt_api')) {
				$shortapi = get_option('lwtt_api');
			}
			$shortlink = $shortapi . $postlink;
			$url_contents = file_get_contents($shortlink);
		}
		$temp_length = (lwtt_str_len($title)) + (lwtt_str_len($url_contents));

		if($temp_length > 137)
		{
			$remaining_chars = 134 - lwtt_str_len($url_contents);
			$title = lwtt_cut_str($title, 0, $remaining_chars);
			$title = $title . "...";
		}
		
		$message = $title . " - " . $url_contents;
		$message_sina = $message;
		
		if (get_option('lwtt_tags')) {
			$message_length = lwtt_str_len($message);
			$tags = wp_get_post_tags($mypost->ID);
			$tagcount = count($tags);
	
			$tag[0] = "#" . $tags[0]->name;
			$tag_length[0] = lwtt_str_len($tag[0]);
			$tag_sina[0] = "#" . $tags[0]->name ."#";
			$tag_sina_length[0] = lwtt_str_len($tag_sina[0]);
			for ($i=1;$i < $tagcount;$i++)
			{
				$tag[$i] = $tag[$i-1]." #" . $tags[$i]->name;
				$tag_sina[$i] = $tag_sina[$i-1]." #" . $tags[$i]->name ."#";
				$tag_length[$i] = lwtt_str_len($tag[$i]);
				$tag_sina_length[$i] = lwtt_str_len($tag_sina[$i]);
			}
			for ($j = $tagcount-1;$j >= 0;$j--)
			{
				if ((139 - $message_length) >= $tag_sina_length[$j])
				{
					$ok_sina = $j;
					break;
				}
			}
			$message_sina = $message . " ".$tag_sina[$ok_sina];
		
			for ($j = $tagcount-1;$j >= 0;$j--)
			{
				if ((139 - $message_length) >= $tag_length[$j])
				{
					$ok = $j;
					break;
				}
			}
			$message .= " ".$tag[$ok];
		}
		
		if($_POST['lwtt_to_twitter_custom'] != "")
		{
			$message .= " - " . $_POST['lwtt_to_twitter_custom'];
			$message_sina .= " - " . $_POST['lwtt_to_twitter_custom'];
		}
		if (get_option('lwtt_username') !== "" && get_option('lwtt_password') !== "" && get_option("enable_lwtt")) {
			lwtt_wp_to_twitter(htmlspecialchars($message));
		}
		if (get_option("lwtt_sina") && (get_option('lwtt_username_sina') !== "") && (get_option('lwtt_password_sina') !== "")) {
			lwtt_wp_to_sina(htmlspecialchars($message));
		}
	}
}

function lwtt_wp_to_twitter($message)
{
		$username = get_option('lwtt_username');
		$password = get_option('lwtt_password');
		$url = 'http://twitter.com/statuses/update.xml';
		if (get_option('lwtt_proxy')) {
			$url = 'http://mycnpda.appspot.com/api/statuses/update.xml';
		}
		if (get_option('lwtt_proxy') && get_option('lwtt_custom_proxy')) {
			$url = get_option('lwtt_custom_proxy');
		}

		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, "$url");
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_POST, 1);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "status=$message&source=qiqiboy");
		curl_setopt($curl_handle, CURLOPT_USERPWD, "$username:$password");
		$buffer = curl_exec($curl_handle);
		curl_close($curl_handle);
/*		
		$body = array( 'status'=>$message );
		$headers = array( 'Authorization' => 'Basic '.base64_encode("$username:$password") );
		
		$request = new WP_Http;
		$result = $request->request( $url , array( 'method'=>'POST', 'body'=>$body, 'headers'=>$headers) );	
*/
}
function lwtt_wp_to_sina($message)
{
    $username = get_option('lwtt_username_sina');
	$password = get_option('lwtt_password_sina');
	$cookie = tempnam('./', 'cookie.txt');   
    $ch = curl_init("https://login.sina.com.cn/sso/login.php?username=$username&password=$password&returntype=TEXT");   
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);   
    curl_setopt($ch, CURLOPT_HEADER, 0);   
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);   
    curl_setopt($ch, CURLOPT_USERAGENT, "qiqiboy.com");   
    curl_exec($ch);   
    curl_close($ch);   
    unset($ch);
    $ch = curl_init($ch);   
    curl_setopt($ch, CURLOPT_URL, "http://t.sina.com.cn/mblog/publish.php");   
    curl_setopt($ch, CURLOPT_REFERER, "http://t.sina.com.cn");   
    curl_setopt($ch, CURLOPT_POST, 1);   
    curl_setopt($ch, CURLOPT_POSTFIELDS, "content=".urlencode($message));   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);   
    curl_exec($ch);   
    curl_close($ch);   
    unlink($cookie);  
}
?>