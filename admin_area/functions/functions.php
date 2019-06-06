<?php
	
	//Start a connection
	// $dsn      = 'mysql:host=sql300.epizy.com;dbname=epiz_23332633_ecommerce';
	// $user     = 'epiz_23332633';
	// $password = 'cKZW03fbjrZ';
	$dsn      = 'mysql:host=localhost;dbname=ecommerce';
	$user     = 'root';
	$password = '';
	// $option   = array(
	// 	PDO::MYSQL_ATTR_INIT__COMMAND => 'SET NAMES UTF8',
	// );

	try{
		$con = new PDO($dsn, $user, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo "Faild" . $e->getMessage();
	}

	//Get Visitors Ip Address

	function getIp() {
		$ip = $_SERVER['REMOTE_ADDR'];
	 
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
	 
		return $ip;
	}

	//Add To Cart

	function cart(){
		global $con;

		$ip = getIp();
		if(isset($_GET['add_cart'])){
			$pro_id = $_GET['add_cart'];

			$check_pro = $con->prepare("SELECT * FROM cart WHERE ip_add=? AND p_id=?");
			$check_pro->execute(array($ip, $pro_id));
			$rows = $check_pro->fetch();
			if($rows > 0){
			}else{
				$insert_pro = $con->prepare("INSERT INTO cart(p_id, ip_add) 
				VALUES(:zpro_id, :zip) ");
				$insert_pro->execute(array(
				'zip'     	=> $ip,
				'zpro_id'   => $pro_id
				));
				
			}
		}
	}

	//Get The Shopping Item

	function totalItem(){
		if(isset($_GET['add_cart'])){
			global $con;
			$ip = getIp();
			
			$check_pro = $con->prepare("SELECT * FROM cart WHERE ip_add=?");
			$check_pro->execute(array($ip));
			$rows = $check_pro->fetchAll();
			$rowCount = $check_pro->rowCount(); 
			echo $rowCount;
			return $rows;
		}else{
			global $con;
			$ip = getIp();
			$check_pro = $con->prepare("SELECT * FROM cart WHERE ip_add=?");
			$check_pro->execute(array($ip));
			$rows = $check_pro->fetchAll();
			$rowCount = $check_pro->rowCount();
			echo $rowCount;
			return $rows; 
		}	
	}

	//Get The Shopping Item Price

	function totalPrice(){
		$total = 0;
		global $con;
		$ip = getIp();
		$check_pro = $con->prepare("SELECT * FROM cart WHERE ip_add=?");
		$check_pro->execute(array($ip));
		$items = $check_pro->fetchAll();

		foreach($items as $item){
			$pro_id = $item['p_id'];

			$getPrice = $con->prepare("SELECT * FROM products WHERE product_id=?");
			$getPrice->execute(array($pro_id));
			$pro_rows = $getPrice->fetchAll();
			foreach($pro_rows as $product){
				$pro_price = array($product['product_price']);
				$values = array_sum($pro_price);
				$total +=$values;
			}
		}
		echo $total;
	}

	//Get Categories

	function get_cat(){
		global $con;

		$get_cat = $con->prepare('SELECT * FROM ecommerce.categories');
		$get_cat->execute();
		$rows = $get_cat->fetchAll();
		return $rows;
	}

	function get($name, $condition = NULL){
		global $con;

		$get = $con->prepare("SELECT * FROM $name $condition");
		$get->execute();
		$rows = $get->fetchAll();
		return $rows;
	}

	function checkCat($select, $from, $value){
		global $con;
		$statement = $con->prepare("SELECT $select From $from WHERE $select = ?");
		$statement->execute(array($value));
		$count = $statement->rowCount();
		return $count;
	}

	/*Function To Redirect Page*/
	function redirect($Msg, $url = null, $second = 2){
		if($url === null){
			$url = 'index.php';
			$link = "Home Page";
		}else{

			if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !==''){
				$url = $_SERVER['HTTP_REFERER'];
				$link = "Previous Page";	
			}else{
				$url = 'index.php';
				$link = "Home Page";
			}
			
		}
		echo $Msg;
		echo "<div class='alert alert-success'>You Will Redirect To $link After $second Second</div>";
		header("refresh:$second;url=$url");
		exit();
	}
