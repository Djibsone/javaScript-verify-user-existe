<?php
    require_once '../models/config.php';

    if (isset($_GET['u']) && isset($_GET['token']) && !empty($_GET['u']) && !empty($_GET['token'])) {
        //$u = htmlspecialchars(base64_decode($_GET['u']));
        $u = htmlspecialchars(urldecode($_GET['u']));
        //$token = htmlspecialchars(base64_decode($_GET['token']));
        $token = htmlspecialchars(urldecode($_GET['token']));

        $check = getToken($u, $token);
        $row = $check->rowCount();

        if ($row) {
            $get = getUserToken($u);
            $data_u = $get->fetch();

            if (hash_equals($data_u['token'], $u)) {
                header('location: ../views/forgot_password.php?u='.urldecode($u));
            } else {
                echo "<script>alert('Erreur de compte'); window.location = '../controllers/recoverController.php'</script>";
            }
            
        } else {
            echo "<script>alert('Le compte n'\est pas valide.'); window.location = '../views/recoverController.php'</script>";
        }
    } else {
        echo "<script>alert('Lien non valide')</script>";
    }

