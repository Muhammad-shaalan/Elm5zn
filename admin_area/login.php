<?php 
    session_start();
    include("functions/functions.php");
    if(isset($_POST['login'])){
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if(filter_var($email, FILTER_VALIDATE_EMAIL) != true){
            $formErrors[] = "This Email Is Not <strong>Valid</strong>";
        }
    
        $password = $_POST['password'];
        $hashpass = sha1($password);
        $check_user = $con->prepare("SELECT * FROM admins WHERE user_email = ? AND password = ?");
        $check_user->execute(array($email,$password));
        $row = $check_user->fetch();
        $count = $check_user->rowCount();

        if($count == 0){
            $msgError = "<div class='col-sm-3 mx-auto alert alert-danger'>The email or password are wrong</div>";
        }elseif($count > 0){
            $_SESSION['admin_email'] = $email;
            $_SESSION['user_name'] = $row['user_email'];
            echo "<script>window.open('index.php?logged=Sucess', '_self')</script>";
        }
    }

?>
<!Doctype html>
<html>
    <head>
        <title>Online Shop</title>
        <link rel="stylesheet" href="styles/bootstrap.min.css">
        <link rel="stylesheet" href="styles/all.css">
        <link rel="stylesheet" href="styles/jquery-ui.min.css">
        <link rel="stylesheet" href="styles/jquery.selectBoxIts.css">
        <link rel="stylesheet" href="styles/styless.css">
    </head>
    <body>
        <div>
            <form  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" class="text-center">
                <h2 class="text-center mt-3 mb-5">Login / Register to buy</h2>
                <div class="form-group row form_row">
                    <div class="col-sm-3 mx-auto">
                        <input type="email" name="email" class="form-control" id="staticEmail"placeholder="Email">
                    </div>
                </div>
                <br>
                <div class="form-group row form_row">
                    <div class="col-sm-3 mx-auto mb-3">
                        <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
                    </div>
                </div>
                <!-- If There Is Error -->
                <?php if(isset($msgError)){echo $msgError;} ?>

                <!-- If It Is Unauthorized Access -->
                <?php if(isset($_GET['not_admin'])){
                    echo "<div class='col-sm-3 mx-auto alert alert-danger'>" . $_GET['not_admin'] . "</div>";
                } ?>
                <a href="#" class="text-center text-danger">Forgot Password ?</a>
                <input type="submit" class="btn btn-primary d-block mx-auto mt-3 mb-3" name='login' value="Login">
                <a href="#"><b>New?</b> Register Here</a>
            </form>
        </div>
    </body>
</html>