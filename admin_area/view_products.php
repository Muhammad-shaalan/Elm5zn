<?php
    global $con;
    $all_pro = $con->prepare("SELECT * FROM products");
    $all_pro->execute();
    $rows = $all_pro->fetchAll();
?>
<h1 class="text-center">Manage Product</h1>
<div class="table-responsive">
    <table class="main-table table table-bordered text-center scroll">
        <tr>
            <td>#S.N</td>
            <td>Title</td>
            <td>Image</td>
            <td>Price</td>
            <td>Control</td>
        </tr>
            <?php 
                foreach ($rows as $row) {
                    echo "<tr>";
                        echo "<td>" . $row['product_id'] . "</td>";
                        echo "<td>" . $row['product_title'] . "</td>";
                        echo "<td><img class='pro-img' src='upload/" . $row['product_image'] . "'></td>";
                        echo "<td> $" . $row['product_price'] . "</td>";
                        echo "<td>
                                <a href='?editPro=" . $row['product_id'] ." ' class='btn btn-success d-none d-sm-block mb-2'><i class='fa fa-edit'></i> Edit</a>
                                <a href='?editPro=" . $row['product_id'] ." ' class='btn btn-success d-block d-sm-none mb-2'><i class='fa fa-edit'></i></a>
                                <a href='?deletePro=" . $row['product_id'] . " ' class='btn btn-danger d-none d-sm-block'><i class='fas fa-times'></i> Delete</a>
                                <a href='?deletePro=" . $row['product_id'] . " ' class='btn btn-danger d-none d-block d-sm-none'><i class='fas fa-times'></i></a>";
                                
                        echo "</td>";
                        
                    echo "</tr>";
                };
                ?>
    </table>
</div>
