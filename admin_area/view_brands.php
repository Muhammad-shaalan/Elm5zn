<?php
    global $con;
    $all_brands = $con->prepare("SELECT * FROM brands");
    $all_brands->execute();
    $rows = $all_brands->fetchAll();
?>
<h1 class="text-center">Manage Brand</h1>
<div class="table-responsive">
    <table class="main-table table table-bordered text-center scroll">
        <tr>
            <td>#Brand Id</td>
            <td>Brand Title</td>
            <td>Control</td>
        </tr>
            <?php 
                foreach ($rows as $row) {
                    echo "<tr>";
                        echo "<td>" . $row['brand_id'] . "</td>";
                        echo "<td>" . $row['brand_title'] . "</td>";
                        echo "<td>
                                <a href='?editBrand=" . $row['brand_id'] ." ' class='btn btn-success d-none d-sm-block mb-2'><i class='fa fa-edit'></i> Edit</a>
                                <a href='?editBrand=" . $row['brand_id'] ." ' class='btn btn-success d-block d-sm-none mb-2'><i class='fa fa-edit'></i></a>
                                <a href='?deleteBrand=" . $row['brand_id'] . " ' class='btn btn-danger d-none d-sm-block'><i class='fas fa-times'></i> Delete</a>
                                <a href='?deleteBrand=" . $row['brand_id'] . " ' class='btn btn-danger d-none d-block d-sm-none'><i class='fas fa-times'></i></a>";
                                
                        echo "</td>";
                        
                    echo "</tr>";
                };
                ?>
    </table>
</div>