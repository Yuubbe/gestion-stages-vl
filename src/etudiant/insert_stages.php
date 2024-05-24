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

// Préparer la requête d'insertion dans la table validation_stage
$stmt = $dbh->prepare(
    "INSERT INTO validation_stage (classe_eleve, date_debut, date_fin, session, themes, commentaires) 
     VALUES (:classe_eleve, :date_debut, :date_fin, :session, :themes, :commentaires )"
);

// Récupérer les données du formulaire
$classe = $_POST['classe_eleve'];
$date_debut = $_POST['date_debut'];
$date_fin = $_POST['date_fin'];
$session = $_POST['session'];
$themes = $_POST['themes'];
$commentaires = $_POST['commentaires'];

// Lier les paramètres
$stmt->bindParam(':classe_eleve', $classe);
$stmt->bindParam(':date_debut', $date_debut);
$stmt->bindParam(':date_fin', $date_fin);
$stmt->bindParam(':session', $session);
$stmt->bindParam(':themes', $themes);
$stmt->bindParam(':commentaires', $commentaires);

// Exécution de la requête avec gestion des erreurs
try {
    $stmt->execute();
    echo "Insertion réussie dans la table validation_stage !";
} catch (PDOException $e) {
    echo "Erreur : " . htmlspecialchars($e->getMessage());
}

// Fermeture de la connexion
$dbh = null;

// Redirection vers une autre page
header("Location: /etudiant/stages.php");
exit;
