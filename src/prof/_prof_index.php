<!DOCTYPE html>
<html lang="fr">
<?php
session_start();
?>


<style>
.test{
    margin-left:0px;
    }
.test1{
    margin-right:80px ;
}
 
</style>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="shortcut icon" href="./img/" type="image/x-icon">
    <title>professeur - Gestion Stage</title>
</head>

<body>

    <!-- Navbar -->

    <div class="navbar navbar-expand-md bg-dark navbar-dark">
        <div class="container">
            <a href="index.php" class="navbar-brand text-info">Gestion Stage
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainmenu"><span
                    class="navbar-toggler-icon"></span></button>

            <div class="collapse navbar-collapse" id="mainmenu">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a href="/./index.php" class="nav-link">Accueil</a></li>
                    <li class="nav-item"><a href="/prof/validation_entreprises.php" class="nav-link">demande de validation d'entreprises</a></li>
                    <li class="nav-item"><a href="/prof/validation_stages.php" class="nav-link">demande de validation de stages</a></li>
                    <li class="nav-item"><a href="/prof/stages_prof.php" class="nav-link">stages</a></li>
                    <li class="nav-item"><a href="/prof/entreprise_prof.php" class="nav-link">entreprises</a></li>
                </ul><br>
                <?php
                if (isset($_SESSION['utilisateur_connecte']) && $_SESSION['utilisateur_connecte'] === true) {
                    echo '<li class="navbar-nav nav-item"><a href="logout.php" class="btn btn-outline-danger">Se déconnecter</a></li>';
                    echo '<li class="navbar-nav nav-item"><a href="" class="btn btn-outline-info">'.$_SESSION['prenom'].'</a></li>';
                } else {
                    echo '<li class="navbar-nav nav-item"><a href="page_connexion.html" class="btn btn-outline-info">Se connecter</a></li>';
                }
                ?>
            </div>
        </div>
    </div>


    <!-- Info -->


    <section class="bg-dark text-light text-center py-5">
        <div class="container">
            <div class="d-flex">
                <div>
                <form class="test1"> 
                    <h1><span class="text-info">professeur</span> Stages</h1>
                    <p >Créer par deux étudiants de la Filière SIO à Notre-Dame-La-Providence sur Avranches. Gestion Stages, vous permettra de simplifier les relations entre établissements, entreprises et étudiants.
                    </p>
                    <a class="btn btn-info" href="https://www.ecoledirecte.com/login?cameFrom=%2FAccueil" target="_blank">Ecole Directe</a>
                    <a class="m-2 btn btn-light" href="https://ndlpavranches.fr/" target="_blank">NDLP</a>
                    </form>
                </div>
                <img width="20%" src="../img/ndlp.png" alt="">
            </div>
        </div>
    </section>


    <!-- Features -->


    <section  id="Features" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">
                Pourquoi sommes-nous utile?
            </h2>
            <div class="row text-center">
                <div class="col-sm">
                    <div class="card bg-dark text-light mb-3">
                        <div class="h1 mt-3">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="card-body text-center">
                            <h4 class="card-title text-info">Gain de temps</h4>
                            <p class="card-text"> Vous pourrez trouver un stage plus facilement grâce à notre liste d'entreprises, vous serez mit au courant de celles qui sont en recherches ! </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="card bg-dark text-light mb-3">
                        <div class="h1 mt-3">
                            <i class="bi bi-capslock-fill"></i>
                        </div>
                        <div class="card-body text-center">
                            <h4 class="card-title text-info">Échange</h4>
                            <p class="card-text">Nous nous assurons d'automiser les échanges entre l'entreprises et les stagiaires !</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="card bg-dark text-light mb-3">
                        <div class="h1 mt-3">
                            <i class="bi bi-folder2-open"></i>
                        </div>
                        <div class="card-body text-center">
                            <h4 class="card-title text-info">Open Source</h4>
                            <p class="card-text"> Pour les établissements qui sont interessés, vous aurez accès gratuitement à notre logiciel !</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  <!-- footer -->

    <div class="footer-clean bg-dark">
    <footer>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-4 col-md-3 item">
                    <h3>Accès rapide</h3>
                    <ul>
                        <li><a href="./pages/entreprise.html">Entreprises</a></li>
                        <li><a href="stages.html">Stages</a></li>
                        <li><a href="./pages/conventions.html">Conventions</a></li>
                        <li><a href="index.php">Admin Mode</a></li>
                    </ul>
                </div>
                <div class="col-sm-4 col-md-3 item">
                    <h3>Liens</h3>
                    <ul>
                        <li><a href="https://www.ecoledirecte.com/login?cameFrom=%2FAccueil">Ecole Directe</a></li>
                        <li><a href="https://ndlpavranches.fr/">NDLP</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 item social">
                    <p class="copyright">Notre-Dame-La-Providence © 2024</p>
                </div>
            </div>
        </div>
        <div class="page-footer font-small text-light mt-5">
        <div class="footer-copyright text-center">Créer par
        <a href="https://monportfolio.cloud/" target="_blank">Vincent GAMBLIN</a>
            &
            <a href="https://portfoliodeleo.fr/" target="_blank">Léo GERMAIN</a> 
            © 2024 Copyright
          </div>
        </div>
    </footer>
</div>

    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>