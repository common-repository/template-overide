<?php
/*
Plugin Name: Template-Overide
Description: Use this little plugin to overide your templates css. This is useful when you use the wordpress theme update function.
Author: Simon Prosser
Plugin URI: http://www.pross.org.uk/wordpress-plugins/
Author URI: http://www.pross.org.uk
Version: 0.8.1
*/

/* change log 

*/

$default_overide = "";
add_action('init', 'tm_overide');
add_action('admin_menu', 'tm_overide_admin_page');
add_action('wp_head', 'css_head', 15); 
function tm_overide(){
	$overide_css = get_theme_mod('tm_overide');
	if ( !$overide_css)
		return;
}
function tm_overide_options_page(){
if ( $_POST['update'] ) {
	if ( str_replace(" ", "",$_POST['newcontent']) != '' ) {
		set_theme_mod( 'tm_overide', stripslashes($_POST['newcontent']) );
		set_theme_mod( 'tm_overide_en', '<span style="color: green;">Enabled</span>' );
		print '<div id="message" class="updated fade"><p><strong>Overide css updated!</strong></p></div>';
	} 
	
if ( $_POST['enable'] ) { 
set_theme_mod( 'tm_overide_en', 'enable' );
}
if ( $_POST['disable'] ) { 
remove_theme_mod( 'tm_overide_en' ); 
} 
	}
	$overide_css = get_theme_mod('tm_overide');
	print '
	<div class="wrap">
	<h2>CSS Overide Editor</h2>
	<p>Current theme: <b>'. get_option('template') .'</b></p>
	<p>Overide is currently: ';
	if ( get_theme_mod( 'tm_overide_en' )) {
	echo 'Enabled!';
	} else {
	echo 'Disabled!';
	}
	
	
	
	print '<p>Add your css in the space below.</p>
	<p>If you are not sure what to type, look at the bottom of this page for examples.</p>
	<p>To disable, just empty the box and save, or disable the plugun.</p>
	<form name="template" id="template" method="post" action="http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'">
	<textarea name="newcontent" id="newcontent" cols="70" rows="15">'.$overide_css.'</textarea>
	<input type="hidden" name="update" value="yes">
	<p class="submit" style="width:420px;"><input type="submit" value="';
	echo 'Submit';
	print '" />
	<input type="submit" name="';
	if ( get_theme_mod( 'tm_overide_en' )) { 
	echo 'disable" value="disable" />';
	} else {
	echo 'enable" value="enable" />';
	}
	print '
	</p>
	</form>
	</div>

	<div class="wrap">
	<h2>CSS Examples:</h2>
<p>#sidebar a {<br />
background: none !important;<br />
padding-left: 5 !important;<br />
padding: 5px 5px 5px 5px;<br />
}<br /></p>
	</div>
	';
}
function tm_overide_admin_page(){
	add_submenu_page('themes.php', 'Template overide', 'Template overide', 9, 'tm_overide.php', 'tm_overide_options_page');
}
function css_head() {
if ( get_theme_mod( 'tm_overide_en' )) {
	if ($overide_css = get_theme_mod('tm_overide')) {
	echo '
<!-- Template-Overide by Pross -->
<style type="text/css" media="screen">';
$overide_css = str_replace("\r\n", "",$overide_css);
$overide_css = str_replace("\t", "",$overide_css);
echo $overide_css . '</style>
<!-- End -->';
	}
	}
}
?>
