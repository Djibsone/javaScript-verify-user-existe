<?php 
    require_once '../models/config.php';

    if(isset($_GET['u']) && !empty($_GET['u'])){

        $token = htmlspecialchars(urldecode($_GET['u']));
        $check = getTokenPasswordReset($token);
		//$g = $check->fetch();
        $row = $check->rowCount();

        if($row === 0){
            echo "Lien non valide";
            die();
        }
    }
?>



<!DOCTYPE html>
<html>
<head>
	<title>Formulaire de changement de mot de passe</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../assets/css/style.css">
	<link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
</head>
<body>

	<div class="container">
		<p>Formulaire de changement de mot de passe</p>
		<form action="../controllers/fortgotController.php" method="post">
			<input type="hidden" name="token" value="<?= urldecode(htmlspecialchars($_GET['u'])); ?>">
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
			<button type="submit" name="valide">Valider</button>
            <a href="../">Connectez-vous ici</a>
		</form>
	</div>

<script src="../assets/js/script.js"></script>
</body>
</html>
