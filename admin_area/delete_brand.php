<?php 

    if(isset($_GET['deleteBrand'])){
        
        $delete = $con->prepare("DELETE FROM brands WHERE brand_id=?"); 
        $delete->execute(array($_GET['deleteBrand'])); 
        
        $count = $delete->rowCount();

        if($count > 0){
            $msg = "<div class='alert alert-danger'>" . $count . " Brand is deleted</div>";
            redirect($msg, 'back');
        }else{
            $msg = "Error, Your Brand Did Not Delete";
        }
    }


?>