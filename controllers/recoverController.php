<?php
require_once '../models/config.php';

if (isset($_POST['envoie'])) {
    if (!empty($_POST['email'])) {
        $email = htmlspecialchars($_POST['email']); 

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $check = getMembres($email);
            $data = $check->fetch();
            $row = $check->rowCount();

            if ($row) {
                $pseudo = $data['pseudo'];
                $_SESSION['email'] = $email;
                $code = '';
                for ($i=0; $i < 8; $i++) { 
                    $code .= mt_rand(0,9);
                }

                $check = getRecup($email);
                $row = $check->rowCount();

                if ($row) {
                    updateRecup($code, $email);
                } else {
                    $add =  addRecup($email, $code);
                    if ($add) {
                        echo "<script>alert('Bien envoyé !'); window.location = '../views/recover_password.php'</script>";
                    } else {
                        echo "<script>alert('Erreur d\'envoie!'); window.location = '../views/recover_password.php'</script>";
                    }
                    
                }

                $header="MIME-Version: 1.0\r\n";
                $header.='From:"CRACKEDTAMOU.com"<support@crackedtamou.com>'."\n";
                $header.='Content-Type:text/html; charset="utf-8"'."\n";
                $header.='Content-Transfer-Encodng: 8bit';
                $message = '
                            <!DOCTYPE html>
                            <html lang="en">
                            <head>
                                <meta charset="UTF-8">
                                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <link rel="stylesheet" href="../assets/css/style.css">
                                <title>Récupération de mot de passe</title>
                            </head>
                            <body>

                                <div class="container">
                                    <p>Bonjour '.$pseudo.'</p>
                                    Cliquez <a href="http://127.0.0.1:8000/views/forgot_password.php?section=code&code='.$code.'">ici</a> pour réinitiliser votre mot de passe
                                </div>

                            </body>
                            </html>
                        ';
                mail($email, 'Récupération de mot de passe - Toto.com', $message, $header);
                

            } else {
                echo "<script>alert('Le compte n\'existe pas.'); window.location = '../views/recover_password.php'</script>";
            }
            
        } else {
            echo "<script>alert('Adresse mail invalide'); window.location = '../views/recover_password.php'</script>";
        }
        
    } else {
        echo "<script>alert('Veuillez renseigner les champs !'); window.location = '../views/recover_password.php'</script>";
    }
    
}