<?php
$id_to_delete = $_GET["id"];

/* Je recupere les info de connexion à la base de données dans des variables */
$servername     = "localhost";
$username       = "root";
$password       = "root";
$dbname         = "budget_bdd";

/* Je procède à la connexion et je la stocke dans une variable */
$connexion = new mysqli($servername, $username, $password, $dbname);

/* Si la connexion s'est mal passé */
if($connexion->connect_error){
    die("Connexion impossible");
}

/* Définition de la requête SQL */
$requete_sql = "DELETE FROM depenses WHERE id = $id_to_delete";
/* Execution de la requête SQL */
$resultat = $connexion->query($requete_sql);

if($resultat){
    header("Location: index.php");
}else{
    echo 'Probleme de suppression';
}

?>