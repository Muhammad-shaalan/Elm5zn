<?php
    global $con;
    $all_pro = $con->prepare("SELECT * FROM customers");
    $all_pro->execute();
    $rows = $all_pro->fetchAll();
?>
<h1 class="text-center">Manage Customers</h1>
<div class="table-responsive">
    <table class="main-table table table-bordered text-center scroll">
        <tr>
            <td>#ID</td>
            <td>Name</td>
            <td>Email</td>
            <td>Image</td>
            <td>Control</td>
        </tr>
            <?php 
                foreach ($rows as $row) {
                    echo "<tr>";
                        echo "<td>" . $row['customer_id'] . "</td>";
                        echo "<td>" . $row['customer_name'] . "</td>";
                        echo "<td>" . $row['customer_email'] . "</td>";
                        echo "<td><img class='pro-img' src='../customer/upload/" . $row['customer_image'] . "'></td>";
                        echo "<td class='del'>
                                <a href='?deleteCustomer=" . $row['customer_id'] . " ' class='btn btn-danger d-none d-sm-block'><i class='fas fa-times'></i> Delete</a>
                                <a href='?deleteCustomer=" . $row['customer_id'] . " ' class='btn btn-danger d-none d-block d-sm-none'><i class='fas fa-times'></i></a>";
                        echo "</td>";
                        
                    echo "</tr>";
                };
                ?>
    </table>
</div>
