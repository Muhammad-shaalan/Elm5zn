<?php 
session_start(); 

include "functions/functions.php";
?>
<!Doctype html>
<html>
    <head>
        <title>Online Shop</title>
        <link rel="stylesheet" href="styles/bootstrap.min.css">
        <link rel="stylesheet" href="styles/all.css">
        <link rel="stylesheet" href="styles/jquery-ui.min.css">
        <link rel="stylesheet" href="styles/jquery.selectBoxIts.css">
        <link rel="stylesheet" href="styles/style.css">
    </head>
    <body>
        <!-- Header Section -->
        <div class="header">
            <div class="row header-row">
                <div class="col-md-8">
                    <div class="logo-search">
                        <!-- <img src='images/logo.png' alt="logo" class="logo"> -->
                        <i class="fab fa-asymmetrik logo mt-1"></i>
                        <div class="input-group search mt-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon1">Button</button>
                            </div>
                            <input type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-3">
                    <p class="mt-4">New To Elm5zn? Click Here To Learn More</p>
                </div>
            </div> <!-- End Row Div  -->

            <!-- Start Navbar -->
            <div class="row nav-row">
                <div class="col-md-1"></div>
                <div class="col-md-6">
                    <nav class="navbar navbar-expand-lg">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">My Account</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../cart.php">Shopping Cart</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>

                <div class="col-md-5">
                    <p class="p-cart float-right">Welcome <span class='name'> 
                        <?php if(isset($_SESSION['customer_name'])) {$arr = explode(' ',trim($_SESSION['customer_name'])); echo $arr[0];}
                                else{echo "Guest";}  ?> </span>                        
                        <?php
                        if(isset($_SESSION['customer_email'])){
                            echo "<a href='../logout.php' class='log'>Logout</a>";
                        }else{
                            echo "<a href='../checkout.php' class='log'>Login</a>";
                        }
                        ?>
                    </p>
                </div>
            </div> 
            <!-- End Navbar -->
        </div> 
        <!-- End Header Section    -->