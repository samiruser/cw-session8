<?php
session_start();
if(isset($_SESSION['authenticated'])){
	header('location: home.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	
	<form method="post" action="login_controller.php">

		<label for="">Email</label>
		<input type="email" name="email" required >
		<br>
		<br>

		<label for="">Password</label>
		<input type="password" name="password" required >

		<br>
		<br>

		<button type="submit" name="login">Login</button>

	</form>

</body>
</html>