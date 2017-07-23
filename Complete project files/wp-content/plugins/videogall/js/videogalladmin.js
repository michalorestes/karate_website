/** Videogall Admin Javascript **/

function validateAddVideo() {
    var emptycat;
    if(document.getElementById('add_video_category').value == "add_new_cat") {
        if(document.getElementById('add_new_video_category').value == "")
            emptycat = true;
        else emptycat = false;
    }
    if(document.getElementById('add_video_url').value == "" || document.getElementById('add_video_name').value == "" || emptycat == true) {
        toggleMessage('add_video_message',"Please enter all required fields");
        return false;
    } else {
        return true;
    }
}

function toggleMessage(elem,message) {
    document.getElementById(elem).innerHTML = '<div class="failure">' + message + '</div>';
}

function addNewCategory() {
    document.getElementById('add_new_video_category').value = "";
    jQuery('#new_category_row').slideUp('fast');
    if(document.getElementById('add_video_category').value == "add_new_cat") {        
        jQuery('#new_category_row').slideDown('slow');
    }
}

function validateEditVideo(vid) {
    var emptycat;
    if(document.getElementById('edit_video_category_'+vid).value == "add_new_cat") {
        if(document.getElementById('edit_new_video_category_'+vid).value == "")
            emptycat = true;
        else emptycat = false;
    }
    if(document.getElementById('edit_video_url_'+vid).value == "" || document.getElementById('edit_video_name_'+vid).value == "" || emptycat == true) {
        toggleMessage('edit_video_message_'+vid,"Please enter all required fields");
        return false;
    } else {
        return true;
    }
}

function editNewCategory(vid) {
    document.getElementById('edit_new_video_category_'+vid).value = "";
    jQuery('#edit_new_category_row_'+vid).slideUp('fast');
    if(document.getElementById('edit_video_category_'+vid).value == "add_new_cat") {        
        jQuery('#edit_new_category_row_'+vid).slideDown('slow');
    }
}
