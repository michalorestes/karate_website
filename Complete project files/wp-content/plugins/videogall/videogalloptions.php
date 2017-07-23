<?php
/**
 * Videogall options page
 */
/** DO NOT MODIFY THIS FILE **/
/*****************************/
global $wpdb, $table_name, $cat_table, $videogall, $videogalloptions, $videocat;
$addmessage = "";
$editmessage = "";
$edit_success_message = "";
$delete_cat_success_message = "";

/* This function generates the category dropdown */
function get_category_dropdown() {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    get_videogall_cat_from_db();
    echo '<option value="uncategorized">'.__('uncategorized','videogall').'</option>'."\n";
    foreach($videocat as $category) {
        echo '<option value="'.$category->catname.'">'.$category->catname.'</option>'."\n";
    }
    echo '<option value="add_new_cat">'.__('Add new category','videogall').'</option>'."\n";
}

function get_edit_category_dropdown($current) {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    get_videogall_cat_from_db();
    echo '<option value="uncategorized">'.__('uncategorized','videogall').'</option>'."\n";
    foreach($videocat as $category) {
        if($category->catname == $current)
            $selected = 'selected="selected"';
        else $selected = "";
        echo '<option value="'.$category->catname.'" '.$selected.'>'.$category->catname.'</option>'."\n";
    }
    echo '<option value="add_new_cat">'.__('Add new category','videogall').'</option>'."\n";
}

function get_delete_category_dropdown() {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    get_videogall_cat_from_db();
    foreach($videocat as $category) {
        echo '<option value="'.$category->catname.'">'.$category->catname.'</option>'."\n";
    }
}

/* Calling DB function to add video */
if(isset($_POST['add_video_submit'])) {
    $success = true;
    if(trim($_POST['add_new_video_category']) != "") {
        $addcat = $_POST['add_new_video_category'];
        $addcat = strtolower($addcat);
        $success = add_videogall_cat_to_db($addcat);
    } else {        
        $addcat = $_POST['add_video_category'];
        $addcat = strtolower($addcat);
    }
    if($success)
        $success = add_videogall_to_db($_POST['add_video_url'], $_POST['add_video_name'], $_POST['add_video_caption'], $_POST['add_video_description'], $addcat, $_POST['add_video_thumbnail']);
        
    if($success) {
        $addmessage = '<div class="success">'.__('Video added successfully','videogall').'</div>';
    } else {
        $addmessage = '<div class="failure">'.__('Video could not be added','videogall').'</div>';
    }
}

/* Calling DB function to edit video */
if(isset($_POST['edit_video_submit'])) {
    $success = true;
    $id = $_POST['edit_video_id'];
    if(trim($_POST['edit_new_video_category_'.$id]) != "") {
        $editcat = $_POST['edit_new_video_category_'.$id];
        $editcat = strtolower($editcat);
        $success = add_videogall_cat_to_db($editcat);
    } else {
        $editcat = $_POST['edit_video_category_'.$id];
        $editcat = strtolower($editcat);
        $success = true;
    }
    if($success) {
        $success = update_videogall_in_db($_POST['edit_video_url_'.$id],$_POST['edit_video_name_'.$id],$_POST['edit_video_caption_'.$id],$_POST['edit_video_description_'.$id],$editcat,$_POST['edit_video_thumbnail_'.$id],$id);
    }
    
    if($success) {
        $edit_success_message = '<div class="success">'.__('Video successfully updated','videogall').'</div>';
    } else {
        $edit_success_message = '<div class="failure">'.__('Video could not be updated','videogall').'</div>';
    }
}

/* Calling DB function to delete category */
if(isset($_POST['delete_category_submit'])) {
    $success = delete_videogall_cat_from_db($_POST['delete_video_category']);
    if($success) {
        $delete_cat_success_message = '<div class="success">'.__('Category successfully deleted','videogall').'</div>';
    } else {
        $delete_cat_success_message = '<div class="failure">'.__('Category could not be deleted','videogall').'</div>';
    }
}

/* Calling DB function to delete video */
if(isset($_POST['delete_video_submit'])) {
    $id = $_POST['edit_video_id'];
    $success = delete_videogall_from_db($id);
    if($success) {
        $edit_success_message = '<div class="success">'.__('Video deleted successfully','videogall').'</div>';
    } else {
        $edit_success_message = '<div class="failure">'.__('Video could not be deleted','videogall').'</div>';
    }
}

/* Updating options */
if(isset($_POST['save_options_submit'])) {
    if(trim($_POST['videos_per_row']) == "") $videosperrow = 3; else $videosperrow = $_POST['videos_per_row'];
    $videogalloptions['videosize'] = $_POST['video_size'];
    $videogalloptions['thumbsize'] = $_POST['thumb_size'];
    $videogalloptions['showcaption'] = $_POST['show_caption'];
    $videogalloptions['showdescription'] = $_POST['show_description'];
    $videogalloptions['sortcategory'] = $_POST['sort_category'];
    $videogalloptions['videosperrow'] = $videosperrow;
    $videogalloptions['sortstyle'] = $_POST['sort_style'];
    $videogalloptions['videosperpage'] = $_POST['videos_per_page'];
    $videogalloptions['imgeffect'] = $_POST['img_effect'];
    update_option('videogall_extra_options',$videogalloptions);
    $settings_success_message = '<div class="success">'.__('Settings saved','videogall').'</div>';
}

if(isset($_POST['delete_options_submit'])) {
    delete_option('videogall_extra_options');
    get_videogall_settings();
    $settings_success_message = '<div class="success">'.__('Default settings restored','videogall').'</div>';
}
?>

<!-- Option form begins -->
<h1 class="videogalladmintitle"><?php _e('Videogall Settings','videogall'); ?></h1>
<div class="videogalladminsection">
	<h3><?php _e('Like this Plugin ? Feel free to donate'); ?></h3>
	<p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ADF8FZXQNQRXS" class="donate_btn"><?php _e('Donate via PayPal','multi-color'); ?></a></p>
    <h3><?php _e('Add a new video','videogall'); ?></h3>
    <form name="addvideoform" id="addvideoform" method="post" onsubmit="return validateAddVideo()" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>#addvideoform">
    <span id="add_video_message"><?php echo $addmessage; ?></span>
    <table class="vidlayout">
        <tr>
            <td><?php _e('URL of the video','videogall'); ?> *</td>
            <td><input type="text" name="add_video_url" id="add_video_url" value="" /></td>
        </tr>
        <tr>
            <td><?php _e('Name of the video','videogall'); ?> *</td>
            <td><input type="text" name="add_video_name" id="add_video_name" value="" /></td>
        </tr>
        <tr>
            <td><?php _e('Caption of the video','videogall'); ?></td>
            <td><input type="text" name="add_video_caption" id="add_video_caption" value="" /></td>
        </tr>
        <tr>
            <td style="vertical-align: middle;"><?php _e('Description for the video','videogall'); ?></td>
            <td><textarea cols="15" rows="5" name="add_video_description" id="add_video_description"></textarea></td>
        </tr>
        <tr>
            <td><?php _e('Category of the video','videogall'); ?></td>
            <td>
                <select name="add_video_category" id="add_video_category" onchange="addNewCategory()">
                    <?php get_category_dropdown(); ?>
                </select>
            </td>
        </tr>
        <tr id="new_category_row">
            <td><?php _e('New Category Name','videogall'); ?> *</td>
            <td>                
                <input type="text" name="add_new_video_category" id="add_new_video_category" value="" />
            </td>
        </tr>
        <tr>
            <td><?php _e('Custom Thumbnail of the video','videogall'); ?></td>
            <td><input type="text" name="add_video_thumbnail" id="add_video_thumbnail" value="" /></td>
        </tr>        
    </table>
    <p><strong><?php _e('* are required fields','videogall'); ?></strong></p>
    <input type="submit" class="btn" name="add_video_submit" id="add_video_submit" value="<?php _e('Add video'); ?>" />
    </form>
</div>

<div class="videogalladminsection">
    <h3><?php _e('Delete Category','videogall'); ?></h3>
    <form name="deletecatform" id="deletecatform" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>#deletecatform">
    <span id="delete_cat_success_message"><?php echo $delete_cat_success_message; ?></span>
    <table class="vidlayout">
        <tr>
            <td><?php _e('Category of the video','videogall'); ?></td>
            <td>
                <select name="delete_video_category" id="delete_video_category">
                    <?php get_delete_category_dropdown(); ?>
                </select>
            </td>
        </tr>
    </table>
    <input type="submit" class="btn" name="delete_category_submit" id="delete_category_submit" value="<?php _e('Delete category','videogall'); ?>" />
    </form>
</div>

<div class="videogalladminsection">
    <h3><?php _e('Configure additional video options','videogall'); ?></h3>
    <form name="extraoptionsform" id="extraoptionsform" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>#extraoptionsform">
    <span id="settings_success_message"><?php echo $settings_success_message; ?></span>
    <table class="vidlayout">
        <tr>
            <td style="width: 250px;"><?php _e('Size of the video','videogall'); ?></td>
            <td>
                <select name="video_size" id="video_size">
                    <option value="320|240" <?php if($videogalloptions['videosize'] == "320|240") echo 'selected="selected"'; ?>>320 x 240</option>
                    <option value="640|480" <?php if($videogalloptions['videosize'] == "640|480") echo 'selected="selected"'; ?>>640 x 480</option>
                    <option value="960|720" <?php if($videogalloptions['videosize'] == "960|720") echo 'selected="selected"'; ?>>960 x 720</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><?php _e('Size of the thumbnails','videogall'); ?></td>
            <td>
                <select name="thumb_size" id="thumb_size">
                    <option value="150|100" <?php if($videogalloptions['thumbsize'] == "150|100") echo 'selected="selected"'; ?>>150 x 100</option>
                    <option value="250|200" <?php if($videogalloptions['thumbsize'] == "250|200") echo 'selected="selected"'; ?>>250 x 200</option>
                    <option value="350|300" <?php if($videogalloptions['thumbsize'] == "350|300") echo 'selected="selected"'; ?>>350 x 300</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><?php _e('Display Caption below the thumbnails','videogall'); ?></td>
            <td><input type="checkbox" name="show_caption" id="show_caption" value="true" <?php if($videogalloptions['showcaption']) echo "checked"; ?> /></td>
            <td style="width: 300px; text-align: left; font-style: italic;"><?php _e('Note: If this setting is enabled and a video does not have caption, then the video "Name" would be used by default','videogall'); ?></td>
        </tr>
        <tr>
            <td><?php _e('Display Description below the thumbnails','videogall'); ?></td>
            <td><input type="checkbox" name="show_description" id="show_description" value="true" <?php if($videogalloptions['showdescription']) echo "checked"; ?> /></td>
            <td style="width: 300px; text-align: left; font-style: italic;"><?php _e('Note: If this setting is enabled and a video does not have description, then the video "Name" would be used by default','videogall'); ?></td>
        </tr>
        <tr>
            <td><?php _e('Number of videos in one row','videogall'); ?></td>
            <td><input type="text" name="videos_per_row" id="videos_per_row" value="<?php echo $videogalloptions['videosperrow']; ?>" /></td>
            <td style="width: 300px; text-align: left; font-style: italic;"><?php _e('Note: If this is blank, then default value of 3 considered','videogall'); ?></td>
        </tr>
        <tr>
            <td><?php _e('Sorting options','videogall'); ?></td>
            <td>
                <select name="sort_category" id="sort_category">
                    <option value="id" <?php if($videogalloptions['sortcategory'] == "id") echo 'selected="selected"'; ?>><?php _e('Date','videogall'); ?></option>
                    <option value="name" <?php if($videogalloptions['sortcategory'] == "name") echo 'selected="selected"'; ?>><?php _e('Name','videogall'); ?></option>
                    <option value="caption" <?php if($videogalloptions['sortcategory'] == "caption") echo 'selected="selected"'; ?>><?php _e('Caption','videogall'); ?></option>
                </select>
                
                <select name="sort_style" id="sort_style">
                    <option value="asc" <?php if($videogalloptions['sortstyle'] == "asc") echo 'selected="selected"'; ?>><?php _e('Ascending','videogall'); ?></option>
                    <option value="desc" <?php if($videogalloptions['sortstyle'] == "desc") echo 'selected="selected"'; ?>><?php _e('Descending','videogall'); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td><?php _e('Number of videos to display per page','videogall'); ?></td>
            <td><input type="text" name="videos_per_page" id="videos_per_page" value="<?php echo $videogalloptions['videosperpage']; ?>" /></td>
            <td style="width: 300px; text-align: left; font-style: italic;"><?php _e('Note: If this is blank, then all videos will be on same page','videogall'); ?></td>
        </tr>
        <tr>
            <td><?php _e('Apply shadowbox effect to images','videogall'); ?></td>
            <td><input type="checkbox" name="img_effect" id="img_effect" value="true" <?php if($videogalloptions['imgeffect']) echo "checked"; ?> /></td>            
        </tr>
    </table>
    <input type="submit" class="btn" name="save_options_submit" id="save_options_submit" value="<?php _e('Save Settings','videogall'); ?>" />
    <input type="submit" class="btn" name="delete_options_submit" id="delete_options_submit" value="<?php _e('Restore Default Settings','videogall'); ?>" />
    </form>
</div>

<div class="videogalladminsection">
    <h3><?php _e('Edit videos','videogall'); ?></h3>
    <span id="edit_success_message"><?php echo $edit_success_message; ?></span>
    <table class="vidlayout" style="width: 700px;">
        <?php
            get_videogall_from_db('','','');
            foreach($videogall as $video) {
                $editid  = $video->id;
                $editmessage = "";
        ?>
        <tr>
            <td style="padding:10px; text-align: center; width: 230px;">
                <?php
                    if(trim($video->thumbnail) != "")
                        echo '<img src="'.$video->thumbnail.'" width="200" height="150" />';
                    else
                        echo '<img src="'.get_videogall_thumbnail($video->url).'" width="200" height="150" />';
                ?>
            </td>
            <td style="padding:10px;width:470px;">
               <form name="editvideoform_<?php echo $editid; ?>" id="editvideoform_<?php echo $editid; ?>" onsubmit="return validateEditVideo('<?php echo $editid; ?>')" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>#edit_success_message">
               <span id="edit_video_message_<?php echo $editid; ?>"><?php echo $editmessage; ?></span>
               <p><?php _e('URL of the video','videogall'); ?> * <input type="text" name="edit_video_url_<?php echo $editid; ?>" id="edit_video_url_<?php echo $editid; ?>" value="<?php echo $video->url; ?>" /></p>
               <p><?php _e('Name of the video','videogall'); ?> * <input type="text" name="edit_video_name_<?php echo $editid; ?>" id="edit_video_name_<?php echo $editid; ?>" value="<?php echo $video->name; ?>" /></p>
               <p><?php _e('Caption of the video','videogall'); ?>  <input type="text" name="edit_video_caption_<?php echo $editid; ?>" id="edit_video_caption_<?php echo $editid; ?>" value="<?php echo $video->caption; ?>" /></p>
               <p><?php _e('Description for video','videogall'); ?> <textarea style="vertical-align: middle;" cols="15" rows="5" name="edit_video_description_<?php echo $editid; ?>" id="edit_video_description_<?php echo $editid; ?>"><?php echo $video->description; ?></textarea></p>
               <p><?php _e('Category of the video','videogall'); ?> 
                  <select name="edit_video_category_<?php echo $editid; ?>" id="edit_video_category_<?php echo $editid; ?>" onchange="editNewCategory('<?php echo $editid; ?>')">
                    <?php get_edit_category_dropdown($video->category); ?>
                  </select>
               </p>
               <p class="edit_new_category_row" id="edit_new_category_row_<?php echo $editid; ?>"><?php _e('New Category Name','videogall'); ?> * <input type="text" name="edit_new_video_category_<?php echo $editid; ?>" id="edit_new_video_category_<?php echo $editid; ?>" value="" /></p>
               <p><?php _e('Custom Thumbnail of the video','videogall'); ?> <input type="text" name="edit_video_thumbnail_<?php echo $editid; ?>" id="edit_video_thumbnail_<?php echo $editid; ?>" value="<?php echo $video->thumbnail; ?>" /></p>               
               <p><strong><?php _e('* are required fields','videogall'); ?></strong></p>
               <input type="hidden" name="edit_video_id" id="edit_video_id" value="<?php echo $editid; ?>" />
               <input type="submit" class="btn" name="edit_video_submit" id="edit_video_submit" value="<?php _e('Submit Changes','videogall'); ?>" />
               <input type="submit" style="margin-left: 15px;" class="btn" name="delete_video_submit" id="delete_video_submit" value="<?php _e('Delete Video','videogall'); ?>" />
               </form>
            </td>
        </tr>
        <?php
            }
        ?>
    </table>
</div>