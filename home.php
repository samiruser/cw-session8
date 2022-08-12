<?php
session_start();
if(!isset($_SESSION['authenticated'])){
	header('location: login.php');
}

$auth = $_SESSION['auth'];

$connection = new mysqli('localhost', 'root', 'root', 'codeweekend');

$query = " SELECT * FROM products ";
$result = $connection->query($query);
$products = $result->fetch_all(MYSQLI_ASSOC);




// var_dump($data);
// exit;

// we have a table  of products
// list all of the products from DB
// edit products /update
// deleting products
// file uploading

// fields : ID, name, price, expiry_date, image

// YYYY-MM-DD
?>

<style>

	td img {
		width: 100px;
	}

</style>

<p>
	Welcome, <strong><?php echo $auth['name'] ?></strong>
</p>

<p>
	<a href="login_controller.php?logout=true">Logout</a>
</p>

<table border="1">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Price</th>
			<th>Expiry Date</th>
			<th>Image</th>
			<th>Action</th>
		</tr>
	</thead>

	<tbody>
		<?php
			$i = 1;
			foreach($products as $product) {
				echo 	"<tr>
							<td>". $i++ ."</td>
							<td>". $product['name'] ."</td>
							<td>". $product['price'] ."</td>
							<td>". ( $product['expiry_date'] ? $product['expiry_date'] : '<i>no date</i>' ) ."</td>
							<td>
								<img src='storage/products/{$product['image']}' />
							</td>
							<td>
								<a href='home.php?edit_id={$product['id']}'>Edit</a> 

								<a href='product_controller.php?delete_id={$product['id']}'>Delete</a> 
							</td>
						</tr>";
			}
		?>
	</tbody>

</table>

<br>
<br>
<br>

<?php
	$edit_product = null;

	if(isset($_GET['edit_id'])){
		$id = $_GET['edit_id'];

		$product_query = " SELECT * FROM products WHERE id=${id} ";

		$product_result = $connection->query($product_query);

		$edit_product = $product_result->fetch_assoc();
		
	}

?>

<form action="product_controller.php" method="post" enctype="multipart/form-data">

	<input type="hidden" name="id" value="<?php echo ($edit_product) ? $edit_product['id'] : '' ?>">

	<table>
		<tr>
			<td>Name</td>
			<td>
				<input type="text" name="name" value="<?php echo ($edit_product) ? $edit_product['name'] : ''; ?>" >
			</td>
		</tr>

		<tr>
			<td>Price</td>
			<td>
				<input type="number" name="price" value="<?php echo ($edit_product) ? $edit_product['price'] : '' ?>" >
			</td>
		</tr>

		<tr>
			<td>Expiry Date</td>
			<td>
				<input type="date" name="expiry_date" value="<?php echo ($edit_product) ? $edit_product['expiry_date'] : '' ?>" >
			</td>
		</tr>

		<tr>
			<td>Image</td>
			<td>
				<input type="file" name="image" >
				<?php if($edit_product) { ?>
					<img src="storage/products/<?php echo $edit_product['image'] ?>" alt="">

				<?php } ?>
			</td>
		</tr>

		<tr>
			<td>
				<button type="submit" name="<?php echo ($edit_product) ? 'update_product' : 'insert_product' ?>">Save</button>

				<a href="home.php">Cancel</a>
			</td>
		</tr>
	</table>

</form>


