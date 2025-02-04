<!-- turns off error reporting on webpage -->
<?php
// error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
// ini_set('display_errors', '0');
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>	
		<title>Validation Example</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
		<script type="text/javascript" src="ljquery.js"></script>  
		<script type="text/javascript" src="lvalidate.js"></script> 
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
         

		<script type="text/javascript">
        //syntax is standard jquery
		$(document).ready(function(){
            // additional package for jquery validator for phoneUS validation
            jQuery.validator.setDefaults({
                debug: true,
                success: "valid"
                });
                $( "#myform" ).validate({
                rules: {
                    field: {
                    required: true,
                    phoneUS: true
                    }
                }
                });
                //this points the jquery to the form
            $("#form").validate();
        });
		</script>

		<style type="text/css">
			body { font-family: Arial; font-size: 12px; }
			fieldset { border:0; }
			label { display: block; width: 180px; float:left; clear:both; margin-top: 10px; }
			label em { display: block; float:right; padding-right:8px; color:red; }
			textarea, input { float:left; width: 220px; padding: 2px; }
			textarea { height: 180px; }
			#submit { margin-left:180px; clear:both; width:100px; }
			
			label.error { float: left; color: red; clear:none; width:200px; padding-left: 10px; font-size: 11px; }
			.required_msg { padding-left: 180px; clear:both; float:left; color:red; }
		</style>
	</head>
	<body>
		
		<form action="" method="post" id="form">
			<fieldset>
			
				<label for="name">Name: <em>*</em></label>
                <!-- class=require is from validate.js -->
				<input type="text" name="name" id="name" class="required" value="<?php echo $form['name']; ?>"> <?php echo $error['name'] ?>
				
				<label for="phone">Phone (000-000-0000): <em>*</em></label>
                <!-- class=require is from validate.js class=phoneUS is from additional-methods.js-->
				<input type="text" name="phone" id="phone" class="required phoneUS" value="<?php echo $form['phone']; ?>"> <?php echo $error['phone'] ?>
				
				<label for="fax">Fax (000-000-0000):</label>
				<input type="text" name="fax" id="fax" value="<?php echo $form['fax']; ?>">				
				<label for="email">Email: <em>*</em></label>
                <!-- class=require email is from validate.js -->
				<input type="text" name="email" id="email" class="required email" value="<?php echo $form['email']; ?>"> <?php echo $error['email'] ?>
				
				<label for="comments">Comments:</label>
				<textarea name="comments" id="comments"><?php echo $form['comments']; ?></textarea>
				
				<p class="required_msg">* required fields</p>
				
				<input type="submit" name="submit" id="submit">
			
			</fieldset>
		</form>
		
	</body>
</html>