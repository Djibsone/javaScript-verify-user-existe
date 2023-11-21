<?php
session_reset();
//Connexion à la base de données
function dbConnect(){
    try{
        $db = new PDO('mysql:host=localhost;dbname=envoi_mail;charset=utf8', 'djibril', 'tamou');
        return $db;
    }catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }
}

//Récupérer tous les users
function getMembres(){
    $db = dbConnect();

    $req = $db->query('SELECT * FROM membres ');
    $req->execute();
    return $req;
}


//Récupérer un user
function getMembre($mail){
    $db = dbConnect();

    $req = $db->prepare('SELECT * FROM membres WHERE mail = ?');
    $req->execute(array($mail));
    return $req;
}

//Récupérer un user
function getRecup($mail){
    $db = dbConnect();

    $req = $db->prepare('SELECT * FROM recuperation WHERE mail = ?');
    $req->execute(array($mail));
    return $req;
}

//Récupérer le pseudo user
function getUserPseudo($id){
    $db = dbConnect();

    $req = $db->prepare('SELECT * FROM membres WHERE id = ?');
    $req->execute(array($id));
    return $req;
}

//Récupérer le token d'un user
function getUserToken($u){
    $db = dbConnect();

    $req = $db->prepare('SELECT token FROM users WHERE token = ?');
    $req->execute(array($u));
    return $req;
}


//Récupérer toutes infos user depuis table password_reset en fction de token_user & token
function getToken($u, $token){
    $db = dbConnect();

    $req = $db->prepare('SELECT * FROM password_reset WHERE token_user = ? AND token = ?');
    $req->execute(array($u, $token));
    //$user = $req->fetch();
    return $req;
    //return $user;
}

//Récupérer toutes infos user depuis table password_reset en fction de token
function getTokenPasswordReset($token){
    $db = dbConnect();

    $req = $db->prepare('SELECT * FROM password_reset WHERE token_user = ?');
    $req->execute(array($token));
    return $req;
}

//Ajouter un user
function addUser($pseudo, $email, $password, $token){
    $db = dbConnect();

    $req = $db->prepare('INSERT INTO users(pseudo,email,password,token) VALUES(?,?,?,?)');

    if($req->execute(array($pseudo, $email, $password, $token)))
        return true;
    else
        return false;
}

//Ajouter l'infos membre dans la table recuperation
function addRecup($mail, $code){
    $db = dbConnect();

    $req = $db->prepare('INSERT INTO recuperation(mail,code) VALUES(?,?)');

    if($req->execute(array($mail, $code)))
        return true;
    else
        return false;
}

//Supprimer l'nfos user dans la table password_reset
function delUser($token){
    $db = dbConnect();

    $req = $db->prepare('DELETE FROM password_reset WHERE token_user = ?');

    if($req->execute(array($token)))
        return true;
    else
        return false;
}

//Modifier un info user
function updateRecup($code, $mail){
    $db = dbConnect();

    $req = $db->prepare('UPDATE recuperation SET code = ? WHERE mail = ?');

    if($req->execute(array($code, $mail)))
        return true;
    else
        return false;
}

