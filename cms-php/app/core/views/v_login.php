<script>
    //ready method initiates after DOM is fully loaded
    jQuery(document).ready(function($){
        //selects the login form submit event
        $('#login').submit(function(e){
            //prevents the default action of the form
            e.preventDefault();

            //capture data from the form and pass it to ajax
            //stores value of username input field to variable
            var username = $('input#username').val();
            //stores value of password input field to variable
            var password = $('input#password').val();

            //variable to pass to ajax script
            var dataString = 'username=' + username + '&password=' + password;

            $.ajax({
                type: "POST",
                //passing form data to login.php to process the inputs from user
                url: "<?php echo SITE_PATH; ?>app/login.php",
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
            //get the url
            var page = window.location.href;
            //selects start of url to '?'
            page = page.substring(0, page.lastIndexOf('?'));
            //reload the url using the page variable
            window.location = page;


        });
    })
</script>
<div id="fp_wrapper">
    <h1>FlightPath CMS</h1>
    <div id="fp_content">
        <form action="" method="post" id="login">
            <div>
            <?php
            $alerts = $this->getAlerts();
            if($alerts != '') {echo '<ul class="alerts">' . $alerts . '</ul>';}
            ?>
            <div class="row">
                <label for="username">Username: *</label>
                <input type="text" name="username" id="username" value="<?php echo $this->getData('input_user'); ?>" class="><?php echo $this->getData('error_user');  ?>">
            </div>
            <div class="row">
                <label for="password">Password: *</label>
                <input type="password" name="password" id="password" value="<?php echo $this->getData('input_pass'); ?>" class="<?php echo $this->getData('error_pass');  ?>">
            </div>
            <div class="row submitrow">

                <input type="submit" name="submit" class="submit" value="Log In">
                &nbsp;<a href="#" id="fp_cancel">Cancel</a>
            </div>
            </div>
        </form>
    </div>
</div>
