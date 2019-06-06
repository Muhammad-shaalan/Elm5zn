<?php 
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
    $ip = getIp();
    if(isset($_POST['register'])){
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        if(strlen($username) < 4){
            $formErrors[] = "Your Username Must Be More Than <strong>4 Char</strong>";   
        }
        
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if(filter_var($email, FILTER_VALIDATE_EMAIL) != true){
            $formErrors[] = "This Email Is Not <strong>Valid</strong>";
        }
        if(strlen($email)<1){
            $formErrors[] = "Your Email Can`t Be <strong>Empty</strong>";
        }
        

        $password 	= sha1($_POST['password']);
        if(strlen($password) < 6){
            $formErrors[] = "Your Password Must Be More Than 5 Char";
        }

        if($password !== $user_password){
            $formErrors[] = "You Inserted Incorrect Password";
        }
        
        
        /*USER IMAGE*/
        $imageName = $_FILES['image']['name'];
        $imageType = $_FILES['image']['type'];
        $imageSize = $_FILES['image']['size'];
        $imageTmp  = $_FILES['image']['tmp_name'];
    
        $imageExtensionAllowed = array("jpeg", "jpg", "png", "gif");
    
        $imageExtension = strtolower(end(explode(".", $imageName)));
            
        if(empty($imageName)){
            $formErrors[]=" You must Choose <strong>Image</strong>";
        }
    
        if(! empty($imageName) && ! in_array($imageExtension, $imageExtensionAllowed)){
            $formErrors[]=" This Extension Is <strong>Blocked</strong>";
        }
    
        if($imageSize > 4194304){
            $formErrors[]=" You Picture Must be Less Than <strong>4 Mega</strong>";
        }
    
        $country = $_POST['country'];
        if($country == 0){
            $formErrors[]=" You Must Choose <strong>Your Country</strong>";
        }
        

        $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
        if(strlen($city) < 2){
            $formErrors[] = "Your City Must Be More Than <strong>1 Char</strong>";   
        }

        $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
        if(strlen($address) < 3){
            $formErrors[] = "Your Address Must Be More Than <strong>3 Char</strong>";   
        }

        $contact = filter_var($_POST['contact'], FILTER_SANITIZE_STRING);
        if(strlen($contact) < 2){
            $formErrors[] = "Your Contact Must Be More Than <strong>1 Char</strong>";   
        }
    
        
        //Insert Into Database
        if(empty($formErrors)){
            $image = rand(0, 10000000000) . '_' . $imageName;
            move_uploaded_file($imageTmp, "upload\\" . $image);

            $stmt = $con->prepare("UPDATE customers SET customer_ip=?, customer_name=?, customer_email=?,
            customer_image=?, customer_country=?, customer_city=?, customer_address=?, customer_contact=? WHERE customer_id=? AND customer_password=?"); 
            $stmt->execute(array($ip,$username,$email,$image,$country,$city,$address,$contact,$user_id,$password)); 
            
            $msg = "Updated Successfully";
        }else{
            $msg = "Errors";
        }

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
                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-8">
                                <input type="text" name="username" class="form-control" id="username" placeholder="Username" value="<?php echo $user_name?>">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" name="email" class="form-control" id="email" value="<?php echo $user_email?>" disabled>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="image" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-8">
                                <input name="image" type="file" class="form-control" id="image">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="country" class="col-sm-2 col-form-label">Country</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="country">
                                    <option value="0">. . .</option>
                                    <option value="1">Cairo</option>
                                    <option value="2">Mansoura</option>
                                    <option value="3">Loxur</option>
                                    <option value="4">Kafr Elsheikh</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="city" class="col-sm-2 col-form-label">City</label>
                            <div class="col-sm-8">
                                <input type="text" name="city" class="form-control" id="city" placeholder="City" value="<?php echo $user_city?>">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="contact" class="col-sm-2 col-form-label">Contact</label>
                            <div class="col-sm-8">
                                <input type="text" name="contact" class="form-control" id="contact" placeholder="Contact" value="<?php echo $user_contact?>">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="address" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-8">
                                <input type="text" name="address" class="form-control" id="address" placeholder="Address" value="<?php echo $user_address?>">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Please Insert Your Password To Confirm About New Info">
                            </div>
                        </div>
                        <br>
                        <input type="submit" class="btn btn-primary d-block mx-auto mb-5 mt-2" name="register" value="Create Account">
                    </form>
                <!-- End Register -->

           
