<?php

include('app/init.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	<link rel="stylesheet" href="resources/css/style.css">
	<?php
		$FP->head();
	?>
</head>
<body class="home <?php $FP->body_class(); ?>">
	<?php $FP->toolbar(); ?>
	<div id="wrapper">
		<h1>Website</h1>



		<div id="banner">
			<img src="resources/images/banner.jpg" alt="banner" width="900" height="140">
		</div>
		<ul id="nav">
			<li><a href="#">Home</a></li>
			<li><a href="#">Test Link</a></li>
			<li><a href="#">Longer Test Link</a></li>
			<li><a href="#">Contact Us</a></li>
		</ul>

		<div id="content">
			<div class="left">
				<h2><?php $FP->Cms->display_block('content-header', 'oneline') ?></h2>
				<!-- will default to wysisyg -->
				<p><?php $FP->Cms->display_block('content-maincontent') ?></p>
			</div>
			<div class="right">
				<p><?php $FP->Cms->display_block('content-quote') ?></p>
				<p><?php $FP->Cms->display_block('content-attribution') ?></p>
			</div>
		</div>
		<div id="footer">
			&copy; 2024 Test Website | <?php $FP->login_link(); ?>
		</div>
	</div>
</body>
</html>