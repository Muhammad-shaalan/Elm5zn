<?php
    if(!isset($_SESSION['admin_email'])){
        echo "<script>window.open('login.php?not_admin=You are not an admin!','_self')</script>";
    }else{
        if(isset($_GET['editBrand'])){
            
            //Update The Product
            if(isset($_POST['update-brand'])){
                $formErrors=array();
                
                $brand_name = $_POST['brand-name'];
                if(strlen($brand_name) < 1){
                    $formErrors[] = "You must write the <strong>name</strong> of brand";
                }
        
                foreach ($formErrors as $error) {
                    echo "<div class='alert alert-danger'>" . $error . "</div>";
                }
            
            
                //Insert Into Database
                if(empty($formErrors)){
                    $checkResult = checkCat("brand_title","brands",$brand_name);
                    if($checkResult == 1){
                        $msg = "<div class='alert alert-danger mt-3'> Sorry This Brand Name Is Exist </div>";
                        redirect($msg, 'back'); 
                    }else{
                        $stmt = $con->prepare("UPDATE brands SET brand_title=? WHERE brand_id=?");
                        $stmt->execute(array($brand_name, $_GET['editBrand']));
                        $count = $stmt->rowCount();
                        $msg = "<div class='alert alert-success'>" . $count . " Brand Updated</div>";
                        redirect($msg, 'back'); 
                    }
                }            
            }
            //Get The Chosen Category
            $get_brand = $con->prepare('SELECT * FROM ecommerce.brands WHERE brand_id = ?');
            $get_brand->execute(array($_GET['editBrand']));
            $row = $get_brand->fetch();
            $proBrand = $row['brand_title'];
        }
    
?>

    
        
        <!-- Start Content-Wrapper Section -->
        <div class="insert">
            <h2 class="text-center">Edit Brand</h2>
            <div class="row">
                <div class="col-md-8">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <input name="brand-name" type="text" class="form-control" placeholder="brand Name" value="<?php echo $proBrand; ?>">
                        </div>
                        <input type="submit" class="alert new-brand" name="update-brand" value="Update Brand">
                    </form>
                </div>
                
            </div>       
        </div>
        <!-- End Content-Wrapper Section -->

        
<?php } ?>