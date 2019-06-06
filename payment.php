<?php

    $total = 0;
    global $con;
    //$ip = getIp();
    $check_pro = $con->prepare("SELECT * FROM cart WHERE c_id=?");
    $check_pro->execute(array($_SESSION['customer_id']));
    $items = $check_pro->fetchAll();

    foreach($items as $item){
        $pro_id = $item['p_id'];

        $getPrice = $con->prepare("SELECT * FROM products WHERE product_id=?");
        $getPrice->execute(array($pro_id));
        $pro_rows = $getPrice->fetchAll();
        foreach($pro_rows as $product){
            $pro_price = array($product['product_price']);
            $pro_name = $product['product_title'];
            $values = array_sum($pro_price);
            $total +=$values;
        }
    }

?>
<div>
    <h3 class="text-center">Pay with paypal</h3>
    <form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

        <!-- Identify your business so that you can collect the payments. -->
        <input type="hidden" name="business" value="businesstest14@shop.com">

        <!-- Specify a PayPal Shopping Cart Add to Cart button. -->
        <input type="hidden" name="cmd" value="_cart">
        <input type="hidden" name="add" value="1">

        <input type="hidden" name="return" value="http://muhammadmagdy.epizy.com/ecommerce/paypal_sucess.php">
        <input type="hidden" name="cancel_return" value="http://muhammadmagdy.epizy.com/ecommerce/paypal_cancel.php">

        <!-- Specify details about the item that buyers will purchase. -->
        <input type="hidden" name="item_name" value="<?php echo $pro_name; ?>">
        <input type="hidden" name="amount" value="<?php echo $total; ?>">
        <input type="hidden" name="currency_code" value="USD">

        <!-- Display the payment button. -->
        <input type="image" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_cart_LG.gif" alt="Add to Cart">
        <img alt="" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif">
    </form>
</div>