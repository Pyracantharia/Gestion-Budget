<?php 
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

if(!empty($_GET['id'])){
    $id_to_update = $_GET['id'];    

    /* Définition de la requête SQL */
    $requete_sql = "SELECT * FROM depenses WHERE id = $id_to_update";

    /* Execution de la requête SQL */
    $resultat = $connexion->query($requete_sql);

    if($resultat){
        $la_depense = $resultat->fetch_assoc();
    }
}

if(isset($_POST['modifier'])){
    if(!empty($_POST['titre']) && !empty($_POST['prix'])){
        
        $titre = $_POST['titre'];
        $prix = $_POST['prix'];
        $id = $_POST['id'];

        /* Définition de la requête SQL */
        $requete_sql = "UPDATE depenses SET titre = '$titre', prix = '$prix' WHERE id = $id ";

        /* Execution de la requête SQL */
        $resultat = $connexion->query($requete_sql);

        if($resultat){
            $message = "Dépenses modifié";
            $statut = "success";
        }else{
            $message = "Problème lors de la modification d'une dépense";
            $statut = "danger";
        }

    }else{
        echo "Un des champs n'est pas rempli"; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/bootstrap.js" defer></script>
    <title>Gestion budget - Ajouter une dépense</title>
</head>
<body>

    <div class="container">
        <h1>Modifier une dépense</h1>
        <?php if(!empty($message)) : ?>
            <div class="alert alert-<?php echo $statut ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post" class="mt-3">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" placeholder="Ex: Iphone 14" name="titre" value="<?php echo $la_depense['titre'] ?>" required>
                <label for="floatingInput">Titre de la dépense</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" class="form-control" id="floatingInput" placeholder="Ex: 1234" name="prix" value="<?php echo $la_depense['prix'] ?>" required>
                <label for="floatingInput">Prix de la dépense</label>
            </div>
            <input type="hidden" name="id" value="<?php echo $la_depense['id'] ?>">
            <button class="btn btn-primary btn-lg" type="submit" name="modifier">Modifier</button>
            
        </form>
        <form action="index.php">
            <br>
        <button type="submit" class="btn btn-primary btn-sm" value="Retour à la liste">Retour à la liste</button>
        </form>
    </div>
    
    
</body>
</html>