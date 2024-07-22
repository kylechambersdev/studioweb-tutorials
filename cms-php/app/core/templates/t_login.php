<!-- using APP_RESOURCES to link through an absolute path ensures that no matter where in the file directory we are calling these files, they can be reached -->
<link href="<?php echo APP_RESOURCES; ?>css/fp_style.css" media="screen" rel="stylesheet" type="text/css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript">$.noConflict();</script>
<!-- using some functions of the colorbox plugin -->
<script type="text/javascript" src="<?php echo APP_RESOURCES; ?>javascript/colorbox/colorbox.js"></script>

<link type="text/css" rel="stylesheet" href="<?php echo APP_RESOURCES; ?>javascript/colorbox/colorbox.css">
<!-- including this javascript in code so that we can use the SITE_PATH variable to ensure we access the login page -->
<script type="text/javascript">
//we can use the $ within the document.ready function
    jQuery( document ).ready(function( $ ) {
        //colorbox function and attributes
        $.colorbox({
            transition: 'fade', 
            initialWidth: '50px',
            initialHeight: '50px',
            overlayClose: false,
            escKey: false,
            scrolling: false,
            opacity: 0.6,
            //absolute path to the login page
            href: '<?php echo SITE_PATH; ?>app/login.php' 
        });
    });

</script>