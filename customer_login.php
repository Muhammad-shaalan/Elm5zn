<?php 

    if(isset($_POST['login'])){
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if(filter_var($email, FILTER_VALIDATE_EMAIL) != true){
            $formErrors[] = "This Email Is Not <strong>Valid</strong>";
        }
    
        $password = $_POST['password'];
        $hashpass = sha1($password);
        $check_customer = $con->prepare("SELECT * FROM customers WHERE customer_email = ? AND customer_password = ?");
        $check_customer->execute(array($email,$hashpass));
        $row = $check_customer->fetch();
        $count = $check_customer->rowCount();

        $ip = getIp();
        $check_cart = $con->prepare("SELECT * FROM cart WHERE ip_add = ?");
        $check_cart->execute(array($ip));
        $rows = $check_cart->fetchAll();
        $check_cart = $check_cart->rowCount();

        if($count == 0){
            $msgError = "<div class='alert alert-danger'>The email or password are wrong</div>";
        }
        if($count > 0 && $check_cart == 0){
            $_SESSION['customer_email'] = $email;
            $_SESSION['customer_name'] = $row['customer_name'];
            $_SESSION['customer_id'] = $row['customer_id'];
            echo "<script>window.open('customer/my_account.php', '_self')</script>";
		}elseif($count > 0 && $check_cart > 0){
            $_SESSION['customer_email'] = $email;
            $_SESSION['customer_name'] = $row['customer_name'];
            $_SESSION['customer_id'] = $row['customer_id'];
            echo "<script>window.open('checkout.php', '_self')</script>";
        }
    }

?>
<div>
    <!-- <h3>Welcom Guest! <strong>Shopping Cart</strong> Total Item: <?php totalItem(); ?></h3> -->
    <form  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <h2 class="text-center mt-3 mb-5">Login / Register to buy</h2>
        <?php if(isset($msgError)){echo $msgError;} ?>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-3">
                <input type="email" name="email" class="form-control" id="staticEmail"placeholder="Email">
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-3">
                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
        </div>
        <a href="checkout.php?forgot_pass" class="text-center d-block text-danger mt-3 mb-3">Forgot Password ?</a>
        <input type="submit" class="btn btn-primary d-block mx-auto" name='login' value="Login">
        <a href="customer_register.php" class=" d-block text-primary mt-3 mb-5"><b>New?</b> Register Here</a>
    </form>
</div>