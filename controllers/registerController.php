<?php
require_once '../models/config.php';

if (isset($_POST['inscrit'])) {
    if (!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {
        //echo 'ok';
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $password = sha1(htmlspecialchars($_POST['password']));
        $confirm_password = sha1(htmlspecialchars($_POST['confirm_password']));
        $token = bin2hex(openssl_random_pseudo_bytes(24));

        $check = getUserPseudo($pseudo);
        $row = $check->rowCount();

        if ($row === 0) {

            if ($password === $confirm_password) {

                $add = addUser($pseudo, $email, $password, $token);

                if ($add) {
                    echo "<script>alert('Utisateur ajouté avec succès !'); window.location = '../views/register.php'</script>";
                } else {
                    echo "<script>alert('Erreur d'\insertion'); window.location = '../views/register.php'</script>";
                }
                
            } else {
                echo "<script>alert('Les deux mot de passe ne sont pas identiques.'); window.location = '../views/register.php'</script>";
            }
            
        } else {
            echo "<script>alert('Le pseudo existe déjà.'); window.location = '../views/register.php'</script>";
        }
        
    } else {
        echo "<script>alert('Veuillez renseigner les champs !'); window.location = '../views/register.php'</script>";
    }
    
}