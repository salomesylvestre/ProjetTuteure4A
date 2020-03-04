<?php
// Connexion à la base de données
session_start();
try {
    // On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=cr;charset=utf8', 'root', '');
} catch (Exception $e) {
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : ' . $e->getMessage());
} ?>




<!DOCTYPE html>
<html>


<head>

    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/main_connexion.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <title></title>


    <nav class="navbar navbar-expand-lg ">

        <a class="navbar-brand" href="#">
            <img src="../image/logo64.png" alt="" class="rounded-circle">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link " href="accueil.php">Accueil </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="a_propos.php">A propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="service.php">Le service</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <?php if (isset($_SESSION['id_type']) and ($_SESSION['id_type']) == 3) { ?>
                    <li class="nav-item"><a class="nav-link" href="#">Nouveau trajet
                            <?php ?></a></li><?php } ?>
                <?php if (isset($_SESSION['id_type'])) { ?>
                    <li class="nav-item"><a class="nav-link" href="suivi.php">Mes trajets
                            <?php ?></a></li><?php } ?>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['id_type'])) { ?>
                    <!-- <li class="nav-item" >Bienvenue <?php echo $_SESSION['prenom']; ?></li> -->
                    <li class="nav-item"><a class="nav-link" href="deconnexion.php">Se deconnecter</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link" href="connexion.php">Se connecter</a></li>
                <?php
                } ?>

                <?php if (isset($_SESSION['id_type']) and ($_SESSION['id_type']) == 1) { ?>
                    <li class="nav-item"><a class="nav-link" href="inscription.php">Inscrire une personne
                            <?php ?></a></li><?php } ?>


            </ul>
            </ul>
        </div>
    </nav>

</head>



<body>

    <div class="container-fluid">
        <div class="row">
            <form class="form shadow-inset-center">
                <h1>
                    <i class="fa fa-user-plus fa-lg"></i> Prendre un nouveau rendez-vous</h1>
                <br>
                <br>
                <div class="form-group">
                    <label for="motif"> Motif</label>
                    <input type="text" id="motif" class="form-control">
                </div>
                <div class="form-group">
                    <label for="lieu"> Adresse du rendez-vous </label>
                    <input type="text" id="lieu" class="form-control">
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="date"> Date </label>
                            <input type="date" id="date" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="heure"> Heure du rendez-vous </label>
                            <input type="time" id="heure" class="form-control">
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col">
                        <h3>Départ souhaité</h3>
                        <div class="form-group">
                            <label for="heure_dep"> Heure de départ </label>
                            <input type="time" id="heure_dep" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="adresse_dep"> Adresse de départ </label>
                            <input type="text" id="date" class="form-control">
                        </div>

                    </div>
                    <div class="col">
                        <h3>Retour prévu</h3>
                        <div class="form-group">
                            <label for="heure_ret"> Heure de rétour </label>
                            <input type="time" id="heure_ret" class="form-control">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <input type="submit" id='submit' value='Enregistrer'>
                    </div>
                    <div class="col">
                        <input type="submit" id='submit' value='Annuler'>
                    </div>
            </form>
            </div>
        </div>


</body>

</html>