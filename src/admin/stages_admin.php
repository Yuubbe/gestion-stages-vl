<!DOCTYPE html>
<html lang="fr">
<?php
session_start();
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="shortcut icon" href="../img/" type="image/x-icon">
    <title>Stages - Gestion Stage</title>
</head>

<body>

    <!-- Navbar -->
    <div class="navbar navbar-expand-md bg-dark navbar-dark">
        <div class="container">
            <a href="index.php" class="navbar-brand text-info">Gestion Stage</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainmenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainmenu">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a href="index.php" class="nav-link">Accueil</a></li>
                    <li class="nav-item"><a href="entreprises.html" class="nav-link">Entreprises</a></li>
                    <li class="nav-item"><a href="conventions.html" class="nav-link">Conventions</a></li>
                </ul>
                <div class="d-flex justify-content-end">
                    <?php
                    if (isset($_SESSION['utilisateur_connecte']) && $_SESSION['utilisateur_connecte'] === true) {
                        echo '<a href="logout.php" class="btn btn-outline-danger">Se déconnecter</a>';
                        echo '<a href="" class="btn btn-outline-info">' . $_SESSION['prenom'] . '</a>';
                    } else {
                        echo '<a href="page_connexion.html" class="btn btn-outline-info">Se connecter</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <section style="margin-top: 9%;">
            <div class="row">
                <div class="col-sm-6 my-1">
                    <h2 class="fw-bold">Liste des Stages</h2>
                    <p class="command-descreption">Trouvez les stages de vos étudiants plus facilement !</p>
                    <a href="insertion_stages.html" class="btn btn-outline-info">Insérer stage</a>
                </div>
            </div>
        </section>
    </div>

    <!-- Tableau des stages -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom de l'entreprise</th>
                <th>Rue</th>
                <th>Code Postal</th>
                <th>Ville</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Durée du stage</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $serveur = "127.0.0.1";
            $utilisateur = "root";
            $mot_de_passe = "root";
            $base_de_donnees = "gestion_stages";

            try {
                $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees;charset=utf8", $utilisateur, $mot_de_passe);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $dbh->prepare("SELECT id_e, nom_e, rue_e, CP_e, ville_e, date_debut_s, date_fin_s, duree_s FROM tbl_company");
                $stmt->execute();

                // Affiche les données dans le tableau
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row["id_e"] . "</td>";
                    echo "<td>" . $row["nom_e"] . "</td>";
                    echo "<td>" . $row["rue_e"] . "</td>";
                    echo "<td>" . $row["CP_e"] . "</td>";
                    echo "<td>" . $row["ville_e"] . "</td>";
                    echo "<td>" . $row["date_debut_s"] . "</td>";
                    echo "<td>" . $row["date_fin_s"] . "</td>";
                    echo "<td>" . $row["duree_s"] . "</td>";
                    echo "<td>";
                    echo "<a href='modifier.php?id_e=" . $row["id_e"] . "' class='btn btn-outline-info'>Modifier</a>";
                    echo " ";
                    echo "<a href='supprimer.php?id_e=" . $row["id_e"] . "' class='btn btn-outline-danger' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet élément?\");'>Supprimer</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "Erreur : " . htmlspecialchars($e->getMessage());
            }

            $dbh = null; // Fermer la connexion
            ?>
        </tbody>
    </table>
</div>

<!-- footer -->
<div class="footer-clean bg-dark">
    <footer>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-4 col-md-3 item">
                    <h3>Accès rapide</h3>
                    <ul>
                        <li><a href="#Features">Fonctionnalités</a></li>
                        <li><a href="#Statics">Statistiques</a></li>
                        <li><a href="#FAQ">Questions fréquentes</a></li>
                    </ul>
                </div>
                <div class="col-sm-4 col-md-3 item">
                    <h3>À propos</h3>
                    <ul>
                        <li><a href="#">L'équipe</a></li>
                        <li><a href="#">Licence</a></li>
                    </ul>
                </div>
                <div un autre col-sm-4 col-md-3 item">
                    <h3>Liens</h3>
                    <ul>
                        <li><a href="#">Support</a></li>
                        <li><a href="#">GitHub</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 item social">
                    <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
                </div>
            </div>
            <div class="footer-copyright text-center">Made with 💖 by Hadi Koubeissi &copy; 2024</div>
        </footer>
    </div>

<script src="../js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>
