<?php
    if(isset($_GET['deleteCustomer'])){
        
        $delete = $con->prepare("DELETE FROM customers WHERE customer_id=?"); 
        $delete->execute(array($_GET['deleteCustomer'])); 
        
        $count = $delete->rowCount();

        if($count > 0){
            $msg = "<div class='alert alert-success'>". $count . " customer has been deleted</div>";
            redirect($msg, 'back');
            
        }else{
            $msg = "Error, Customer Did Not Delete";
        }
    }

?>