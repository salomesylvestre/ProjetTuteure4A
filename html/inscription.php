<?php
// Connexion à la base de données
session_start();
try {
    // On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=cr2;charset=utf8;port=3308', 'root', '');
} catch (Exception $e) {
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : ' . $e->getMessage());
}
//$bdd->exec('INSERT INTO personne(id_type,nom,prenom,mail,mdp)VALUES(1,\"eee\",\"eee\",\"ee@ee\",\"dess\")');

if (isset($_POST['forminscription'])) {
    $sexe = $_POST['sexe'];
    $statut = $_POST['statut'];
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $ville = htmlspecialchars($_POST['ville']);
    $cp = htmlspecialchars($_POST['cp']);
    $adresseDom = htmlspecialchars($_POST['adresseDom']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $email = htmlspecialchars($_POST['email']);
    $email2 = htmlspecialchars($_POST['email2']);
    $mdp = htmlspecialchars(($_POST['mdp']));
    $mdp2 = htmlspecialchars(($_POST['mdp2']));
    $passwordHash = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
    $passwordHash2 = password_hash($_POST['mdp2'], PASSWORD_DEFAULT);
    if (
        !empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['email']) and
        !empty($_POST['mdp']) and !empty($_POST['email2']) and !empty($_POST['telephone'])
        and !empty($_POST['mdp2']) and !empty(isset($_POST['adresseDom'])) and !empty($_POST['ville'])
        and !empty($_POST['cp']) and !empty($_POST['sexe']) and !empty($_POST['statut'])
    ) {
        $nomlength = strlen($nom);
        $prenomlength = strlen($prenom);
        $mdplength = strlen($mdp);
        if ($nomlength <= 32) {
            if ($prenomlength <= 32) {
                if ($email == $email2) {
                    $reqmail = $bdd->prepare("SELECT * from utilisateur where mail=?");
                    $reqmail->execute(array($email));
                    $mailExiste = $reqmail->rowCount();
                    if ($mailExiste == 0) {
                        if ($mdplength >= 8 && (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $mdp))) {
                            if (password_verify($mdp, $passwordHash) == password_verify($mdp2, $passwordHash2)) {
                                $insertUser = $bdd->prepare("INSERT INTO UTILISATEUR(ID_TYPE,MAIL,MDP,TEL,ADRESSE,VILLE,CP,SEXE,NOM,PRENOM) values(?,?,?,?,?,?,?,?,?,?) ");
                                if ($statut == "beneficiaire") {
                                    $statut = 3;
                                }
                                if ($statut == "benevole") {
                                    $statut = 2;
                                }
                                if ($statut == "moderateur") {
                                    $statut = 1;
                                }
                                $insertUser->execute(array($statut, $email, $passwordHash, $telephone, $adresseDom, $ville, $cp, $sexe, $nom, $prenom));

                                $CompteCree= "Un nouveau compte vient d'être créé";
                            } else {
                                $erreur=  "Erreur confirmation mot de passe";
                            }
                        } else {
                            $erreur=  " Mot de passe non conforme, il doit faire au moins 8 caractères et contenir au minimum une lettre minuscule, une lettre majuscule, un chiffre et un caractères spécial";
                        }
                    } else {
                        $erreur=  "Cette adresse mail est déjà utilisée";
                    }
                } else {
                    $erreur=  "Erreur confirmation adresse mail";
                }
            }
            else{
                $erreur=  "Le prenom ne doit pas dépasser 32 caractères";
            }
        } else {
            $erreur=  "Le nom ne doit pas dépasser 32 caractères";
        }
    } else {
        $erreur=  "Tous les champs doivent être renseignés";
    }
}

if (isset($_POST['reset'])) {
}
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
                    <li class="nav-item"><a class="nav-link" href="connexion.php">Se connecter</a></li>
                <?php
                } ?>

                <?php if (isset($_SESSION['id_type']) and ($_SESSION['id_type']) == 1) { ?>
                    <li class="nav-item"><a class="nav-link" href="#">Inscrire une personne
                            <?php ?></a></li><?php } ?>


            </ul>
            </ul>
        </div>
    </nav>

</head>



<body>

    <div class="container-fluid">

        <div class="row">
            <form class="form shadow-inset-center" name="forminscription" method="post">

                <h1>
                    <i class="fa fa-user-plus fa-lg"></i> Ajouter un nouveau membre</h1>
                <br>
                <br>
                <div class="row">
                    <div class="col">
                        <fieldset class="form-group" >
                                    <legend class="col-form-label col-sm-2 pt-0">Genre</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sexe" id="gridRadios1" value="femme" checked>
                                            <label class="form-check-label" for="gridRadios1">
                                                Femme
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sexe" id="gridRadios2" value="homme">
                                            <label class="form-check-label" for="gridRadios2">
                                                Homme
                                            </label>
                                        </div>
                                    </div>
                        </fieldset>
                    </div>
                    <div class="col">
                        <fieldset class="form-group">
                                    <legend class="col-form-label col-sm-2 pt-0">Statut</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="statut" id="gridRadios3" value="benevole" checked>
                                            <label class="form-check-label" for="gridRadios3">
                                                Bénévole
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="statut" id="gridRadios4" value="beneficiaire">
                                            <label class="form-check-label" for="gridRadios4">
                                                Bénéficiaire
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="statut" id="gridRadios5" value="moderateur">
                                            <label class="form-check-label" for="gridRadios5">
                                                Modérateur
                                            </label>
                                        </div>
                                    </div>
                        </fieldset>
                    </div>

                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="Nom"> Nom</label>
                            <input type="text" name="nom" id="Nom" class="form-control" value="<?php if (isset($nom)) ?>" required>
                        </div>

                    </div>
                    <div class="col">
                        <div class="form-group">
                            <?php if (isset($er_prenom)) { ?>
                                <div><?= $er_prenom ?></div>
                            <?php
                            }
                            ?>
                            <label for="Prénom"> Prénom</label>
                            <input type="text" name="prenom" class="form-control" value="<?php if (isset($prenom)) ?>" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?php
                    if (isset($er_telephone)) {
                    ?>
                        <div><?= $er_telephone ?></div>
                    <?php
                    }
                    ?>
                    <label for="tel"> Téléphone</label>
                    <input type="text" id="tel" name="telephone" class="form-control" value="<?php if (isset($telephone)) ?>" required>
                </div>
                <div class="form-group">
                    <?php
                    if (isset($er_adressedudomicile)) {
                    ?>
                        <div><?= $er_adressedudomicile ?></div>
                    <?php
                    }
                    ?>
                    <label for="adress"> Adresse du domicile </label>
                    <input type="text" id="adress" name="adresseDom" class="form-control" value="<?php if (isset($adresseDom)) ?>" required>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <?php
                            if (isset($er_ville)) {
                            ?>
                                <div><?= $er_ville ?></div>
                            <?php
                            }
                            ?>
                            <label for="ville"> Ville </label>
                            <input type="text" id="ville" name="ville" class="form-control" value="<?php if (isset($ville)) ?>" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="CP"> Code Postal </label>
                            <input type="text" id="CP" name="cp" class="form-control" value="<?php if (isset($cp)) ?>" required>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <label for="email"> Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php if (isset($email)) ?>">
                </div>
                <div class="form-group">
                    <label for="email"> Confirmation email</label>
                    <input type="email" id="email2" name="email2" class="form-control" value="<?php if (isset($email2)) ?>">

                </div>
                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" class="form-control" name="mdp" id="mdp" value="<?php if (isset($mdp)) ?>" required>
                </div>
                <div class="form-group">
                    <label for="mdp">Confirmation mot de passe</label>
                    <input type="password" class="form-control" name="mdp2" id="mdp2" value="<?php if (isset($mdp2)) ?>">
                </div>
              
                <?php if (isset($erreur)) {
                    echo '<font color ="red">' . $erreur . "</font>";
                }
                if(isset($CompteCree)){
                    echo '<font color ="green">' . $CompteCree . "</font>";
                }
                ?>
                <br>

                <input type="submit" id='submit' name="forminscription" value='Ajouter'>

            </form>
        </div>
    </div>

</body>

</html>