<?php
session_start(); 
    include 'includes/header.php';
?>

                <!-- Start Content -->
                <div class="col-md-10 mb-5">
                    <div class="content-display">
                        <div class="row">
                            
                        <?php 
                        // DISPLAY BY CATEGORY ID
                        if(!isset($_GET['cat_id']) && !isset($_GET['brand_id'])){
                            $where = Null;
                        }elseif(isset($_GET['cat_id'])){
                            $x = $_GET['cat_id'];
                            $where = "WHERE product_cat = $x";
                        }    
                        // DISPLAY BY BRAND ID
                        else{
                            $x = $_GET['brand_id'];
                            $where = "WHERE product_brand = $x";
                        }    
                            $products = get("products", $where);
                            foreach($products as $product){ ?>
                                <div class="col-md-4 col-sm-6">
                                    <div class="card">
                                        <img class="card-img-top" src="<?php echo 'admin_area/upload/'.$product['product_image']; ?>" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $product['product_title']; ?> <span><?php echo $product['product_desc']; ?></span></h5>
                                            <p>
                                                <span class="price"><?php echo $product['product_price']; ?> EGP</span>
                                            </p>
                                            <p>
                                                <a href="details.php?proid=<?php echo $product['product_id']; ?>" class="">Details</a>
                                                <?php
                                                    if(isset($_SESSION['customer_email'])){?>
                                                        <a href="?add_cart=<?php echo $product['product_id']; ?>&id=<?php echo $_SESSION['customer_id']; ?>" class="float-right">Cart</a>        
                                                <?php
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        ?>
                        </div> <!-- End Row-->
                    </div>
                </div>
                <!-- End Of Content-Display -->
            </div> <!-- End First Row-->
        </div>    
        <!-- End Content-Wrapper Section -->

<?php
    include 'includes/footer.php';
?>

