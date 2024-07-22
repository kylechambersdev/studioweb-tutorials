<script>
    //ready method initiates after DOM is fully loaded
    jQuery(document).ready(function($){
        //selects the content block submit event
        $('#edit').submit(function(e){
            //prevents the default action of the form
            e.preventDefault();

            let id = "<?php echo $this-> getData('block_id'); ?>";

            //capture data from the content field and pass it to ajax
            //stores value of type of field to variable
            let type = $('#type').val();
            
            //if the block type is wysiwyg, triggerSave will save the content in the Tiny MCE editor
            <?php if($this->getData('block_type') == 'wysiwyg') {?>
                tinyMCE.triggerSave();
            <?php } ?>

            //stores content in the content field to variable
            let content = $('#field').val();

            //url string to pass to ajax script to pass along to edit.php
            let dataString = 'id=' + id + '&field=' + content + '&type=' + type;

            //ajax sets variables in the url
            $.ajax({
                type: "POST",
                //passing content field data to edit.php to process the inputs from user
                url: "<?php echo SITE_PATH; ?>app/cms/edit.php",
                data: dataString,
                //so browser doesnt cache the results
                cache: false,
                success: function(html){
                    //used to test ajax response is working
                    // alert(html);
                    //replace content in login pop-up (selected using #cboxLoadedContent) with content generated from the login.php file (html variable)
                    $('#cboxLoadedContent').html(html);

                }
            })
        });
        //cancel button function (cannot use .click b/c not loaded when page is first loaded, can use on() function)
        $('#fp_cancel').on('click', function(e){
            //keeps the colorbox from closing automatically
            e.preventDefault();
            $.colorbox.close();
        });
    });
</script>
<?php if ($this->getData('block_type') == 'wysiwyg'){ ?>
<!-- <script
type="text/javascript"
src='https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js'
referrerpolicy="origin">
</script> -->
  <script type="text/javascript">
  tinymce.init({
    selector: 'none',
    content_css: "<?php echo SITE_CSS ?>, <?php echo APP_RESOURCES; ?>css/tiny_mce_style.css",
    width: 700,
    height: 300,
    plugins: [
      'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
      'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
      'media', 'table', 'emoticons', 'help'
    ],
    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
      'forecolor backcolor emoticons | help',
    menu: {
      favs: { title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons' }
    },
    menubar: 'favs file edit view insert format tools table help',
    content_css: 'css/content.css'
  });
  </script>
<?php } ?>
<div id="fp_wrapper">
    <h1>Edit Content Block: <i><?php echo $this->getData('block_id'); ?></i></h1>
    <div id="fp_content">
        <form action="" method="post" id="edit">
            <div>
                <div class="row">
                    <label for="field">Block Content:</label>
                </div>
                <div class="row">
                    <?php echo $this->getData('cms_field'); ?>
                    <input type="hidden" id="type" value="<?php $this->getData('block_type'); ?>">
                </div>
                <div class="row submitrow">

                    <input type="submit" name="submit" class="submit" value="Submit">
                    &nbsp;<a href="#" id="fp_cancel">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
