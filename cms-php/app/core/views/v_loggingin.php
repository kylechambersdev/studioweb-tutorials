<script>
    //more than just a call to refresh the page, b/c doing so noticed a short delay
    //want window to resize itself based on the content
    jQuery.colorbox.resize();
    jQuery.colorbox.close();
    //get the url
    var page = window.location.href;
    //selects start of url to '?'
    page = page.substring(0, page.lastIndexOf('?'));
    //reload the url using the page variable
    window.location = page;
</script>

<div id="fp_wrapper">
    <h1>Log In</h1>
    <div id="fp_content">
        Logging in...
    </div>
</div>