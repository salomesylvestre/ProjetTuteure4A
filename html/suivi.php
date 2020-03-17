<?php
// Connexion à la base de données
session_start();
try {
    // On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=cr2;charset=utf8;port=3308', 'root', '');
} catch (Exception $e) {
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : ' . $e->getMessage());
} ?>



<!DOCTYPE html>

<head>

<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/81aa4e8517.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <title></title>


    <nav class="navbar navbar-expand-lg ">

        <a class="navbar-brand" href="#">
            <img src="../image/logo64.png" alt="" class="rounded-circle">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
         aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="fa fa-bars fa-lg" style="color:#e3001b; font-size:28px;"></i>
            </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
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
                    <li class="nav-item"><a class="nav-link" href="rdv.php">Nouveau trajet
                            <?php ?></a></li><?php } ?>
                <?php if (isset($_SESSION['id_type'])) { ?>
                    <li class="nav-item"><a class="nav-link" href="#">Mes trajets
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
    <br>
    <br>
    <div class="row">
        <div class="col">
            <div class="container-fluid">
                <h4>
                    <i class="fas fa-check"></i> Mes derniers rendez-vous</h4>
                    <div class="separator"></div>
                    <br>
                    
                <form class="form shadow-inset-center" >
                    <div class="form-group">
                        <label for="motif"> Motif: Dentiste </label>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="date"> Date: 13/02/2019 </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="heure"> Heure: 13h00 </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lieu"> Lieu: Castres </label>
                    </div>
                </form>
                <form class="form shadow-inset-center">
                    <div class="form-group">
                        <label for="motif"> Motif: Kinésithérapeute </label>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="date"> Date: 25/01/2019</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="heure"> Heure: 15h00 </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lieu"> Lieu: Revel </label>
                    </div>
                </form>
            </div>
        </div>
        <div class="col">
            <div class="col">
                <div class="container-fluid">
                    <h4>
                        <i class="fas fa-car-side fa-lg"></i> Mes prochains rendez-vous</h4>
                        <div class="separator"></div>
                        <br>
                    <form class="form shadow-inset-center">
                        <div class="form-group">
                            <label for="motif"> Motif: Médecin </label>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="date"> Date: 25/06/2020 </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="heure"> Heure: 12h30 </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lieu"> Lieu : Gaillac </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="container-fluid">
                <h4>
                    <i class="fas fa-bell"></i> Notifications</h4>
                    <div class="separator"></div>
                <br>
                <div class="row">
                    <form class="form shadow-inset-center">
                        <div class="form-group">
                            <label>N'oubliez pas le prochain rendez-vous ! </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</body>
</html>