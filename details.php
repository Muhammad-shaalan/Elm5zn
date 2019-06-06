<?php 
$exsit = '';
session_start(); 
    include 'includes/header.php';
?> 
        <!-- Start Content-Wrapper Section -->
        <div class="content">
            <?php
                if(isset($_GET['proid'])){
                    $product_id = $_GET['proid'];
                    
                    $stmt = $con->prepare("SELECT products.*, categories.cat_title AS cat_title , brands.brand_title AS brand_title 
                                            FROM products
                                            INNER JOIN categories ON products.product_cat = categories.cat_id
                                            INNER JOIN brands ON products.product_brand = brands.brand_id
                                            WHERE product_id=?");
                    
                    $stmt->execute(array($product_id));
                    $product = $stmt->fetch();
                    $count = $stmt->rowCount();

                    if($count > 0){ ?>
                        <div class="container">
                            <h1 class="text-center"><?php echo $product['product_title'] ?></h1>
                            <div class="row">
                                <div class="col-md-3 mt-5">
                                    <img src="admin_area/upload/<?php echo $product['product_image'];?>">
                                </div>
                                <div class="col-md-6 mt-5">
                                    <p class="details-info"><span>Product Brand:</span> <?php echo $product['brand_title']; ?></p>
                                    <p class="details-info"><span>Product Category:</span> <?php echo $product['cat_title']; ?></p>
                                    <p class="details-info"><span>Product Description:</span> <?php echo $product['product_desc']; ?></p>
                                    <p class="details-info"><span>Product Price:</span> $<?php echo $product['product_price']; ?></p>
                                </div>
                                <div class="col-md-2 mt-5">
                                    <?php
                                    if(isset($_SESSION['customer_email'])){?>
                                        <a href="index.php?add_cart=<?php echo $product_id; ?>&id=<?php echo $_SESSION['customer_id']; ?>" class="float-right alert alert-primary details-cart">Cart</a>        
                                    <?php }?>
                                </div>
                            </div>
                        </div>        
            
                <?php }
                }
                
            ?>
        </div>    
        <!-- End Content-Wrapper Section -->

<?php
    include 'includes/footer.php';
?>