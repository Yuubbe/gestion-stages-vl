<?php

$serveur = "127.0.0.1";
$utilisateur = "root";
$mot_de_passe = "root";
$base_de_donnees = "stages";

// Connexion à la base de données avec gestion des erreurs
try {
    $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees;charset=utf8", $utilisateur, $mot_de_passe);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($e->getMessage()));
}

// Préparer la requête d'insertion dans la table validation_entreprise
$stmt = $dbh->prepare(
    "INSERT INTO validation_entreprise (nom_entreprise, rue_entreprise, cp_entreprise, ville_entreprise, pays_entreprise, tel_entreprise, fax_entreprise, email_entreprise) 
     VALUES (:nom_entreprise, :rue_entreprise, :cp_entreprise, :ville_entreprise, :pays_entreprise, :tel_entreprise, :fax_entreprise, :email_entreprise)"
);

// Récupérer les données du formulaire
$nom_entreprise = $_POST['nom_entreprise'];
$rue_entreprise = $_POST['rue_entreprise'];
$cp_entreprise = $_POST['cp_entreprise'];
$ville_entreprise = $_POST['ville_entreprise'];
$pays_entreprise = $_POST['pays_entreprise'];
$tel_entreprise = $_POST['tel_entreprise'];
$fax_entreprise = $_POST['fax_entreprise'];
$email_entreprise = $_POST['email_entreprise'];

// Lier les paramètres
$stmt->bindParam(':nom_entreprise', $nom_entreprise);
$stmt->bindParam(':rue_entreprise', $rue_entreprise);
$stmt->bindParam(':cp_entreprise', $cp_entreprise);
$stmt->bindParam(':ville_entreprise', $ville_entreprise);
$stmt->bindParam(':pays_entreprise', $pays_entreprise);
$stmt->bindParam(':tel_entreprise', $tel_entreprise);
$stmt->bindParam(':fax_entreprise', $fax_entreprise);
$stmt->bindParam(':email_entreprise', $email_entreprise);

// Exécution de la requête avec gestion des erreurs
try {
    $stmt->execute();
    echo "Insertion réussie dans la table validation_entreprise !";
} catch (PDOException $e) {
    echo "Erreur : " . htmlspecialchars($e->getMessage());
}

// Fermeture de la connexion
$dbh = null;

// Redirection vers une autre page
header("Location: /etudiant/entreprises.php");
exit;
