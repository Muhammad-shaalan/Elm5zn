<?php
    if(!isset($_SESSION['admin_email'])){
        echo "<script>window.open('login.php?not_admin=You are not an admin!','_self')</script>";
    }else{
        if(isset($_GET['editPro'])){
            
            //Update The Product
            if(isset($_POST['update-product'])){
                
                $p_name     = $_POST['product-name'];
                $p_category = $_POST['product-category'];
                $p_brand    = $_POST['product-brand'];
                $p_price    = $_POST['product-price'];
                $p_desc     = $_POST['product-desc'];
                $p_keyword  = $_POST['product-keyword'];
            
                $imageName = $_FILES['image']['name'];
                $imageType = $_FILES['image']['type'];
                $imageSize = $_FILES['image']['size'];
                $imageTmp  = $_FILES['image']['tmp_name'];
            
                $imageExtensionAllowed = array("jpeg", "jpg", "png", "gif");
            
                $imageExtension = strtolower(end(explode(".", $imageName)));
            
                $formErrors=array();
            
                if(strlen($p_name) < 1){
                    $formErrors[] = "You must write the <strong>name</strong> of product";
                }
                if($p_category == 0){
                    $formErrors[] = "You must choose <strong>category</strong> for the product";
                }
                if($p_brand == 0){
                    $formErrors[] = "You must choose <strong>brand</strong> for the product";
                }
                if(strlen($p_price) < 1){
                    $formErrors[] = "You must mention the <strong>price</strong> of product";
                }
            
                if(empty($imageName)){
                    $formErrors[]=" You must Choose <strong>Image</strong>";
                }
            
                if(! empty($imageName) && ! in_array($imageExtension, $imageExtensionAllowed)){
                    $formErrors[]=" This Extension Is <strong>Blocked</strong>";
                }
            
                if($imageSize > 4194304){
                    $formErrors[]=" You Picture Must be Less Than <strong>4 Mega</strong>";
                }
            
            
                foreach ($formErrors as $error) {
                    echo "<div class='alert alert-danger'>" . $error . "</div>";
                }
            
            
                //Insert Into Database
                if(empty($formErrors)){
                    $image = rand(0, 10000000000) . '_' . $imageName;
                    move_uploaded_file($imageTmp, "upload\\" . $image);
            
                    $stmt = $con->prepare("UPDATE products SET product_title=?, product_cat=?, product_brand=?,
                                                    product_desc=?, product_image=?, product_price=?, keywords=?
                                                    WHERE product_id=?");
                    $stmt->execute(array(
                        $p_name,$p_category,$p_brand,$p_desc,$image,$p_price,$p_keyword,$_GET['editPro']
                    ));
                    $msg = "<div class='alert alert-success'>Congratz Product Are Updated</div>";
                    redirect($msg, 'back');
                }else{
                    echo "Error";
                }
            }

            //Get The Input Value To It Field
            $proId = $_GET['editPro'];
            global $con;
            $getPro = $con->prepare("SELECT * FROM products WHERE product_id = ?");
            $getPro->execute(array($proId));
            $pro= $getPro->fetch();

            $pro_title      = $pro['product_title'];
            $pro_cat        = $pro['product_cat'];
            $pro_brand      = $pro['product_brand'];
            $pro_img        = $pro['product_image'];
            $pro_price      = $pro['product_price'];
            $pro_desc       = $pro['product_desc'];
            $pro_key        = $pro['keywords'];

            //Get The Chosen Category
            $get_cat = $con->prepare('SELECT * FROM ecommerce.categories WHERE cat_id = ?');
            $get_cat->execute(array($pro_cat));
            $row = $get_cat->fetch();
            $proCat = $row['cat_title'];

            //Get The Chosen Brand
            $get_brand = $con->prepare('SELECT * FROM ecommerce.brands WHERE brand_id = ?');
            $get_brand->execute(array($pro_brand));
            $row = $get_brand->fetch();
            $proBrand = $row['brand_title'];
        }

?>

    
        
        <!-- Start Content-Wrapper Section -->
        <div class="insert">
            <h2 class="text-center">EditProduct</h2>
            <div class="row">
                <div class="col-md-8">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <input name="product-name" data-class=".live-name" type="text" class="form-control live" placeholder="Product Name" value="<?php echo $pro_title; ?>">
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-sm-4 col-form-label-lg">Category</label>
                            <div class="col-md-10 col-sm-8">
                                <select name="product-category" data-class=".live-category" type="text" class="form-control live" name="itemStatus">
                                    <option value="<?php echo $pro_cat; ?> "><?php echo $proCat; ?></option>
                                    <?php
                                        $cats = get('categories');
                                        foreach($cats as $cat){
                                            $catId = $cat['cat_id'];
                                            $catTitle = $cat['cat_title'];
                                            if($catTitle != $proCat){?>
                                                <option value="<?php echo $catId ?>"><?php echo $catTitle ?></option>
                                      <?php }
                                            
                                   }
                                    ?>
                                    
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-sm-4 col-form-label-lg">Brand</label>
                            <div class="col-md-10 col-sm-8">
                                <select name="product-brand" data-class=".live-brand" type="text" class="form-control live" name="itemStatus">
                                <option value="<?php echo $pro_brand; ?> "><?php echo $proBrand; ?></option>
                                <?php
                                    $brands = get('brands');
                                    foreach($brands as $brand){
                                        $brandId = $brand['brand_id'];
                                        $brandTitle = $brand['brand_title'];
                                        if($brandTitle != $proBrand){?>
                                            <option value="<?php echo $brandId ?>"><?php echo $brandTitle ?></option>
                                  <?php }
                                        
                               }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-sm-4 col-form-label-lg">Image</label>
                            <div class="form-group col-md-10">
                                <input name="image" type="file" class="form-control live">
                            </div>
                        </div> 
                        <div class="form-group">
                            <input name="product-price" data-class=".live-price" type="number" class="form-control live" placeholder="Product Price" value="<?php echo $pro_price; ?>">
                        </div>
                        <div class="form-group">
                            <textarea name="product-desc" rows="3" data-class=".live-desc" type="text" class="form-control live" placeholder="Product Description"><?php echo $pro_desc; ?></textarea>
                        </div>
                        <div class="form-group">
                            <input name="product-keyword" type="text" class="form-control" placeholder="KeyWords" value="<?php echo $pro_key; ?>">
                        </div>
                        <input type="submit" class="alert new-product" name="update-product" value="Update Product">
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="card item-box" style="width: 16rem;">
                        <span class="price-tag">$<span class="live-price">0</span></span>
                        <img class="card-img-top" src="images/default.jpg" alt="Card image cap">
                        <!-- <i class="card-img-top fab fa-asymmetrik logo mt-1"></i> -->
                        <div class="card-body">
                            <h5 class="card-title live-name">Title</h5>
                            <p class="card-text live-desc">Description</p>
                            <span class="live-brand float-left br-ca">Brand</span>
                            <span class="live-category float-right br-ca">Category</span>
                        </div>
                    </div>
                </div>
            </div>       
        </div>
        <!-- End Content-Wrapper Section -->
    <?php } ?>
        
