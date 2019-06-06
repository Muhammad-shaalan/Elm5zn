<?php 
    session_start();
    include 'includes/header.php';

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
        $password2 	= sha1($_POST['password2']);
        if(strlen($password) < 6 || strlen($password2) < 6){
            $formErrors[] = "Your Password Must Be More Than 5 Char";
        }
        if($password !== $password2){
            $formErrors[] = "Password Is Not Matched";
        }
        
        
        /*USER IMAGE*/
        $imageName = $_FILES['image']['name'];
        $imageType = $_FILES['image']['type'];
        $imageSize = $_FILES['image']['size'];
        $imageTmp  = $_FILES['image']['tmp_name'];
    
        $imageExtensionAllowed = array("jpeg", "jpg", "png", "gif");
    
        // $imageExtension = strtolower(end(explode(".", $imageName)));
            
        if(empty($imageName)){
            $formErrors[]=" You must Choose <strong>Image</strong>";
        }
    
        // if(! empty($imageName) && ! in_array($imageExtension, $imageExtensionAllowed)){
        //     $formErrors[]=" This Extension Is <strong>Blocked</strong>";
        // }
    
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
            $all_customers = $con->prepare("SELECT * FROM customers WHERE customer_email=?");
            $all_customers->execute(array($email));
            $rows = $all_customers->fetchAll();
            $count = $all_customers->rowCount();
            if($count>0){
                $msg = "Sorry This Email Is Existed";
            }else{
                $image = rand(0, 1000000000) . '_' . $imageName;
                move_uploaded_file($imageTmp, "customer/upload\\" . $image);

                $stmt = $con->prepare("INSERT INTO customers(customer_ip, customer_name, customer_email, customer_password,
                customer_image, customer_country, customer_city, customer_address, customer_contact) 
                VALUES(:zip, :zname, :zemail, :zpassword, :zimage, :zcountry, :zcity, :zaddress, :zcontact) ");
                $stmt->execute(array(
                'zip'       => $ip,
                'zname'     => $username,
                'zemail'    => $email,
                'zpassword' => $password,
                'zimage'    => $image,
                'zcountry'  => $country,
                'zcity'     => $city,
                'zaddress'  => $address,
                'zcontact'  => $contact
                ));

                // $check_cart = $con->prepare("SELECT * FROM cart WHERE ip_add = ?");
                // $check_cart->execute(array($ip));
                // $rows = $check_cart->fetchAll();
                // $count = $check_cart->rowCount();

                $check_customer = $con->prepare("SELECT * FROM customers WHERE customer_email = ?");
                $check_customer->execute(array($email));
                $row = $check_customer->fetch();
                
                // if($count == 0){
                    $_SESSION['customer_email'] = $email;
                    $_SESSION['customer_name'] = $username;
                    $_SESSION['customer_id'] = $row['customer_id'];
                    $msg = "Regiteration Successful";
                    echo "<script>window.open('customer/my_account.php','_self')</script>";
                // }else{
                    // $_SESSION['customer_email'] = $email;
                    // $_SESSION['customer_name'] = $row['customer_name'];
                    // $_SESSION['customer_id'] = $row['customer_id'];
                    // $msg = "Regiteration Successful";
                    // echo "<script>window.open('checkout.php','_self')</script>";
                // }
            }  
        }
        else{
            $msg = "Errors";
        }
    }
        
        
?>

                <!-- Start Register -->
                <div class="col-md-10">
                    <h5 class="mt-3">Welcome Guest!</h5>
                    <form  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                        <h2 class="text-center mt-3 mb-5">Login / Register to buy</h2>
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
                                <input type="text" name="username" class="form-control" id="username" placeholder="Username">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="password2" class="col-sm-2 col-form-label">Confirm Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="password2" class="form-control" id="password2" placeholder="Password">
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
                                <input type="text" name="city" class="form-control" id="city" placeholder="City">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="contact" class="col-sm-2 col-form-label">Contact</label>
                            <div class="col-sm-8">
                                <input type="text" name="contact" class="form-control" id="contact" placeholder="Contact">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="address" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-8">
                                <input type="text" name="address" class="form-control" id="address" placeholder="Address">
                            </div>
                        </div>
                        <br>
                        <input type="submit" class="btn btn-primary d-block mx-auto mb-5 mt-2" name="register" value="Create Account">
                    </form>
                </div>
                <!-- End Register -->

            </div> <!-- End First Row-->
        </div>    
        <!-- End Content-Wrapper Section -->

<?php
    include 'includes/footer.php';
?>