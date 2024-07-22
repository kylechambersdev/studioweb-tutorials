<!-- using APP_RESOURCES to link through an absolute path ensures that no matter where in the file directory we are calling these files, they can be reached -->
<link href="<?php echo APP_RESOURCES; ?>css/fp_style.css" media="screen" rel="stylesheet" type="text/css">
<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- makes it so $ from php dont conflict with $ from jquery -->
<script type="text/javascript">$.noConflict();</script>
<!-- using some functions of the colorbox plugin -->
<script type="text/javascript" src="<?php echo APP_RESOURCES; ?>javascript/colorbox/colorbox.js"></script>
<!-- tiny mce for wysiwyg editor -->
<script type="text/javascript" src="<?php echo APP_RESOURCES ?>javascript/tinymce/tinymce.min.js"></script>



<link type="text/css" rel="stylesheet" href="<?php echo APP_RESOURCES; ?>javascript/colorbox/colorbox.css">
<!-- including this javascript in code so that we can use the SITE_PATH variable to ensure we access the login page -->
<script type="text/javascript">
//we can use the $ within the document.ready function
    jQuery( document ).ready(function( $ ) {
        //loop through all editable fields
        $('.fp_edit').each(function(){
            //height of the editable field (outerHeight() includes margin and padding)
            var height = $(this).outerHeight();
            if(height <25) {height = 25;}
            //width of parent element of editable field
            var width = $(this).parent().width();

            // alert("height: " + height + " width: " +width);

            //use info to set widths and heights of all editable fields
            $(this).height(height).width(width);
            //set the height and width of the edit link (-2 to remove the 1px border)
            $(this).find('.fp_edit_link'). height(height-2).width(width-2);
        });
        //hover effect for editable fields (content link) when hovering over content type (WYSIWYG, Textarea, One Line)- parent of edit link is div with class fp_edit
        $('.fp_edit_type').mouseenter(function(){
            $(this).parent().find('.fp_edit_link').addClass('hover');
        }).mouseleave(function(){
            $(this).parent().find('.fp_edit_link').removeClass('hover');
        });

        //switches Preview Page text(t_toolbar.php) to Edit Page, when clicked, and vice versa (overall will show/hide editable block/links)
        $('#edit_toggle').click(function(e){
            e.preventDefault();

            if($(this).text() == 'Preview Page')
            {   
                $(this).text('Edit Page');
            }
            else
            {
                $(this).text('Preview Page');
            }
            //toggle switches between display: none and display: block
            $('.fp_edit_type').toggle();
            $('.fp_edit_link').toggle();
        });
        //this is not functioning, opens link instead of opening colorbox
        $('.fp_edit_type, .fp_edit_link').click(function(e){
            //this means when element is clicked
            $(this).colorbox({
                transition: 'fade', 
                initialWidth: '50px',
                initialHeight: '50px',
                overlayClose: false,
                escKey: false,
                opacity: 0.6,
				iframe: true,
				top: '28px',
				width: '940px',
				height: '80%'
            });
        });

		//this is not functioning, opens link instead of opening colorbox
		$('.fp_dashboard, .fp_password').click(function(e){
			//this means when element is clicked
			$(this).colorbox({
				transition: 'fade', 
				initialWidth: '50px',
				initialHeight: '50px',
				overlayClose: true,
				escKey: true,
				opacity: 0.6
			});
		});
        //cancel button function (cannot use .click b/c not loaded when page is first loaded, can use on() function)
        $('#fp_cancel').on('click', function(e){
            //keeps the colorbox from closing automatically
            e.preventDefault();
            $.colorbox.close();
        });
    });

</script>