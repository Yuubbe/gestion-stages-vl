<?php
session_start();

// Vérifie si la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère les données du formulaire
    $utilisateur_id = $_POST['utilisateur_id'];
    $nouveau_role = $_POST['nouveau_role'];

    // Connexion à la base de données (à adapter selon votre configuration)
    $serveur = "127.0.0.1";
    $base_de_donnees = "stages";
    $utilisateur = "root";
    $mot_de_passe = "root";

    try {
        $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees;charset=utf8", $utilisateur, $mot_de_passe);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prépare et exécute la requête SQL pour mettre à jour le rôle de l'utilisateur
        $stmt = $dbh->prepare("UPDATE tbl_personne SET roles_p = :nouveau_role WHERE id_p = :utilisateur_id");
        $stmt->bindParam(':nouveau_role', $nouveau_role);
        $stmt->bindParam(':utilisateur_id', $utilisateur_id);
        $stmt->execute();

        // Redirige vers la page précédente après la modification
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
