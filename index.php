<!DOCTYPE html>
<html>
<head>
	<title>Formulaire de connection</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="./assets/css/style.css">
	<link rel="stylesheet" href="./assets/font-awesome/css/font-awesome.min.css">
</head>
<body>

	<div class="container">
		<p>Formulaire de connection</p>
		<form action="controllers/indexController.php" method="post">
			<div class="inputIcon">
				<label>Email :</label>
				<input type="email" id="email" name="email" placeholder="name@gmail.com">
				<i class="fa fa-envelope"></i>
			</div>
			<div class="error"></div>
			<div class="inputIcon">
				<label>Mot de passe :</label>
				<input type="password" id="password" name="password" placeholder="***********">
				<i class="fa fa-lock"></i>
				<span class="eye">
					<i class="fa fa-eye"></i>
					<i class="fa fa-eye-slash"></i>
				</span>
			</div>
			<div class="errorpassword"></div>
			<br>
			<div>
				<button type="submit" name="connecte">Se connecter</button>
				<a href="./views/recover_password.php">Mot de passe oublié?</a>
				<br><br>
				<a href="./views/register.php">Inscrivez-vous ici</a>
			</div>
		</form>
	</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./assets/js/script.js"></script>
</body>
</html>