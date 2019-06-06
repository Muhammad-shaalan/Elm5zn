<?php 
    if(!isset($_SESSION['admin_email'])){
        echo "<script>window.open('login.php?not_admin=You are not an admin!','_self')</script>";
    }else{
        if(isset($_GET['editCat'])){
            
            //Update The Product
            if(isset($_POST['update-cat'])){
                $formErrors=array();
                
                $cat_name = $_POST['cat-name'];
                if(strlen($cat_name) < 1){
                    $formErrors[] = "You must write the <strong>name</strong> of category";
                }
        
                foreach ($formErrors as $error) {
                    echo "<div class='alert alert-danger'>" . $error . "</div>";
                }
            
            
                //Insert Into Database
                if(empty($formErrors)){
                    $checkResult = checkCat("cat_title","categories",$cat_name);
                    if($checkResult == 1){
                        $msg = "<div class='alert alert-danger mt-3'> Sorry This Category Name Is Exist </div>";
                        redirect($msg, 'back'); 
                    }else{
                        $stmt = $con->prepare("UPDATE categories SET cat_title=? WHERE cat_id=?");
                        $stmt->execute(array($cat_name, $_GET['editCat']));
                        $count = $stmt->rowCount();
                        $msg = "<div class='alert alert-success'>" . $count . " Category Updated</div>";
                        redirect($msg, 'back'); 
                    }
                }            
            }
            //Get The Chosen Category
            $get_cat = $con->prepare('SELECT * FROM ecommerce.categories WHERE cat_id = ?');
            $get_cat->execute(array($_GET['editCat']));
            $row = $get_cat->fetch();
            $proCat = $row['cat_title'];
        }
?>

    
        
        <!-- Start Content-Wrapper Section -->
        <div class="insert">
            <h2 class="text-center">Edit Category</h2>
            <div class="row">
                <div class="col-md-8">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <input name="cat-name" type="text" class="form-control" placeholder="Category Name" value="<?php echo $proCat; ?>">
                        </div>
                        <input type="submit" class="alert new-product" name="update-cat" value="Update Category">
                    </form>
                </div>
                
            </div>       
        </div>
        <!-- End Content-Wrapper Section -->
    <?php } ?>
        
