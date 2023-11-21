<?php
    require_once '../models/config.php';

    if (isset($_POST['valide'])) {

        if (!empty($_POST['password']) && !empty($_POST['confirm_password']) && !empty($_POST['token'])) {
            $password = sha1(htmlspecialchars($_POST['password']));
            $confirm_password = sha1(htmlspecialchars($_POST['confirm_password']));
            $token = htmlspecialchars($_POST['token']);
            //var_dump($token);
            
            $check = getUserToken($token);
            $row = $check->rowCount();
    
            if ($row) {
    
                if ($password === $confirm_password) {
    
                    $add = updateUser($password, $token);
    
                    if ($add) {  
                        delUser($token);
                        echo "<script>alert('Votre mot de passe a été modifié avec succès !'); window.location = '../views/forgot_password.php'</script>";
                    } else {
                        echo "<script>alert('Erreur de modification'); window.location = '../views/forgot_password.php'</script>";
                    }
                    
                } else {
                    echo "<script>alert('Les deux mot de passe ne sont pas identiques.'); window.location = '../views/forgot_password.php'</script>";
                }
                
            } else {
                echo "<script>alert('Le compte n\'existe pas.'); window.location = '../views/forgot_password.php'</script>";
            }
            
        } else {
            echo "<script>alert('Veuillez renseigner les champs !'); window.location = '../views/forgot_password.php'</script>";
        }
        
    }