<?php

include("../init.php");
//check if user is logged in to access edit page
$FP->Auth->checkAuthorization();

//if field has input, but id or type are missing
if(isset($_POST['field']) && (isset($_POST['id']) == FALSE || isset($_POST['type']) == FALSE))
{
	//show error
	$FP->Template->error('', 'Please do not open edit windows within a new window or tab.  Return to the main website and edit your content in the popup window.');
	exit;
}
//refers to main field we are editing, and id and type are set
else if(isset($_POST['field']))
{
	//get data
	//get post id
	$id = $FP->Cms->clean_block_id($_POST['id']);
	//gives us access to block_id for saving
	$FP->Template->setData('block_id', $id);
	//get post type
	$type = htmlentities($_POST['type'], ENT_QUOTES);
	//get post content (field variable established for submitting content)
	$content = $_POST['field'];

	$FP->Cms->update_block($id, $content);

	//close colorbox and refresh page
	$FP->Template->load(APP_PATH . 'cms/views/v_saving.php');
}
else
{
    //check if id and type are set in url
    if(isset($_GET['id']) == FALSE || isset($_GET['type']) == FALSE)
    {
        //if missing, show error
        $FP->Template->error();
        exit;
    }
    //if present, clean id
    $id = $FP->Cms->clean_block_id($_GET['id']);
    $type = htmlentities($_GET['type'], ENT_QUOTES);

    $content = $FP->Cms->load_block($id);

    $FP->Template->setData('block_id', $id);
    $FP->Template->setData('block_type', $type);
    //dont clean (false)
    $FP->Template->setData('cms_field', $FP->Cms->generate_field($type, $content), false);

    //load view
    $FP->Template->load(APP_PATH . 'cms/views/v_edit.php');
}