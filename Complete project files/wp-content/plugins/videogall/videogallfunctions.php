<?php
/** DO NOT MODIFY THIS FILE **/
/*****************************/
/** Videogall DB Functions **/
/****************************/
/* Getting the list of videos from database */

function get_videogall_from_db($cat,$limit,$offset) {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    $sqllimit = "";
    $sqloffset = "";
    if($limit != "" and is_numeric($limit))
        $sqllimit = " limit ".$limit;
    if($offset != "" and is_numeric($offset))
        $sqloffset = " offset ".$offset;
    if(trim($cat) == "" or trim($cat) == "all")
        $catfilter = '';
    else
        $catfilter = " where category = '".$cat."'";    
    $orderby = " order by ".$videogalloptions['sortcategory']." ".$videogalloptions['sortstyle'];
    $sql = "select * from ".$table_name.$catfilter.$orderby.$sqllimit.$sqloffset;
    $videogall = $wpdb->get_results($sql);
}

function get_videogall_count() {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    $sql = "select count(*) as cnt from ".$table_name;
    $numofrows = $wpdb->get_results($sql);
    return $numofrows[0]->cnt;
}

/* Getting list of categories from database */
function get_videogall_cat_from_db() {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    $sql = "SELECT * FROM ".$cat_table." ORDER BY catname ASC";
    $videocat = $wpdb->get_results($sql);
}

/* Adding a new video information to database */
function add_videogall_to_db($url,$name,$caption,$description,$category,$thumbnail) {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    if($url != "" and $name != "" and $category != "") {
        $sql = "INSERT INTO ".$table_name." (url,name,caption,description,category,thumbnail) VALUES ('".$url."','".$name."','".$caption."','".$description."','".$category."','".$thumbnail."')";
        $results = $wpdb->query( $sql );
        if($results != 1) { $success = false; } else { $success = true; }
    } else { $success = false; }
    return $success;
}

/* Adding new category information to database */
function add_videogall_cat_to_db($cat) {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    if($cat != "") {
        $sql = "SELECT * FROM ".$cat_table." WHERE catname = '".$cat."'";
        $results = $wpdb->query( $sql );
        if($results < 1) {
            $sql = "INSERT INTO ".$cat_table." (catname) VALUES ('".$cat."')";
            $results = $wpdb->query( $sql );
            if($results != 1) { $success = false; } else { $success = true; }
        } else {
            $success = false;
        }
    } else { $success = false; }
    return $success;
}

/* Deleting a video information from database */
function delete_videogall_from_db($id) {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    if($id != "") {
        $sql = "DELETE FROM ".$table_name." WHERE id = ".$id;
        $results = $wpdb->query( $sql );
        if($results != 1) { $success = false; } else { $success = true; }
    } else { $success = false; }
    return $success;
}

/* Deleting a category information from database */
function delete_videogall_cat_from_db($cat) {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    if($cat != "") {
        $sql = "UPDATE ".$table_name." SET category = 'uncategorized' WHERE category = '".$cat."'";
            $results = $wpdb->query( $sql );        
        $sql = "DELETE FROM ".$cat_table." WHERE catname = '".$cat."'";
        $results = $wpdb->query( $sql );        
        if($results != 1) { $success = false; } else { $success = true; }
    } else { $success = false; }
    return $success;
}

/* Updating a video informatio in database */
function update_videogall_in_db($url,$name,$caption,$description,$category,$thumbnail,$id) {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    if($url != "" and $name != "" and $category != "") {
        $sql = "UPDATE ".$table_name." SET url = '".$url."', name = '".$name."', caption = '".$caption."', description = '".$description."', category = '".$category."', thumbnail = '".$thumbnail."' WHERE id = ".$id;
        $results = $wpdb->query( $sql );
        if($results != 1) { $success = false; } else { $success = true; }
    } else { $success = false; }
    return $success;
}

/* Retreiving settings for videogall */
function get_videogall_settings() {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    $videogalloptions = get_option('videogall_extra_options');
    if(empty($videogalloptions)) {
        /** If options are not set then assigning them a default value **/
        $videogalloptions['videosize'] = "640|480";
        $videogalloptions['thumbsize'] = "250|200";
        $videogalloptions['showcaption'] = false;
        $videogalloptions['showdescription'] = false;
        $videogalloptions['videosperrow'] = "3";
        $videogalloptions['sortcategory'] = "id";
        $videogalloptions['sortstyle'] = "desc";
        $videogalloptions['videosperpage'] = "";
        $videogalloptions['imgeffect'] = false;
    }
}

/* Creating pagination for videogall */
function get_videogall_pages() {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    $links = "";
    if(is_numeric($videogalloptions['videosperpage']) and trim($videogalloptions['videosperpage']) != "") {
        $links = '<div class="videogallpages">'.__('Pages:','videogall');
        $pages = floor(get_videogall_count() / $videogalloptions['videosperpage']);
	$extra = get_videogall_count() % $videogalloptions['videosperpage'];
        if($pages == 0) $totalpages = 1;
        else if($pages > 0 and $extra == 0) $totalpages = $pages;
	else if($pages > 0 and $extra > 0) $totalpages = $pages + 1;
        for($i = 1; $i <= $totalpages; $i++) {
            if($i > 1) {
                if(preg_match('/\?/',get_permalink()) > 0)
		    $next = '&vpage='.$i;
		else
		    $next = '?vpage='.$i;                
            } else { $next = ""; }
            $links .= '<a class="videopage" href="'.get_permalink().$next.'">'.$i.'</a>';
        }
        $links .= '</div>';
    }
    return $links;
}

/** Videogall Thumbnail and URLs processing functions **/
/*******************************************************/
/* Function to get the thumbnail of the video */
function get_videogall_thumbnail($video_url) {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    $imgsrc = "";
    if(preg_match('/youtube/',$video_url) > 0)
    {
        $video_img_startpos = strpos($video_url,"=");
        $andcount = substr_count($video_url,"&");
        if($andcount > 0) {
            $video_img_endpos = strpos($video_url,"&");
            $video_img = substr($video_url,$video_img_startpos+1,$video_img_endpos-$video_img_startpos-1);
        }
        else { $video_img = substr($video_url,$video_img_startpos+1); }
        $imgsrc = 'http://img.youtube.com/vi/'.$video_img.'/default.jpg';
    }
    elseif(preg_match('/metacafe/',$video_url) > 0)
    {
        $videotoken = explode("/",$video_url);
        $imgsrc = 'http://www.metacafe.com/thumb/'.$videotoken[4].'.jpg';
    }
    elseif(preg_match('/vimeo/',$video_url) > 0) {
        $apiurl = str_replace("vimeo.com","vimeo.com/api/clip",$video_url);
        if(substr($video_url,-1) == "/") { $video_url = substr($video_url,0,-1); $apiurl .= "php"; } else { $apiurl .= "/php"; }
        $contents = @file_get_contents($apiurl);
        $array = @unserialize(trim($contents));
        $imgsrc = $array[0][thumbnail_small];
    }
	elseif(preg_match('/blip/',$video_url) > 0) {
		$blipcontent = file_get_contents($video_url,NULL,NULL,-1,2000);
		preg_match('/< *link rel="image_src" [^>]*href *= *["\']?([^"\']*)/i', $blipcontent, $imgresult);
		$imgsrc = $imgresult[1];
	}
	else {
        $imgsrc = get_bloginfo('wpurl').'/wp-content/plugins/videogall/images/default.png';
    }
    return trim($imgsrc);
}

/* This function corrects the URL entered by user to be able to display on shadowbox */
function get_videogall_url($url) {
    global $wpdb, $table_name, $cat_table, $videogall, $videocat, $videogalloptions;
    //Getting rid of slashes in the end
    $lastchar = strlen($url);
    if(substr($url,$lastchar-1) == "/")
        $url = substr($url,0,-1);
        
    if(preg_match('/youtube/',$url) > 0) {
        $andcount = substr_count($url,"&");
        if($andcount > 0) {
            $endpos = strpos($url,"&");
            $url = substr($url,0,$endpos);
        }
        $url = str_replace('watch?','',$url);
        $url = str_replace('=','/',$url);
        $url = $url.'&amp;hl=en&amp;fs=1';
    }
    else if(preg_match('/metacafe/',$url) > 0) {
        $url = str_replace('watch','fplayer',$url);
        $url = $url.".swf";
    }
    else if(preg_match('/google/',$url) > 0) {
        $lasthash = strlen($url);
        $docidcount = substr_count($url,"docid");
        if(substr($url,$lasthash-1) == "#") {
            $endpos = strpos($url,"#");
            $startpos = strpos($url,"=");
            $docid = substr($url,$startpos,$endpos);
        }
        else if($docidcount > 1) {
            $startpos = strpos($url,"#") + 1;
            $docid = str_replace('docid=','',substr($url,$startpos));
        }
        else {
            $docid = substr($url,strpos($url,"="));
        }
        
        $url = 'http://video.google.com/googleplayer.swf?docid='.$docid;
    }
    else if(preg_match('/dailymotion/',$url) > 0) {
        $url = $url.".swf";
        $url = str_replace('video','swf/video',$url);
    }
    else if(preg_match('/vimeo/',$url) > 0) {
        $url = str_replace('vimeo.com/','vimeo.com/moogaloop.swf?clip_id=',$url);
    }
	else if(preg_match('/blip/',$url) > 0) {
		$blipcontent = file_get_contents($url,NULL,NULL,-1,2000);
		preg_match('/< *link rel="video_src" [^>]*href *= *["\']?([^"\']*)/i', $blipcontent, $videoresult);
		$url = $videoresult[1];
	}
    return $url;
}

/* Checks if url is a shadowbox possible url or not */
function is_shadowbox($chkurl) {
    if(preg_match('/youtube/',$chkurl) > 0 or preg_match('/google/',$chkurl) > 0 or preg_match('/metacafe/',$chkurl) > 0 or preg_match('/dailymotion/',$chkurl) > 0 or preg_match('/vimeo/',$chkurl) > 0  or preg_match('/blip/',$chkurl) > 0)
        return true;
    else
        return false;
}
