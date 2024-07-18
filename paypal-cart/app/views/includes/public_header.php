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
            <!-- setting get_data to false will prevent the data from being displayed -->
            <strong>
            <?php 
            //get total items and costs, and set to variables
            $items = $this->get_data('cart_total_items', FALSE); 
            $price = $this->get_data('cart_total_cost', FALSE);
            if($items == 1)
            {
                echo $items . ' item ($' . $price . ') in cart';
            }
            else
            {
                echo $items . ' items ($' . $price . ') in cart';
            }
            ?></strong>&nbsp;| &nbsp;
            <a href="<?php echo SITE_PATH; ?>cart.php">Shopping Cart</a>
        </div>
        <h1><?php echo SITE_NAME; ?></h1>

        <ul class="nav">
            <?php $this->get_data('page_nav') ?>
        </ul>
