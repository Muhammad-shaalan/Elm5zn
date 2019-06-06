<?php
    
    if(isset($_GET['insert_brand'])){
        if(isset($_POST['new_brand'])){
            $formErrors=array();

            $brand_name = $_POST['brand_name'];
            if(strlen($brand_name) < 1){
                $formErrors[] = "You must write the <strong>name</strong> of Brand";
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
                    $stmt = $con->prepare("INSERT INTO brands(brand_title) 
                    VALUES(:ztitle) ");
                    $stmt->execute(array(
                        'ztitle' =>$brand_name
                    ));
                    $count = $stmt->rowCount();
                    $msg = "<div class='alert alert-success'>" . $count . " Brand Added</div>";
                    redirect($msg, 'back'); 
                }

            }

        }
    }

?>

<form action="" method="POST" enctype="multipart/form-data">
    <?php if(isset($msg)){
        echo $msg;
    } ?>
    <div class="form-group mt-3 col-md-4">
        <input type='text' name='brand_name' class="form-control">
        <input type='submit' name='new_brand' class='alert alert-success mt-2' value="Add New Brand">
    </div>
    
</form>
