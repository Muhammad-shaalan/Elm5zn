<?php 
    $user_email = $_SESSION['customer_email'];
   
    if(isset($_POST['yes'])){
            
        $delete = $con->prepare("DELETE FROM customers WHERE customer_email=?"); 
        $delete->execute(array($user_email)); 
        
        $count = $delete->rowCount();

        if($count > 0){
            $msg = "Account Deleted";
            echo "<script>window.open('../logout.php', '_self')</script>";
        }else{
            $msg = "Error, Your Account Did Not Delete";
        }
    }
        
    if(isset($_POST['no'])){
        $msg = "Does Not Joking Again";
        
    }
    
?>

                <!-- Start Register -->
                    <form  action="" method="POST" enctype="multipart/form-data">
                        <h2 class="text-center mt-3 mb-5">Delete Account</h2>
                        <!-- Successful Saving -->
                        <?php
                        if(isset($msg)){
                            echo "<div class='alert alert-success'>" . $msg ."</div>";
                        }
                        ?>

                            
                        <input type="submit" class="btn btn-danger d-block mx-auto mb-5 mt-2" name="yes" value="Yes, Delete Account">
                        <input type="submit" class="btn btn-primary d-block mx-auto mb-5 mt-2" name="no" value="No, Just Joking">
                    </form>
                <!-- End Register -->

