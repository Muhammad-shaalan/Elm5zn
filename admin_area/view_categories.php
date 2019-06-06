<?php
    global $con;
    $all_cats = $con->prepare("SELECT * FROM categories");
    $all_cats->execute();
    $rows = $all_cats->fetchAll();
?>
<h1 class="text-center">Manage Category</h1>
<div class="table-responsive">
    <table class="main-table table table-bordered text-center scroll">
        <tr>
            <td>#Category Id</td>
            <td>Category Title</td>
            <td>Control</td>
        </tr>
            <?php 
                foreach ($rows as $row) {
                    echo "<tr>";
                        echo "<td>" . $row['cat_id'] . "</td>";
                        echo "<td>" . $row['cat_title'] . "</td>";
                        echo "<td>
                                <a href='?editCat=" . $row['cat_id'] ." ' class='btn btn-success d-none d-sm-block mb-2'><i class='fa fa-edit'></i> Edit</a>
                                <a href='?editCat=" . $row['cat_id'] ." ' class='btn btn-success d-block d-sm-none mb-2'><i class='fa fa-edit'></i></a>
                                <a href='?deleteCat=" . $row['cat_id'] . " ' class='btn btn-danger d-none d-sm-block'><i class='fas fa-times'></i> Delete</a>
                                <a href='?deleteCat=" . $row['cat_id'] . " ' class='btn btn-danger d-none d-block d-sm-none'><i class='fas fa-times'></i></a>";
                                
                        echo "</td>";
                        
                    echo "</tr>";
                };
                ?>
    </table>
</div>