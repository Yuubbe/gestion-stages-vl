<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier que tous les champs nécessaires sont présents
    if (
        isset($_POST['id_e']) &&
        isset($_POST['nom_e']) &&
        isset($_POST['rue_e']) &&
        isset($_POST['CP_e']) &&
        isset($_POST['ville_e']) &&
        isset($_POST['date_debut_s']) &&
        isset($_POST['date_fin_s']) &&
        isset($_POST['duree_s'])
    ) {
        // Récupérer les données du formulaire
        $id = $_POST['id_e'];
        $nom_e = $_POST['nom_e'];
        $rue_e = $_POST['rue_e'];
        $CP_e = $_POST['CP_e'];
        $ville_e = $_POST['ville_e'];
        $date_debut_s = $_POST['date_debut_s'];
        $date_fin_s = $_POST['date_fin_s'];
        $duree_s = $_POST['duree_s'];

        $serveur = "127.0.0.1";
        $utilisateur = "root";
        $mot_de_passe = "root";
        $base_de_donnees = "gestion_stages";

        try {
            // Connexion à la base de données
            $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête de mise à jour avec toutes les nouvelles colonnes
            $stmt = $dbh->prepare("UPDATE tbl_company 
                                   SET nom_e = :nom_e, rue_e = :rue_e, CP_e = :CP_e, ville_e = :ville_e, 
                                       date_debut_s = :date_debut_s, date_fin_s = :date_fin_s, duree_s = :duree_s 
                                   WHERE id_e = :id_e");

            // Lier les paramètres
            $stmt->bindParam(':nom_e', $nom_e);
            $stmt->bindParam(':rue_e', $rue_e);
            $stmt->bindParam(':CP_e', $CP_e);
            $stmt->bindParam(':ville_e', $ville_e);
            $stmt->bindParam(':date_debut_s', $date_debut_s);
            $stmt->bindParam(':date_fin_s', $date_fin_s);
            $stmt->bindParam(':duree_s', $duree_s);
            $stmt->bindParam(':id_e', $id);

            // Exécution de la requête de mise à jour
            $stmt->execute();

            // Redirection après mise à jour réussie
            header("Location: stages.php");
            exit();
        } catch (PDOException $e) {
            echo "Erreur : " . htmlspecialchars($e->getMessage());
        }

        // Fermer la connexion à la base de données
        $dbh = null;
    } else {
        echo "Tous les champs du formulaire doivent être remplis.";
    }
} else {
    echo "Le formulaire n'a pas été soumis.";
}
?>
