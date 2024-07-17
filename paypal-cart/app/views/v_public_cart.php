<?php include("includes/public_header.php"); ?>

<div id="content">
    <h2>Shopping Cart</h2>

    <ul class="alerts"><?php $this->get_alert(); ?></ul>

    <form action="" method="POST">
        <ul class="cart">
            <?php $this->get_data('cart_rows'); ?>
        </ul>

        <div class="buttons_row">
            <a class="button_alt" href="?empty">Empty Cart</a>
            <input type="submit" name="update" class="button_alt" value="Update Cart">
        </div>
    </form>

    <form action="" method="post">
        <div class="submit_row">
            <input type="submit" name="submit" class="button" value="Pay with PayPal">
        </div>
    </form>
    
</div>

<?php include("includes/public_footer.php"); ?>

