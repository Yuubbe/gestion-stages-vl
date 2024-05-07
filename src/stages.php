<!DOCTYPE html>
<html lang="en">
<?php
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/commands.css" rel="stylesheet">
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

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainmenu"><span
                    class="navbar-toggler-icon"></span></button>

            <div class="collapse navbar-collapse" id="mainmenu">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a href="index.php" class="nav-link">Accueil</a></li>
                    <li class="nav-item"><a href="entreprises.html" class="nav-link">Entreprises</a></li>
                    <li class="nav-item"><a href="conventions.html" class="nav-link">Conventions</a></li>
                </ul>
                <br>
                <?php
                if (isset($_SESSION['utilisateur_connecte']) && $_SESSION['utilisateur_connecte'] === true) {
                    echo '<li class="navbar-nav nav-item"><a href="logout.php" class="btn btn-outline-danger">Se déconnecter</a></li>';
                    echo '<li class="navbar-nav nav-item"><a href="" class="btn btn-outline-info">' . $_SESSION['prenom'] . '</a></li>';
                } else {
                    echo '<li class="navbar-nav nav-item"><a href="page_connexion.html" class="btn btn-outline-info">Se connecter</a></li>';
                }
                ?>
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

                    <!-- Barre de recherche -->
                    <input type="text" id="search-bar" placeholder="Rechercher..." onkeyup="filterTable()">
                </div>
            </div>
        </section>
    </div>

    <!-- Tableau avec données -->
    <table border="1" id="stage-table">
        <tr>
            <th>ID</th>
            <th>Nom de l'entreprise</th>
            <th>Rue</th>
            <th>Code Postal</th>
            <th>Ville</th>
            <th>Date de début</th>
            <th>Date de fin</th>
            <th>Durée</th>
        </tr>
        <?php
        try {
            $serveur = "127.0.0.1";
            $utilisateur = "root";
            $mot_de_passe = "root";
            $base_de_donnees = "gestion_stages";

            $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $dbh->prepare("SELECT id_e, nom_e, rue_e, CP_e, ville_e, date_debut_s, date_fin_s, duree_s FROM tbl_company");
            $stmt->execute();
            
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
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        // Fermez la connexion
        $dbh = null;
        ?>
    </table>

    <!-- Fonction pour filtrer le tableau -->
    <script>
        function filterTable() {
            const input = document.getElementById("search-bar");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("stage-table");
            const rows = table.getElementsByTagName("tr");

            // Filtrer les lignes en fonction du texte entré
            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName("td");
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].innerText.toLowerCase().includes(filter)) {
                        found = true;
                        break; // Si une cellule correspond, on arrête
                    }
                }

                row.style.display = found ? "" : "none";
            }
        }
    </script>

    <!-- Footer -->
    <div class="footer-clean bg-dark">
        <footer>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-4 col-md-3 item">
                        <h3>Quick access</h3>
                        <ul>
                            <li><a href="#Features">Features</a></li>
                            <li><a href="#Statics">Statics</a></li>
                            <li><a href="#FAQ">Ask me</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 item social">
                        <ion-icon name="logo-discord"></ion-icon>
                        <ion-icon name="logo-facebook"></ion-icon>
                        <ion-icon name="logo-twitter"></ion-icon>
                        <ion-icon name="logo-instagram"></ion-icon>
                        <p class="copyright">Notre-Dame-La-Providence © 2024</p>
                    </div>
                </div>
            </footer>
    </div>

    <!-- Scripts supplémentaires -->
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>
