<?php 
    include 'includes/header.php';
    session_start();
    if(!isset($_SESSION['admin_email'])){
        echo "<script>window.open('login.php?not_admin=You are not an admin!','_self')</script>";
    }else{

?>
        <div class="content">
                <div class='row'>
                    <!-- Start Content Display -->
                    <div class="col-md-10 mb-5">
                        <div class="content-display">
                            <?php 
                                if(isset($_GET['insert_product'])){
                                    include 'insert.php';
                                }elseif(isset($_GET['view_products'])){
                                    include 'view_products.php';
                                }elseif(isset($_GET['editPro'])){
                                    include 'edit_pro.php';
                                }
                                elseif(isset($_GET['deletePro'])){
                                    include 'delete_pro.php';
                                }
                                
                                elseif(isset($_GET['insert_cat'])){
                                    include 'insert_cat.php';
                                }elseif(isset($_GET['view_cats'])){
                                    include 'view_categories.php';
                                }elseif(isset($_GET['editCat'])){
                                    include 'edit_cat.php';
                                }elseif(isset($_GET['deleteCat'])){
                                    include 'delete_cat.php';
                                }

                                elseif(isset($_GET['insert_brand'])){
                                    include 'insert_brand.php';
                                }elseif(isset($_GET['view_brands'])){
                                    include 'view_brands.php';
                                }elseif(isset($_GET['editBrand'])){
                                    include 'edit_brand.php';
                                }elseif(isset($_GET['deleteBrand'])){
                                    include 'delete_brand.php';
                                }
                                
                                elseif(isset($_GET['view_customers'])){
                                    include 'view_customers.php';
                                }elseif(isset($_GET['deleteCustomer'])){
                                    include 'delete_customer.php';
                                }
                                
                                elseif(isset($_GET['logout'])){
                                include 'logout.php';
                                }
                            ?>
                        </div>
                    </div>
                    <!-- End Of Content-Display -->
                    <!-- Start Aside -->
                    <div class="sidebar-sticky hidden col-md-2 col-sm-3 col-4 sidebar">
                        <!-- CATEGORYS FROM DATABASE -->
                        <h3 class="text-center">Manage Content</h3>
                        <ul class="nav flex-column">
                        
                            <li class="nav-item"><a href='?insert_product' class="nav-link">
                                <i class="fas fa-cart-arrow-down style-icon"></i> Insert New Product</a>
                            </li>
                            <li class="nav-item"><a href='?view_products' class="nav-link">
                                <i class="fas fa-cart-arrow-down style-icon"></i> View All Products</a>
                            </li>
                            <li class="nav-item"><a href='?insert_cat' class="nav-link">
                                <i class="fas fa-cart-arrow-down style-icon"></i> Insert New Category</a>
                            </li>
                            <li class="nav-item"><a href='?view_cats' class="nav-link">
                                <i class="fas fa-cart-arrow-down style-icon"></i> View All Categories</a>
                            </li>        
                            <li class="nav-item"><a href='?insert_brand' class="nav-link">
                                <i class="fas fa-cart-arrow-down style-icon"></i> Insert New Brand</a>
                            </li>
                            <li class="nav-item"><a href='?view_brands' class="nav-link">
                                <i class="fas fa-cart-arrow-down style-icon"></i> View All Brands</a>
                            </li>
                            <li class="nav-item"><a href='?view_customers' class="nav-link">
                                <i class="fas fa-cart-arrow-down style-icon"></i> View Customers</a>
                            </li>
                            <li class="nav-item"><a href='?delete_account' class="nav-link">
                                <i class="fas fa-cart-arrow-down style-icon"></i> View Orders</a>
                            </li>
                            <li class="nav-item"><a href='?delete_account' class="nav-link">
                                <i class="fas fa-cart-arrow-down style-icon"></i> View Payments</a>
                            </li>
                            <li class="nav-item"><a href='?logout' class="nav-link">
                                <i class="fas fa-cart-arrow-down style-icon"></i> Logout</a>
                            </li>

                        </ul>
                        
                    </div> 
                    <!--End Aside-->
                    
            </div> <!-- End First Row-->
        </div>    
        <!-- End Content-Wrapper Section -->

<?php
    include 'includes/footer.php';
    }
?>

