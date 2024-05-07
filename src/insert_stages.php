<?php

$serveur = "127.0.0.1";
$utilisateur = "root";
$mot_de_passe = "root";
$base_de_donnees = "gestion_stages";

// Connexion à la base de données avec gestion des erreurs
try {
    $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($e->getMessage()));
}

// Préparer la requête d'insertion
$stmt = $dbh->prepare(
    "INSERT INTO tbl_company (nom_e, rue_e, CP_e, ville_e, date_debut_s, date_fin_s, duree_s) 
     VALUES (:nom_e, :rue_e, :CP_e, :ville_e, :date_debut_s, :date_fin_s, :duree_s)"
);

// Récupérer les données du formulaire
$nom = $_POST['nom_e'];
$rue = $_POST['rue_e'];
$code_postal = $_POST['CP_e'];
$ville = $_POST['ville_e'];
$date_debut = $_POST['date_debut_s'];
$date_fin = $_POST['date_fin_s'];
$duree = $_POST['duree_s'];

// Lier les paramètres sans convention_chemin
$stmt->bindParam(':nom_e', $nom);
$stmt->bindParam(':rue_e', $rue);
$stmt->bindParam(':CP_e', $code_postal);
$stmt->bindParam(':ville_e', $ville);
$stmt->bindParam(':date_debut_s', $date_debut);
$stmt->bindParam(':date_fin_s', $date_fin);
$stmt->bindParam(':duree_s', $duree);

// Exécution de la requête avec gestion des erreurs
try {
    $stmt->execute();
    echo "Insertion réussie !";
} catch (PDOException $e) {
    echo "Erreur : " . htmlspecialchars($e->getMessage());
}

// Fermeture de la connexion
$dbh = null;

// Redirection vers une autre page
header("Location: stages.php");
exit;
