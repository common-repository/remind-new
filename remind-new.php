<?php
/*
Plugin Name: remind new
Plugin URI: http://www.devilalbum.com/2010/03/plugin-remind-new/
Description: If you modify a post, this plugin will put a icon beside the post for the next three days to call attention to the visitors and when the visitors hover their mouse on that icon, some string will show detailing the modified date
Version: 2.0
Author: yun77op
Author URI: http://devilalbum.com/
License : GPL v3
*/

require_once(dirname(__FILE__).'/options.php');

function main( $related_content ){
	global $post;
	$options=get_options();
	$enable = get_post_meta($post->ID, 'enable_remind', true);
	if(is_home() && $enable=='1'){
	$img_src=WP_PLUGIN_URL . '/remind-new/imgs/' . $options['image'] . '.jpeg';
	$postdate=$post->post_date;
	$postdate_mod=$post->post_modified;
if ( empty($postdate_mod) || '0000-00-00 00:00:00' == $postdate_mod )
return $related_content;
	list( $year, $month, $day, $hour, $minute, $second )=preg_split('/[^0-9]/', $postdate);
	$postdata_stamp=mktime($hour,$minute,$second,$month,$day,$year);
	list( $year, $month, $day, $hour, $minute, $second )=preg_split('/[^0-9]/', $postdate_mod);
	$postdata_mod_stamp=mktime($hour,$minute,$second,$month,$day,$year);
	
	$now_stamp=time();
	if($postdata_stamp != $postdata_mod_stamp && ($postdata_mod_stamp+$options['period'])>= $now_stamp){
	$mod='<img style="float:right" src="' .$img_src .'" title="'. $options['before_text'] .' '. $postdate_mod .' '. $options['after_text'] . '" />';
	return $mod . $related_content;
	}
}
	return $related_content;
	
}

add_filter('the_content','main');
?>
