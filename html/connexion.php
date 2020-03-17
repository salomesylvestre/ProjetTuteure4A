<?php
session_start();
try
{
	// On se connecte à MySQL
	$bdd = new PDO('mysql:host=localhost;dbname=cr2;charset=utf8;port=3308', 'root', '');
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

if (isset($_POST['formconnexion'])) {

    $emailConnect = htmlspecialchars($_POST['mail']);
    $passwordConnect = htmlspecialchars(($_POST['mdp']));
    //$passwordHash = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
   // echo $passwordHash;
    //echo $passwordConnect;
    if (!empty($emailConnect) and !empty($passwordConnect)) {
        $requser = $bdd->prepare("SELECT mail, mdp, id_type, id_utilisateur, prenom from utilisateur where mail=?");
        $requser->execute(array($emailConnect));
        $userExist = $requser->rowCount();
               

        if ($userExist == 1) {
            $userinfo = $requser->fetch();
           echo $userinfo['mdp'];
             //verifier le hachage
           $mdpCorrect = password_verify($passwordConnect, $userinfo['mdp']);
           //echo $mdpCorrect;
           //if($passwordConnect == $userinfo['mdp']){
             if ($mdpCorrect) {
              echo 'mdp correct';
                    $_SESSION['id_utilisateur'] = $userinfo['id_utilisateur'];
                    $_SESSION['mail'] = $userinfo['mail'];
                    $_SESSION['id_type'] = $userinfo['id_type'];
                    $_SESSION['prenom'] = $userinfo['prenom'];
                    header('Location: accueil.php?=' . $userinfo['id_type']);
                    $ConnexionOk = 'Connecte';
            } else {
                 $erreur = 'Mot de passe incorrect';
                 
             }
        } else {
            $erreur = 'Adresse mail incorrect';
        }
    } else {
        $erreur = 'Il faut completer tous les champs !';
    }}



?>
<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
                    <li class="nav-item"><a class="nav-link" href="suivi.php">Mes trajets
                            <?php ?></a></li><?php } ?>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['id_type'])) { ?>
                    <!-- <li class="nav-item" >Bienvenue <?php echo $_SESSION['prenom']; ?></li> -->
                    <li class="nav-item"><a class="nav-link" href="deconnexion.php">Se deconnecter</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link" href="#">Se connecter</a></li>
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
        <div id="container">

            <form class="shadow-inset-center" method="POST">

                <h1><i class="fa fa-user fa-lg"></i> Connexion</h1>
                <br>
                <br>
                <label><b>Adresse mail</b></label>
                <input type="text" placeholder="Entrer votre adresse mail" name="mail" required>

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrer le mot de passe" name="mdp" required>
                
                <?php if (isset($erreur)) {
                    echo '<font color ="red">' . $erreur . "</font>";
                }
                if(isset($ConnexionOk)){
                    echo '<font color ="green">' . $ConnexionOk . "</font>";
                }
                ?>


                <input type="submit" name="formconnexion" id='submit' value='Connexion' >
               
            </form>
            </div>
    </body>
</html>

