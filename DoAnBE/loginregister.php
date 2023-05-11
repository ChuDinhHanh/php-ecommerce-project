<?php
session_start();
require_once './config/database.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});
$accountModel = new AccountModel();
$id = 0;
$mess = "";
if(isset($_POST['action'])){
	if ($_POST['action'] ==  "login") {
		if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			$role = $_POST['role'];
			$_SESSION['role'] = $role;
			$id = $accountModel->checkAccount($username,$password,$role);
		}
		if ($id == 0) {
			$mess = "Login failed! Incorrect password account information";
		}
		if ($id == -1) {
			$mess = "Login failed! Your account has been locked";
		}
		if ($id > 0) {
			$_SESSION['login']['id_user'] = $id;
			header('location:index.php');
		}
	}
	if ($_POST['action'] == "register") {
		if (!empty($_POST['username']) && !empty($_POST['password'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			$bool_register = $accountModel->registerAccount($username,$password);
			if ($bool_register) {
				echo "<script>alert('Successful registration')</script>";
			}
			else{
				echo "<script>alert('Registration failed, account already exists')</script>";
			}
		}
		else{
			echo "<script>alert('Enter enough information')</script>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/stylelogin.css">
	<title>user login</title>
</head>

<body>
	<div class="align">
		<img class="logo" src="img/logo.svg">
		<div class="card">
			<div class="head">
				<div></div>
				<a id="login" class="selected" href="#login">Login</a>
				<a id="register" href="#register">Register</a>
				<div></div>
			</div>
			<div class="tabs">
				<form action="loginregister.php" method="post">
					<div class="inputs">
						<div class="input">
							<input placeholder="Username" type="text" name="username">
							<img src="img/user.svg">
						</div>
						<div class="input">
							<input placeholder="Password" type="password" name="password">
							<img src="img/pass.svg">
						</div>
						<label class="checkbox">
							<input type="radio" value="0" name="role" checked>
							<span>user</span>
						</label>
						<label class="checkbox">
							<input type="radio" value="1" name="role">
							<span>admin</span>
						</label>
					</div>
					<h5 style="color:red;"><?php echo $mess ?></h5>
					<button name="action" value="login">Login</button>
				</form>
				<form action="loginregister.php" method="post">
					<div class="inputs">
						<div class="input">
							<input placeholder="Username" type="text" name="username">
							<img src="img/user.svg">
						</div>
						<div class="input">
							<input placeholder="Password" type="text" name="password">
							<img src="img/pass.svg">
						</div>
					</div>
					<button name="action" value="register">Register</button>
				</form>
			</div>
		</div>
	</div>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/index.js"></script>
	
</body>

</html>