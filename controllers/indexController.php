<?php
require_once '../models/config.php';

if (isset($_POST['connecte'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = htmlspecialchars($_POST['email']);
        $password = sha1(htmlspecialchars($_POST['password']));

        $check = getMembre($email);
        $data = $check->fetch();
        $row = $check->rowCount();
        
        if ($row) {

            if (hash_equals($data['mail'], $email) && hash_equals($data['password'], $password)) {
                $pseudo = $data['pseudo'];
                //$link = '../views/home.php?u=' . $pseudo . '&p=' . $password;
                $link = '../views/home.php?u='. $pseudo;
               header('location:'. $link);
            } else {
                echo "<script>alert('L\'email ou le mot de passe incorrect.'); window.location = '../'</script>";
            }
            
        } else {
            echo "<script>alert('Le compte n\'existe.'); window.location = '../'</script>";
        }
        
    } else {
        echo "<script>alert('Veuillez renseigner les champs !'); window.location = '../'</script>";
    }
    
}