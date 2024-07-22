<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>FlightPath CMS</title>

	<link rel="stylesheet" href="resources/css/style.css">

    <!-- using APP_RESOURCES to link through an absolute path ensures that no matter where in the file directory we are calling these files, they can be reached -->
    <link href="<?php echo APP_RESOURCES; ?>css/fp_style.css" media="screen" rel="stylesheet" type="text/css">

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- makes it so $ from php dont conflict with $ from jquery -->
    <script type="text/javascript">$.noConflict();</script>
   
    <!-- tiny mce for wysiwyg editor -->
    <script type="text/javascript" src="<?php echo APP_RESOURCES ?>javascript/tinymce/tinymce.min.js"></script>



    
    <script type="text/javascript">
    //we can use the $ within the document.ready function
        jQuery( document ).ready(function( $ ) {
            
            //cancel button function (cannot use .click b/c not loaded when page is first loaded, can use on() function)
            $('#fp_cancel, #fp_close').on('click', function(e){
                //keeps the colorbox from closing automatically
                e.preventDefault();
                //we want to close a colorbox thats within the body of the page (ie. parent), and not in the iframe as before when we used $.colorbox.close()
                parent.jQuery.colorbox.close();
            });
        });

    </script>
</head>
