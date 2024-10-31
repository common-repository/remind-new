<?php 

add_action('admin_menu', 'remind_opt_menu');

function remind_opt_menu() {
	add_options_page('Remind New Plugin Settings', 'remind new', 'administrator',__FILE__, 'remind_page');

}

function remind_deact(){
delete_option('remind_options');
}

function get_options() {
		$options = get_option('remind_options');
		if (!is_array($options)) {
			$options['before_text']='Modified on';
			$options['after_text']='';
			$options['image']='1';
			$options['period']=3*24*60*60;
			$options['show_edit_form']='1';
			update_option('remind_options', $options);
		}
		return $options;
	}

register_deactivation_hook( __FILE__, 'remind_deact' );

$options=get_options();
if($options['show_edit_form']){
add_action('publish_post', 'save_postmeta');
add_action('edit_form_advanced', 'show_post_option');


function save_postmeta($id) {
	if(isset($_POST['enable_remind']) && $_POST['enable_remind'] == "1")
	{
		update_post_meta($id, 'enable_remind', $_POST['enable_remind']);
	}
	else update_post_meta($id, 'enable_remind', '-1');
}

function show_post_option() {
	global $post;
	$enable_remind=get_post_meta($post->ID, 'enable_remind', true);
	if(!$enable_remind)
	update_post_meta($post->ID, 'enable_remind', '1');
	$enable_remind=get_post_meta($post->ID, 'enable_remind', true);
	echo '<div class="postbox">';
	echo '<h3 class="hndle"><span>Remind New</span></h3>';
	echo '<div class="inside">Enable remind new? ';

	echo '<input name="enable_remind" type="checkbox" value="1"' ;
	if($enable_remind=='1')	echo "checked='checked'";
	echo ' />';
	echo "</div>";
	
	echo "</div>";
}

}

function remind_page(){
if(!current_user_can('manage_options') ){
    print "<div class='error'>Permission denied.</div>\n";
}

if( $_POST[ 'submitted' ]=='Y' ) 
{	
	check_admin_referer('remind_update_options');
	$options['before_text']=$_POST['before_text'];
	$options['after_text']=$_POST['after_text'];
	$options['image']=$_POST['image'];
	$options['period']=is_numeric($_POST['period'])?$_POST['period']:3*24*60*60;
	$options['show_edit_form']=$_POST['show_edit_form'];

update_option('remind_options',$options);
?>
<div class="updated"><p><strong><?php _e('Settings saved.', 'remind_domain' ); ?></strong></p></div>
<?php
}
$options=get_options();
$icon_url = get_bloginfo( 'wpurl' );

	$icon1 = '<img border="0" src="'.$icon_url.'/wp-content/plugins/remind-new/imgs/1.jpeg" /> ';
	$icon2 = '<img border="0" src="'.$icon_url.'/wp-content/plugins/remind-new/imgs/2.jpeg" /> ';
	$icon3 = '<img border="0" src="'.$icon_url.'/wp-content/plugins/remind-new/imgs/3.jpeg" /> ';
	$icon4 = '<img border="0" src="'.$icon_url.'/wp-content/plugins/remind-new/imgs/4.jpeg" /> ';
	$icon5 = '<img border="0" src="'.$icon_url.'/wp-content/plugins/remind-new/imgs/5.jpeg" /> ';
	$icon6 = '<img border="0" src="'.$icon_url.'/wp-content/plugins/remind-new/imgs/6.jpeg" /> ';
	$icon7 = '<img border="0" src="'.$icon_url.'/wp-content/plugins/remind-new/imgs/7.jpeg" /> ';
	$icon8 = '<img border="0" src="'.$icon_url.'/wp-content/plugins/remind-new/imgs/8.jpeg" /> ';
	$icon9 = '<img border="0" src="'.$icon_url.'/wp-content/plugins/remind-new/imgs/9.jpeg" /> ';
	$icon10 ='<img border="0" src="'.$icon_url.'/wp-content/plugins/remind-new/imgs/10.jpeg" /> ';
	$icon11 = '<img border="0" src="'.$icon_url.'/wp-content/plugins/remind-new/imgs/11.jpeg" /> ';
	
?>
<div class="wrap">
<h2><?php _e( 'Remind New Plugin Options', 'remind_domain' ); ?></h2>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<?php wp_nonce_field('remind_update_options'); ?>
<input type="hidden" name="submitted" value="Y">

 <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes','remind_domain') ?>" />
</p>

<table class="form-table">
        <tr valign="top">
        <th scope="row"><?php _e("Text before the modified time:", 'remind_domain' ); ?></th>
        <td><input name="before_text" type="text" value="<?php echo $options['before_text'] ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row"><?php _e("Text after the modified time:", 'remind_domain' ); ?></th>
        <td><input name="after_text" type="text" value="<?php echo $options['after_text'] ?>" /></td>
        </tr>

<tr valign="top">
        <th scope="row"><?php _e("Period of validity of the info icon, default is 3*24*60*60 seconds", 'remind_domain' ); ?></th>
        <td><input name="period" type="text" value="<?php echo $options['period'] ?>" /></td>
        </tr>

<tr valign="top">
        <th scope="row"><?php _e("Show edit form? When checked,a form below the edited form will show which give you a choice whether the info icon show specificly to this modified post", 'remind_domain' ); ?></th>
        <td><input name="show_edit_form" type="checkbox" value="1" <?php if($options['show_edit_form']=='1') echo "checked='checked'"; ?> /></td>
        </tr>


<tr valign="top">
	<th scope="row"><?php _e("Styles", 'remind_domain' ); ?></th>
	<td><input name="image" type="radio" value="1" <?php checked('1', $options['image']); ?> />&nbsp;&nbsp;<?php echo $icon1;?></td>
	</tr>
<tr valign="top">
	<th scope="row"></th>
	<td><input name="image" type="radio" value="2" <?php checked('2', $options['image']); ?> />&nbsp;&nbsp;<?php echo $icon2;?></td>
	</tr>
<tr valign="top">
	<th scope="row"></th>
	<td><input name="image" type="radio" value="3" <?php checked('3', $options['image']); ?> />&nbsp;&nbsp;<?php echo $icon3;?></td>
	</tr>
<tr valign="top">
	<th scope="row"></th>
	<td><input name="image" type="radio" value="4" <?php checked('4', $options['image']); ?> />&nbsp;&nbsp;<?php echo $icon4;?></td>
	</tr>
<tr valign="top">
	<th scope="row"></th>
	<td><input name="image" type="radio" value="5" <?php checked('5', $options['image']); ?> />&nbsp;&nbsp;<?php echo $icon5;?></td>
	</tr>
<tr valign="top">
	<th scope="row"></th>
	<td><input name="image" type="radio" value="6" <?php checked('6', $options['image']); ?> />&nbsp;&nbsp;<?php echo $icon6;?></td>
	</tr>
<tr valign="top">
	<th scope="row"></th>
	<td><input name="image" type="radio" value="7" <?php checked('7', $options['image']); ?> />&nbsp;&nbsp;<?php echo $icon7;?></td>
	</tr>
<tr valign="top">
	<th scope="row"></th>
	<td><input name="image" type="radio" value="8" <?php checked('8', $options['image']); ?> />&nbsp;&nbsp;<?php echo $icon8;?></td>
	</tr>
<tr valign="top">
	<th scope="row"></th>
	<td><input name="image" type="radio" value="9" <?php checked('9', $options['image']); ?> />&nbsp;&nbsp;<?php echo $icon9;?></td>
	</tr>
<tr valign="top">
	<th scope="row"></th>
	<td><input name="image" type="radio" value="10" <?php checked('10', $options['image']); ?> />&nbsp;&nbsp;<?php echo $icon1;?></td>
	</tr>
<tr valign="top">
	<th scope="row"></th>
	<td><input name="image" type="radio" value="11" <?php checked('11', $options['image']); ?> />&nbsp;&nbsp;<?php echo $icon11;?></td>
	</tr>

    </table>

 <p class="submit">
    <input type="submit" class="button-primary"  value="<?php _e('Save Changes','remind_domain') ?>" />
 </p>


</form>
</div>

<?php

}
?>
