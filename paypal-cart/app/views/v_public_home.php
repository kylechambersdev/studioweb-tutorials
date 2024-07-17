<?php include("includes/public_header.php"); ?>

<div id="content">
    <h2>All Products</h2>

    <p><?php $this->get_data('header'); ?></p>
    <ul class="alerts"><?php $this->get_alert(); ?></ul>

    <ul class="products">
        <?php $this->get_data('products'); ?>
    
</div>

<?php include("includes/public_footer.php"); ?>

