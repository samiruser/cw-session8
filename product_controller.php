<?php

$connection = new mysqli('localhost', 'root', 'root', 'codeweekend');
if($connection->connect_error){
	die('no DB connection');
}
// var_dump($connection);

if(isset($_POST['insert_product'])){

	
	$name = $_POST['name'];
	$price = $_POST['price'];
	$expiry_date = $_POST['expiry_date'];
	
	$image_file = $_FILES['image'];
	$tmp_name = $image_file['tmp_name'];
	$image_name = $image_file['name'];

	move_uploaded_file($tmp_name, 'storage/products/'. $image_name);

	$query = " INSERT INTO products (name, price, expiry_date, image) VALUES ('$name', $price, ";

	if($expiry_date){
		$query .=  " '$expiry_date' ";
	}else {
		$query .= " NULL ";
	}

	$query .= ", '$image_name')";

	// echo $query;
	$connection->query($query);

	// var_dump($connection);

	header('location: home.php');
}

else if(isset($_POST['update_product'])) {

	$id = $_POST['id'];

	$name = $_POST['name'];
	$price = $_POST['price'];
	$expiry_date = $_POST['expiry_date'];

	$image_query = "SELECT image FROM products WHERE id=$id";
	$result = $connection->query($image_query);
	$product_data = $result->fetch_assoc();

	$image_name = $product_data['image'];
	
	if(isset($_FILES['image'])){

		unlink('storage/products/'. $image_name);

		$image_file = $_FILES['image'];
		$tmp_name = $image_file['tmp_name'];

		$image_name = $image_file['name'];
		move_uploaded_file($tmp_name, 'storage/products/'. $image_name);
	}

	$query = " UPDATE products SET name='$name', price=$price, expiry_date='$expiry_date', image='$image_name' WHERE id=$id ";
	
	// echo $query;
	$connection->query($query);

	header('location: home.php');
}

else if(isset($_GET['delete_id'])){

	$id = $_GET['delete_id'];

	$image_query = "SELECT image FROM products WHERE id=$id";
	$result = $connection->query($image_query);
	$product_data = $result->fetch_assoc();

	unlink('storage/products/'. $product_data['image']);

	$query = " DELETE FROM products WHERE id=$id ";

	$connection->query($query);

	// if($connection->connect)

	if($connection->error){
		echo $connection->error;
	}else{
		header('location: home.php');
	}

}