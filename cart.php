<?php 
    session_start();
    include 'includes/header.php';
    if(isset($_SESSION['customer_email'])){

?>

                <!-- Start Content -->
                <div class="col-md-10 cart mb-5">
                    <form method="POST">
                        <table class="main-table table table-bordered text-center scroll">
                            <thead>
                                <tr>
                                    <td>Remove</td>
                                    <td>Product</td>
                                    <td>Quantity</td>
                                    <td>Total Price</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        $total = 0;
                                        global $con;
                                        $ip = getIp();
                                        $check_pro = $con->prepare("SELECT * FROM cart WHERE ip_add=?");
                                        $check_pro->execute(array($ip));
                                        $items = $check_pro->fetchAll();
                                
                                        foreach($items as $item){
                                            $pro_id = $item['p_id'];
                                
                                            $getPrice = $con->prepare("SELECT * FROM products WHERE product_id=?");
                                            $getPrice->execute(array($pro_id));
                                            $pro_rows = $getPrice->fetchAll();
                                            foreach($pro_rows as $product){
                                                $id = $product['product_id']; 
                                                $pro_price = array($product['product_price']);
                                                $values = array_sum($pro_price);
                                                $total +=$values; ?>
                                                    <tr>
                                                        <td><input type='checkbox' name='remove[]' value="<?php echo $product['product_id']; ?>"></td>
                                                        <td><p>
                                                            <?php echo $product['product_title']; ?>
                                                            </p><img class='img-fluid cart-img rounded img-thumbnail' src='admin_area/upload/<?php echo $product['product_image']; ?>'>
                                                        </td>
                                                        
                                                        <?php
                                                        if(isset($_POST['update'])){
                                                            if(isset($_POST['qty']) && !isset($_POST['remove'])){
                                                                $qty = $_POST['qty'];
                                                                $_SESSION['qty'] = $qty;
                                                                $updateQty = $con->prepare("UPDATE cart SET qty = '$qty' WHERE p_id = '$id' ");
                                                                $updateQty->execute();
                                                                
                                                                $total = $total*$qty;
                                                                //echo"<script>window.open('cart.php','_SELF')</script>";
                                                                
                                                                
                                                            }
                                                        }
                                                        ?>
                                                        <td><input type='number' size='4' name='qty' value='<?php echo $_SESSION['qty']; ?>' ></td>
                                                        <td> $ <?php echo $product['product_price']; ?> </td>
                                                    </tr>
                                                    <?php
                                            }
                                        } ?>

                                                    <tr>
                                                        <td colspan='3'>Sub Total</td>
                                                        <td><?php echo $total; ?> </td>
                                                    </tr>
                            </tbody>
                        </table>

                        <input class="alert alert-danger" value="Update the cart" name='update' type='submit'>
                        <input class="alert alert-success" value="Continue shopping" name='continue' type='submit'>
                        <a href='checkout.php' class="alert alert-info">Checkout</a>
                        <?php
                            $ip = getIp();
                            if(isset($_POST['update'])){
                                if(isset($_POST['remove'])){
                                    foreach($_POST['remove'] as $remove_id){
                                        $stmt = $con->prepare("DELETE FROM cart WHERE ip_add = :zadd AND p_id = :zid");
                                        $stmt->bindParam(":zadd", $ip);
                                        $stmt->bindParam(":zid", $remove_id);
                                        $stmt->execute();

                                        if($stmt->execute()){
                                            echo"<script>window.open('cart.php','_SELF')</script>";
                                        }
                                    }
                                }
                            }
                            if(isset($_POST['continue'])){
                                echo"<script>window.open('index.php','_SELF')</script>";
                            }
                            

                        ?>
                    </form>  
                    <?php
                    
                    ?>
                </div>

            </div> <!-- End First Row-->
        </div>    
        <!-- End Content-Wrapper Section -->

<?php
    }
    include 'includes/footer.php';
?>

