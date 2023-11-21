<?php
require_once '../models/config.php';

if(isset($_POST['email'])) {
    $email = $_POST['email'];

    // Requête SQL pour la recherche
    $stmt = getMembre($email);

    // Récupération des résultats
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Affichage des résultats en JSON
    echo json_encode($results);
}