<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $this->get_data('page_title'); ?></title>
    <link rel="stylesheet" href="resources/css/style.css">
</head>
<body class="<?php $this->get_data('page_class'); ?>">
    <div id="wrapper">
        <div class="secondarynav">
            <strong>0 items ($0.00) in cart</strong>&nbsp;| &nbsp;
            <a href="<?php echo SITE_PATH; ?>cart.php">Shopping Cart</a>
        </div>
        <h1><?php echo SITE_NAME; ?></h1>

        <ul class="nav">
            <?php $this->get_data('page_nav') ?>
        </ul>
