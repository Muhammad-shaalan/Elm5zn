<?php 
    $user_email = $_SESSION['customer_email'];
    $user = $con->prepare("SELECT * FROM customers WHERE customer_email = ?");
    $user->execute(array($user_email));
    $user = $user->fetch();
    $user_password  = $user['customer_password'];
   
    $ip = getIp();
    if(isset($_POST['chg_pass'])){
        if(isset($_POST['current_password'])){
            $current_password 	= sha1($_POST['current_password']);
            $new_pass           = sha1($_POST['new_password']);
            $confirm_pass       = sha1($_POST['confirm_password']);
        
            if(strlen($current_password) < 6){
                $formErrors[] = "Your Password Must Be More Than 5 Char";
            }

            if($current_password !== $user_password){
                $formErrors[] = "You Inserted Incorrect Password";
            }else{
                if($new_pass !== $confirm_pass){
                    $formErrors[] = "Two Password Is Not Matched";
                }
            }
        
            //Insert Into Database
            if(empty($formErrors)){
            
                $chg_password = $con->prepare("UPDATE customers SET customer_password=?"); 
                $chg_password->execute(array($new_pass)); 
                
                $count = $chg_password->rowCount();

                if($count > 0){
                    $msg = "Updated Successfully";
                }else{
                    $msg = "Customer Password Is Not Update";
                }
            }   //If Is There Post To Current Password
        }else{
            $msg = "Errors";
        }
    }
        
        
?>

                <!-- Start Register -->
                    <form  action="" method="POST" enctype="multipart/form-data">
                        <h2 class="text-center mt-3 mb-5">Edit Your Information</h2>
                        <!-- Successful Saving -->
                        <?php
                        if(isset($msg)){
                            echo "<div class='alert alert-success'>" . $msg ."</div>";
                        }
                        ?>
                        <!-- ERROR HANDEL -->
                        <?php if(! empty($formErrors)) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <?php 
                                        foreach($formErrors as $error){
                                            echo $error . "<br>";
                                        }
                                ?>
                            </div>
                        <?php }?>
                            
                        <div class="form-group row">
                            <label for="current_password" class="col-sm-2 col-form-label">Current Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="current_password" class="form-control" id="current_password" placeholder="Please Enter Your Current Password">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="new_password" class="col-sm-2 col-form-label">New Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="new_password" class="form-control" id="new_password" placeholder="Please Enter Your New Password">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="confirm_password" class="col-sm-2 col-form-label">Confirm New Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Please Confirm Your Password">
                            </div>
                        </div>
                        <br>
                        <input type="submit" class="btn btn-primary d-block mx-auto mb-5 mt-2" name="chg_pass" value="Change Password">
                    </form>
                <!-- End Register -->

           
