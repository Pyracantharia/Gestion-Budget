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

    /* Définition de la requête SQL */
    $requete_sql = "SELECT * FROM depenses";

    
    /* Execution de la requête SQL */
    $resultat = $connexion->query($requete_sql);

    function calculTotalDepenses($connexion){
        $total = 0;

        $requete_sql = "SELECT * FROM depenses";
        $resultat = $connexion->query($requete_sql);

        if($resultat->num_rows > 0){
            while( $les_depenses = $resultat->fetch_assoc() ){
                
                $total += $les_depenses['prix'];
            }
        }
        
        $total = intval($total);
        $total = number_format($total, 2, ',', ' ');
        return $total;
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
    <title>Gestion budget</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col-lg-8">
                <!-- Titre  -->
                <h1>Liste des dépenses</h1>
                <a class="btn btn-outline-primary" href="form-ajout-depense.php" role="button">Créer une dépense</a>
            </div>
            <div class="col-lg-4">
                <!-- Card -->
                <div class="card text-bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total des dépenses :<br> 
                        <span class="h1"><?php echo calculTotalDepenses($connexion); ?> €</span></h5>
                        <p class="card-text">La liste ci-dessous résument la liste des dépenses</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- List group  -->
        <?php if($resultat->num_rows > 0) : ?>
            <ol class="list-group">

                <?php while( $les_depenses = $resultat->fetch_assoc() ) : ?>
                    <!-- 1e occurence de la boucle
                    FETCH_ASSOC
                    $les_depenses = array(
                                          'id'      => 3,
                                          'titre'   => 'iPhone 14 Pro 128 GB',
                                          'prix'    => '1329'
                                        )
                    FETCH_ARRAY
                    $les_depenses = array(3, 'iPhone 14 Pro 128 GB', '1329')
                    -->
                    <li class="list-group-item d-flex justify-content-between align-items-start mb-4">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold text-uppercase">
                            
                            <?= 
                            
                            $les_depenses["titre"];

                            ?>
                        
                        </div>
                            <a href="delete-depense.php?id=<?= $les_depenses["id"] ?>" class="link-danger" onclick="return confirm('Vous êtes sur de supprimer cette dépense ?')">Supprimer</a>
                            <a href="update-depense.php?id=<?= $les_depenses["id"] ?>" class="link-primary">Modifier</a>
                            
                
                        </div>
                        <span class="badge bg-primary"><?= $les_depenses["prix"] ?> €</span>
                        
                        
                            
                       
                        
                    </li>
                    
                <?php endwhile; ?>

            </ol>
        <?php else : ?>
            <div class="alert alert-danger" role="alert">
                Aucune dépenses trouvées
            </div>
        <?php endif; ?>
    </div>


</body>
</html>



