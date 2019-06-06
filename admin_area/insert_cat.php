<?php
if(isset($_GET['insert_cat'])){
    if(isset($_POST['new_cat'])){
        $formErrors=array();

        $cat_name = $_POST['cat_name'];
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
                $stmt = $con->prepare("INSERT INTO categories(cat_title) 
                VALUES(:ztitle) ");
                $stmt->execute(array(
                    'ztitle' =>$cat_name
                ));
                $count = $stmt->rowCount();
                $msg = "<div class='alert alert-success'>" . $count . " Category Added</div>";
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
        <input type='text' name='cat_name' class="form-control">
        <input type='submit' name='new_cat' class='alert alert-success mt-2' value="Add category">
    </div>
    
</form>
