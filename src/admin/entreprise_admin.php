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
    <link href="../css/commands.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="shortcut icon" href="../img/" type="image/x-icon">
    <title>Entreprises - Gestion Stage</title>
</head>

<body>

    <!-- Navbar -->
    <div class="navbar navbar-expand-md bg-dark navbar-dark">
        <div class="container">
            <a href="index.php" class="navbar-brand text-info">Gestion Stage</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainmenu"><span class="navbar-toggler-icon"></span></button>

            <div class="collapse navbar-collapse" id="mainmenu">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a href="index.php" class="nav-link">Accueil</a></li>
                    <li class="nav-item"><a href="stages.php" class="nav-link">Entreprise</a></li>
                    <li class="nav-item"><a href="stages.php" class="nav-link">Stages</a></li>
                    <li class="nav-item"><a href="rapport.html" class="nav-link">Rédiger</a></li>
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
                    <h2 class="fw-bold">Liste des Entreprises</h2>
                    <p class="command-descreption">Trouvez les entreprises de vos étudiants plus facilement !</p>
                    <a href="insertion_entreprises.html" class="btn btn-outline-info">Insérer une entreprise</a>

                    <!-- Barre de recherche -->
                    <input type="text" id="search-bar" placeholder="Rechercher..." onkeyup="filterTable()">
                </div>
            </div>
        </section>
    </div>

    <!-- Tableau avec données -->
    <table border="1" id="stage-table">
        <tr>
            <th onclick="sortTable(0)"><input type="checkbox" class="filter-checkbox" data-column="0" checked> Nom de l'entreprise</th>
            <th onclick="sortTable(1)"><input type="checkbox" class="filter-checkbox" data-column="1" checked> Rue</th>
            <th onclick="sortTable(2)"><input type="checkbox" class="filter-checkbox" data-column="2" checked> Code Postal</th>
            <th onclick="sortTable(3)"><input type="checkbox" class="filter-checkbox" data-column="3" checked> Ville</th>
            <th onclick="sortTable(4)"><input type="checkbox" class="filter-checkbox" data-column="4" checked> Pays</th>
            <th onclick="sortTable(5)"><input type="checkbox" class="filter-checkbox" data-column="5" checked> Téléphone</th>
            <th onclick="sortTable(6)"><input type="checkbox" class="filter-checkbox" data-column="6" checked> Fax</th>
            <th onclick="sortTable(7)"><input type="checkbox" class="filter-checkbox" data-column="7" checked> Email</th>
        </tr>
        <?php
        try {
            $serveur = "127.0.0.1";
            $utilisateur = "root";
            $mot_de_passe = "root";
            $base_de_donnees = "stages";

            $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees;charset=utf8", $utilisateur, $mot_de_passe);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $dbh->prepare("SELECT nom_entreprise, rue_entreprise, cp_entreprise, ville_entreprise, pays_entreprise, tel_entreprise, fax_entreprise, email_entreprise FROM entreprise");
            $stmt->execute();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row["nom_entreprise"] . "</td>";
                echo "<td>" . $row["rue_entreprise"] . "</td>";
                echo "<td>" . $row["cp_entreprise"] . "</td>";
                echo "<td>" . $row["ville_entreprise"] . "</td>";
                echo "<td>" . $row["pays_entreprise"] . "</td>";
                echo "<td>" . $row["tel_entreprise"] . "</td>";
                echo "<td>" . $row["fax_entreprise"] . "</td>";
                echo "<td>" . $row["email_entreprise"] . "</td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        // Fermez la connexion
        $dbh = null;
        ?>
    </table>

    <!-- Fonction pour filtrer et trier le tableau -->
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

        function filterCheckedRows() {
            const checkboxes = document.querySelectorAll('.filter-checkbox');
            const table = document.getElementById("stage-table");
            const rows = table.getElementsByTagName("tr");

            // Obtenir les index des colonnes à afficher
            const columnsToShow = [];
            checkboxes.forEach((checkbox, index) => {
                if (checkbox.checked) {
                    columnsToShow.push(parseInt(checkbox.getAttribute('data-column')));
                }
            });

            // Afficher/masquer les cellules selon les cases cochées
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName("td");

                for (let j = 0; j < cells.length; j++) {
                    cells[j].style.display = columnsToShow.includes(j) ? "" : "none";
                }
            }
        }

        function sortTable(columnIndex) {
            const table = document.getElementById("stage-table");
            let rows = Array.from(table.rows).slice(1);
            let ascending = table.rows[0].cells[columnIndex].getAttribute("data-order") === "asc";
            let multiplier = ascending ? 1 : -1;

            rows.sort((rowA, rowB) => {
                const cellA = rowA.cells[columnIndex].innerText.toLowerCase();
                const cellB = rowB.cells[columnIndex].innerText.toLowerCase();

                if (cellA < cellB) return -1 * multiplier;
                if (cellA > cellB) return 1 * multiplier;
                return 0;
            });

            rows.forEach(row => table.appendChild(row));

            table.rows[0].cells[columnIndex].setAttribute("data-order", ascending ? "desc" : "asc");
        }

        // Ajouter un événement à chaque case à cocher
        document.querySelectorAll('.filter-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', filterCheckedRows);
        });

        // Initialiser l'affichage des colonnes
        filterCheckedRows();
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
            </div>
        </footer>
    </div>

    <!-- Scripts supplémentaires -->
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>
