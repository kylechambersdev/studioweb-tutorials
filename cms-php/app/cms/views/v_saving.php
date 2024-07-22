<script>
    //more than just a call to refresh the page, b/c doing so noticed a short delay
    //want window to resize itself based on the content
    jQuery.colorbox.resize();
    jQuery.colorbox.close();
    //page refresh (important to update data displaying on webpage)
    window.location.reload();
</script>

<div id="fp_wrapper">
<h1>Edit Content Block: <i><?php echo $this->getData('block_id'); ?></i></h1>
    <div id="fp_content">
        Saving content block...
    </div>
</div>