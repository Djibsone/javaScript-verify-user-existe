<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');
 
if(isset($_POST['forminscription'])) {
   $pseudo = htmlspecialchars($_POST['pseudo']);
   $mail = htmlspecialchars($_POST['mail']);
   $mail2 = htmlspecialchars($_POST['mail2']);
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);
   if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
      $pseudolength = strlen($pseudo);
      if($pseudolength <= 255) {
         if($mail == $mail2) {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
               $reqmail->execute(array($mail));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
                  if($mdp == $mdp2) {
                     $longueurKey = 15;
                     $key = "";
                     for($i=1;$i<$longueurKey;$i++) {
                        $key .= mt_rand(0,9);
                     }
                     $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, motdepasse, confirmkey, uniqid) VALUES(?, ?, ?, ?, ?)");
 
                     $insertmbr->execute(array($pseudo, $mail, $mdp, $key, uniqid()));
 
                     $header="MIME-Version: 1.0\r\n";
                     $header.='From:"[VOUS]"<votremail@mail.com>'."\n";
                     $header.='Content-Type:text/html; charset="uft-8"'."\n";
                     $header.='Content-Transfer-Encoding: 8bit';
                     $message='
                     <html>
                        <body>
                           <div align="center">
                              <a href="http://127.0.0.1/Tutos%20PHP/%2314%20%28Espace%20membre%29/confirmation.php?pseudo='.urlencode($pseudo).'&key='.$key.'">Confirmez votre compte !</a>
                           </div>
                        </body>
                     </html>
                     ';
                     mail($mail, "Confirmation de compte", $message, $header);
                     $erreur = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
                  } else {
                     $erreur = "Vos mots de passes ne correspondent pas !";
                  }
               } else {
                  $erreur = "Adresse mail déjà utilisée !";
               }
            } else {
               $erreur = "Votre adresse mail n'est pas valide !";
            }
         } else {
            $erreur = "Vos adresses mail ne correspondent pas !";
         }
      } else {
         $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>
<html>
   <head>
      <title>TUTO PHP</title>
      <meta charset="utf-8">
   </head>
   <body>
      <div align="center">
         <h2>Inscription</h2>
         <br /><br />
         <form method="POST" action="">
            <table>
               <tr>
                  <td align="right">
                     <label for="pseudo">Pseudo :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mail">Mail :</label>
                  </td>
                  <td>
                     <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mail2">Confirmation du mail :</label>
                  </td>
                  <td>
                     <input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mdp">Mot de passe :</label>
                  </td>
                  <td>
                     <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mdp2">Confirmation du mot de passe :</label>
                  </td>
                  <td>
                     <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td align="center">
                     <br />
                     <input type="submit" name="forminscription" value="Je m'inscris" />
                  </td>
               </tr>
            </table>
         </form>
         <?php
         if(isset($erreur))
         {
            echo '<font color="red">'.$erreur."</font>";
         }
         ?>
      </div>
   </body>
</html>
confirmation.php
  <?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');
 
if(isset($_GET['pseudo'], $_GET['key']) AND !empty($_GET['pseudo']) AND !empty($_GET['key'])) {
   $pseudo = htmlspecialchars(urldecode($_GET['pseudo']));
   $key = htmlspecialchars($_GET['key']);
   $requser = $bdd->prepare("SELECT * FROM membres WHERE pseudo = ? AND confirmkey = ?");
   $requser->execute(array($pseudo, $key));
   $userexist = $requser->rowCount();
   if($userexist == 1) {
      $user = $requser->fetch();
      if($user['confirme'] == 0) {
         $updateuser = $bdd->prepare("UPDATE membres SET confirme = 1 WHERE pseudo = ? AND confirmkey = ?");
         $updateuser->execute(array($pseudo,$key));
         echo "Votre compte a bien été confirmé !";
      } else {
         echo "Votre compte a déjà été confirmé !";
      }
   } else {
      echo "L'utilisateur n'existe pas !";
   }
}
?>




//autre code 

<?php
require_once '../models/config.php';

if(isset($_POST['email']) && !empty($_POST['email'])) {
    // Vérifiez si l'e-mail existe dans la base de données
    $email = $_POST['email'];
    $user = getUserByEmail($email);

    if($user) {
        // Génère un jeton de réinitialisation de mot de passe
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $result = createPasswordResetToken($user['id'], $token, $expiry);

        if($result) {
            // Envoie un e-mail contenant un lien de réinitialisation de mot de passe sécurisé
            $resetLink = 'https://example.com/reset_password.php?token=' . urlencode(base64_encode($token));
            $to = $email;
            $subject = 'Réinitialisation de votre mot de passe';
            $message = "Bonjour,\n\nNous avons reçu une demande de réinitialisation de votre mot de passe. Si vous avez fait cette demande, veuillez cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe :\n\n$resetLink\n\nCe lien expirera dans 1 heure. Si vous n'avez pas effectué cette demande, ignorez simplement cet e-mail.\n\nCordialement,\nL'équipe de Example.com";
            $headers = 'From: noreply@example.com' . "\r\n" .
                'Reply-To: noreply@example.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            if(mail($to, $subject, $message, $headers)) {
                echo 'Un e-mail de réinitialisation de mot de passe a été envoyé à l\'adresse ' . $email . '. Veuillez consulter votre boîte de réception.';
            } else {
                echo 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail de réinitialisation de mot de passe. Veuillez réessayer plus tard.';
            }
        } else {
            echo 'Une erreur s\'est produite lors de la création du jeton de réinitialisation de mot de passe. Veuillez réessayer plus tard.';
        }
    } else {
        echo 'Aucun utilisateur n\'est enregistré avec cette adresse e-mail.';
    }
}
?>
