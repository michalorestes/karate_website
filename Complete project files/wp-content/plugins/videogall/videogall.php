<?php
/*
Plugin Name: VideoGall
Plugin URI: http://nischalmaniar.info/2010/05/videogall-plugin/
Version: 2.1
Author: Nischal Maniar
Author URI: http://www.nischalmaniar.info
*/

/*  Copyright 2009

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/** Define global variables **/
/*****************************/
global $wpdb, $videogall, $videocat, $videogalloptions, $table_name, $cat_table, $videogall_db_version, $videocat_db_version;
$videogall = array();
$videocat = array();
$videogalloptions = array();
$table_name = $wpdb->prefix . "videogall";
$cat_table = $wpdb->prefix . "vidcategory";
$videogall_db_version = "1.7";
$videocat_db_version = "1.0";
    
/** Function to create the table for storing video information **/
/*****************************************************************/
/*** DO NOT MODIFY THIS FUNCTION ***/
/***********************************/
function videogall_install() {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions, $videogall_db_version, $videocat_db_version;
    
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE " . $table_name . " (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            url text NOT NULL,
            caption text,
            category text NOT NULL,
            thumbnail text,
            name text NOT NULL,
	    description text,
            UNIQUE KEY id (id)
        );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        add_option("videogall_db_version", $videogall_db_version);
    } else {
	$installedversion = get_option('videogall_db_version');
	if($installedversion != $videogall_db_version) {
	    $sql = "CREATE TABLE " . $table_name . " (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		url text NOT NULL,
		caption text,
		category text NOT NULL,
		thumbnail text,
		name text NOT NULL,
		description text,
		UNIQUE KEY id (id)
	      );";
	    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');  
	    dbDelta($sql);
	    update_option("videogall_db_version",$videogall_db_version);                    
	}               
    }    

    if($wpdb->get_var("SHOW TABLES LIKE '$cat_table'") != $cat_table) {
	$catsql = "CREATE TABLE ".$cat_table." (
	    catid mediumint(9) NOT NULL AUTO_INCREMENT,
	    catname text NOT NULL,
	    UNIQUE KEY catid (catid)
	);";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($catsql);
	add_option("videocat_db_version", $videocat_db_version);
    } else {
	$installedversion = get_option('videocat_db_version');
	if($installedversion != $videocat_db_version) {
	    $catsql = "CREATE TABLE ".$cat_table." (
		catid mediumint(9) NOT NULL AUTO_INCREMENT,
		catname text NOT NULL,
		UNIQUE KEY catid (catid)
	    );";
	    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	    dbDelta($catsql);
	    update_option("videocat_db_version",$videocat_db_version);
	}
    }    
}
 
/** Including the common videogall activation functions **/
/*********************************************************/
include("videogallfunctions.php");
get_videogall_settings();

// ** Functions to create and display the gallery **//
//**************************************************//
function create_videogall($category,$limit,$iswidget) {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    if(is_numeric($videogalloptions['videosperpage']) and $videogalloptions['videosperpage'] > 0) {
        if(trim($_GET['vpage']) != "" and $_GET['vpage'] > 0) {
            $offset = (($_GET['vpage'] * $videogalloptions['videosperpage']) - $videogalloptions['videosperpage']);         
        } else $offset = "";
        $limit = $videogalloptions['videosperpage'];
    }
    get_videogall_from_db($category,$limit,$offset);
    $videoout = '';
    $count = 0;
    foreach($videogall as $video) {
	$count++;
	$videometa = "";
        $thumbnailsize = explode("|",$videogalloptions['thumbsize']);
        $videosize = explode("|",$videogalloptions['videosize']);
        if(trim($video->thumbnail) != "") $imgsrc = $video->thumbnail; else $imgsrc = get_videogall_thumbnail($video->url);
	if(is_shadowbox($video->url)) $shadowboxtag = ' rel="shadowbox;width='.$videosize[0].';height='.$videosize[1].'"'; else $shadowboxtag = '';
        $videocontent = "\n\t".'<a class="videolink" href="'.get_videogall_url($video->url).'"'.$shadowboxtag.'><img src="'.$imgsrc.'" style="max-width: '.$thumbnailsize[0].'px; max-height:'.$thumbnailsize[1].'px;" width="'.$thumbnailsize[0].'px" height="'.$thumbnailsize[1].'px" /></a>'."\n\t";
        if($videogalloptions['showcaption']) {
            if($video->caption == "") $caption = $video->name; else $caption = $video->caption;
            $videometa .= '<p class="videocaption">'.$caption.'</p>'."\n\t";
        }
	if($videogalloptions['showdescription']) {
            $videometa .= '<p class="videodescription">'.$video->description.'</p>'."\n";
        }
        $videoout .= '<div class="videogall" style="width:'.$thumbnailsize[0].'px;">'.$videocontent.$videometa.'</div>'."\n";
	if($videogalloptions['videosperrow'] == "" or $videogalloptions['videosperrow'] == 0) $videogalloptions['videosperrow'] = 3;
	if($count % $videogalloptions['videosperrow'] == 0)
	    $videoout .= '<div class="clear"></div>'."\n";
    }
    $videoout .= '<div class="clear"></div>';
    $videoout .= get_videogall_pages();
    return $videoout;
}

function display_videogall($content)
{
    $gallery = preg_match_all('/\[myvideogall:(.*)\]/',$content,$matches);
    for($i=0;$i<count($matches[0]);$i++) {
      $count++;
      $tag = explode(":",$matches[0][$i]);
      $category = str_replace(']','',$tag[1]);
      $content = str_ireplace("[myvideogall:$category]",create_videogall($category,'',false),$content);
    }
    return $content;
}

//** Function to add shadowbox attribute to images **//
//***************************************************//
function add_shadowbox_image ($content)
{
    $pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
    $replacement = '<a$1href=$2$3.$4$5 rel="shadowbox"$6>$7</a>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}

//** Functions to create widget and widget control panel **/
/**********************************************************/
function videogall_widget($args) {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    extract($args);
    echo $before_widget;
    echo $before_title;
    echo $videogalloptions['widget_title'];
    echo $after_title;
    echo create_videogall('',$videogalloptions['widget_count'],true);
    echo $after_widget;
}

function videogall_widget_control() {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    if($videogalloptions['widget_title'] == "") $videogalloptions['widget_title'] = __('Videos','videogall');
    if($videogalloptions['widget_count'] == "") $videogalloptions['widget_count'] = 5;
    if($_POST['videogall_widget_submit']) {
        $videogalloptions['widget_title'] = $_POST['videogall_widget_title'];
        $videogalloptions['widget_count'] = $_POST['videogall_widget_count'];
        update_option('videogall_extra_options',$videogalloptions);
    }
    echo '<p><label>'.__('Title').'</label></p>';
    echo '<p><input style="width: 200px;" id="videogall_widget_title" name="videogall_widget_title" type="text" value="' . $videogalloptions['widget_title'] . '" /></p>';
    echo '<p><label>'.__('Number of videos to display').'</label></p>';
    echo '<p><input style="width: 200px;" id="videogall_widget_count" name="videogall_widget_count" type="text" value="' . $videogalloptions['widget_count'] . '" /></p>';
    echo '<input type="hidden" id="videogall_widget_submit" name="videogall_widget_submit" value="1" />';
}

/************************************************************************
 ***********************************************************************/

/** Activating the plugin **/
register_activation_hook(__FILE__,'videogall_install');

/** Adding header files **/
function add_videogall_header() {
    echo '<link type="text/css" rel="stylesheet" href="'.get_bloginfo('wpurl').'/wp-content/plugins/videogall/videogallstyle.css" />'."\n";
    echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('wpurl').'/wp-content/plugins/videogall/shadowbox/shadowbox.css" type="text/css" media="screen" />'."\n";
    echo '<script type="text/javascript" src="'.get_bloginfo('wpurl').'/wp-content/plugins/videogall/shadowbox/shadowbox.js"></script>'."\n";
    echo '<script type="text/javascript">Shadowbox.init();</script>'."\n";    
}
add_action('wp_head','add_videogall_header');

/** Adding header files to admin options page **/
function add_admin_header() {
    echo '<link type="text/css" rel="stylesheet" href="'.get_bloginfo('wpurl').'/wp-content/plugins/videogall/videogalladminstyle.css" />'."\n";
    echo '<script type="text/javascript" src="'.get_bloginfo('wpurl').'/wp-content/plugins/videogall/js/videogalladmin.js"></script>'."\n";
}
add_action('admin_head', 'add_admin_header');

/** Adding the options page **/
function show_video_options() {
        include("videogalloptions.php");
}
function add_video_options() {
    add_options_page('VideoGall Options', 'videogall', 8, __FILE__, 'show_video_options');
}
add_action('admin_menu', 'add_video_options');

/** Adding the settings link **/
function add_videogall_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=videogall/videogall.php">' . __('Settings') . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter( 'plugin_action_links_' . $plugin, 'add_videogall_settings_link' );

/** Displaying the video gallery on the page **/
add_filter('the_content','display_videogall');

if($videogalloptions['imgeffect'])
    add_filter('the_content','add_shadowbox_image');
    
/** Registering widgets **/
register_sidebar_widget('Videogall', 'videogall_widget');
register_widget_control('Videogall', 'videogall_widget_control',200,200);

/** Making the plugin translation ready **/
$plugin_lang_dir = basename(dirname(__FILE__))."/languages";
load_plugin_textdomain( 'videogall', null, $plugin_lang_dir );
