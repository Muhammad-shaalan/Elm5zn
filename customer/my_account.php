<?php 
    include 'includes/header.php';
    if(isset( $_SESSION['customer_email'])){
        
        $user_email = $_SESSION['customer_email'];
        $user = $con->prepare("SELECT * FROM customers WHERE customer_email = ?");
        $user->execute(array($user_email));
        $user = $user->fetch();
        $user_img       = $user['customer_image'];
        $user_name      = $user['customer_name'];
        $user_email     = $user['customer_email'];
        $user_id        = $user['customer_id'];
        $user_password  = $user['customer_password'];
        $user_country   = $user['customer_country'];
        $user_city      = $user['customer_city'];
        $user_address   = $user['customer_address'];
        $user_contact   = $user['customer_contact'];
        $user_id        = $user['customer_id'];
?>
        <div class="content">
                <div class='row'>
                    <div class="col-md-1"></div>
                    <!-- Start Content Display -->
                    <div class="col-md-8 mb-5">
                        <div class="content-display">
                            <?php
                            if(!isset($_GET['my_orders']) && !isset($_GET['edit_account']) && !isset($_GET['change_password']) && !isset($_GET['delete_account'])){
                                echo "<h3 class='text-center mt-5'>Hello " . $user_name ."</h3>";
                            }elseif(isset($_GET['edit_account'])){
                                include 'edit_account.php';
                            }elseif(isset($_GET['change_password'])){
                                include 'change_password.php';
                            }elseif(isset($_GET['delete_account'])){
                                include 'delete_account.php';
                            }
                            ?>
                        </div>
                    </div>
                    <!-- End Of Content-Display -->
                    <div class="col-md-1"></div>
                    <!-- Start Aside -->
                    <div class="sidebar-sticky hidden col-md-2 col-sm-3 col-4 sidebar">
                        <!-- CATEGORYS FROM DATABASE -->
                        <ul class="nav flex-column">
                            <div class='user-info'>
                                <span class="float-left user-info-char">
                                    <p><?php echo $user_name?></p>
                                    <p><?php echo $user_email?></p>
                                </span>
                                <span class="float-right">
                                    <img src='upload/<?php echo $user_img?>' class='user-img'>
                                </span>
                            </div>
                            
                            <li class="nav-item"><a href='?my_orders' class="nav-link">
                                <i class="fas fa-cart-arrow-down style-icon"></i> My Orders</a>
                            </li>
                            <li class="nav-item"><a href='?edit_account' class="nav-link">
                            <i class="fas fa-edit style-icon"></i>Edit Account</a>
                            </li>
                            <li class="nav-item"><a href='?change_password' class="nav-link">
                            <i class="fas fa-exchange-alt style-icon"></i>change password</a>
                            </li>
                            <li class="nav-item"><a href='?delete_account' class="nav-link">
                            <i class="fas fa-trash-alt style-icon"></i>Delete Account
                            </a></li>                            
                        </ul>
                        
                    </div> 
                    <!--End Aside-->
                    
            </div> <!-- End First Row-->
        </div>    
        <!-- End Content-Wrapper Section -->

<?php
    }else{
        echo "Yo Shoud Login";
    }
    include 'includes/footer.php';
?>

