<?php 
    if(isset($_GET['deletePro'])){
        
        $delete = $con->prepare("DELETE FROM products WHERE product_id=?"); 
        $delete->execute(array($_GET['deletePro'])); 
        
        $count = $delete->rowCount();

        if($count > 0){
            echo "<script>alert('A product has been deleted')</script>";
            echo "<script>window.open('index.php?view_products', '_self')</script>";
        }else{
            $msg = "Error, Your Product Did Not Delete";
        }
    }
?>