<?php 
    if(isset($_GET['deleteCat'])){
        
        $delete = $con->prepare("DELETE FROM categories WHERE cat_id=?"); 
        $delete->execute(array($_GET['deleteCat'])); 
        
        $count = $delete->rowCount();

        if($count > 0){
            $msg = "<div class='alert alert-danger'>" . $count . " category is deleted</div>";
            redirect($msg, 'back');
        }else{
            $msg = "Error, Your Category Did Not Delete";
        }
    }

?>