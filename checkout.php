<?php 
    session_start();
    include 'includes/header.php';
    
?>

                <!-- Start Content -->
                <div class="col-md-10 mb-5">
                    <?php
                        if(!isset($_SESSION['customer_email'])){
                            include 'customer_login.php';
                        }else{
                            include 'payment.php';
                        }
                    ?>
                </div>
                <!-- End Of Content-Display -->
            </div> <!-- End First Row-->
        </div>    
        <!-- End Content-Wrapper Section -->

<?php
    include 'includes/footer.php';
?>

