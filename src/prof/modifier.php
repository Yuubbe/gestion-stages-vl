<?php
// Vérifie si l'identifiant de la ligne à modifier est passé en paramètre
if (isset($_GET['id_e']) && !empty($_GET['id_e'])) {
    $id = $_GET['id_e'];  // Utilisez le paramètre correct

    // Configuration de la base de données
    $serveur = "127.0.0.1"; 
    $utilisateur = "root"; 
    $mot_de_passe = "root"; 
    $base_de_donnees = "gestion_stages"; 

    try {
        // Connexion à la base de données
        $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees;charset=utf8", $utilisateur, $mot_de_passe);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête pour obtenir les données de la ligne à modifier
        $stmt = $dbh->prepare("SELECT id_e, nom_e, rue_e, CP_e, ville_e, date_debut_s, date_fin_s, duree_s FROM tbl_company WHERE id_e = :id_e");
        $stmt->bindParam(':id_e', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si la ligne correspondante existe
        if ($row) {
?>
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="utf-8">
                <title>Modifier une ligne</title>
                <link href="../css/bootstrap.min.css" rel="stylesheet">
                <link href="../css/style.css" rel="stylesheet">
            </head>
            <body>
                <h1>Modifier les informations de l'entreprise</h1>
                <form action="traitement_modif.php" method="POST">
                    <input type="hidden" name="id_e" value="<?php echo htmlspecialchars($id); ?>">

                    <label for="nom_e">Nom de l'entreprise:</label><br>
                    <input type="text" id="nom_e" name="nom_e" value="<?php echo htmlspecialchars($row['nom_e']); ?>"><br>

                    <label for="rue_e">Rue:</label><br>
                    <input type="text" id="rue_e" name="rue_e" value="<?php echo htmlspecialchars($row['rue_e']); ?>"><br>

                    <label for="CP_e">Code Postal:</label><br>
                    <input type="text" id="CP_e" name="CP_e" value="<?php echo htmlspecialchars($row['CP_e']); ?>"><br>

                    <label for="ville_e">Ville:</label><br>
                    <input type="text" id="ville_e" name="ville_e" value="<?php echo htmlspecialchars($row['ville_e']); ?>"><br>

                    <label for="date_debut_s">Date de début:</label><br>
                    <input type="date" id="date_debut_s" name="date_debut_s" value="<?php echo htmlspecialchars($row['date_debut_s']); ?>"><br>

                    <label for="date_fin_s">Date de fin:</label><br>
                    <input type="date" id="date_fin_s" name="date_fin_s" value="<?php echo htmlspecialchars($row['date_fin_s']); ?>"><br>

                    <label for="duree_s">Durée du stage:</label><br>
                    <input type="text" id="duree_s" name="duree_s" value="<?php echo htmlspecialchars($row['duree_s']); ?>"><br><br>

                    <input type="submit" value="Modifier">
                </form>
            </body>
            </html>
<?php
        } else {
            echo "Aucune ligne correspondant à cet identifiant n'a été trouvée.";
        }

    } catch (PDOException $e) {
        echo "Erreur : " . htmlspecialchars($e->getMessage());
    }

} else {
    echo "Aucun identifiant de ligne n'a été fourni.";
}
?>
