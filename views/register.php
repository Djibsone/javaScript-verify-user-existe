<!DOCTYPE html>
<html>
<head>
	<title>Formulaire d'inscription</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../assets/css/style.css">
	<link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
</head>
<body>

	<div class="container">
		<p>Formulaire d'inscription</p>
		<form action="../controllers/registerController.php" method="post">
			<div class="inputIcon">
				<label>Pseudo :</label>
				<input type="text" id="pseudo" name="pseudo" placeholder="votre pseudo">
				<i class="fa fa-user"></i>
			<div>
			<div class="inputIcon">
				<label>Email :</label>
				<input type="email" id="email" name="email" placeholder="name@gmail.com">
				<i class="fa fa-envelope"></i>	
			<div>
			<div class="inputIcon">
				<label>Mot de passe :</label>
				<input type="password" id="password" name="password" placeholder="***********">
				<i class="fa fa-lock"></i>
				<span class="eye">
					<i class="fa fa-eye"></i>
					<i class="fa fa-eye-slash"></i>
				</span>	
			<div>
			<div class="inputIcon">
				<label>Confirmer le mot de passe :</label>
				<input type="password" id="confirm_password" name="confirm_password" placeholder="***********">
				<i class="fa fa-lock"></i>
				<span class="eye">
					<i class="fa fa-eye"></i>
					<i class="fa fa-eye-slash"></i>
				</span>	
			<div>
			<br>
			<button type="submit" name="inscrit">S'inscrire</button>
            <a href="../">Connectez-vous ici</a>
		</form>
	</div>

<script src="../assets/js/script.js"></script>
</body>
</html>
