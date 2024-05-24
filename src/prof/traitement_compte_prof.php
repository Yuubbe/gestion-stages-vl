<?php
// Connexion à la base de données
$serveur = "127.0.0.1";
$utilisateur = "root";
$mot_de_passe = "root";
$base_de_donnees = "stages";

try {
    $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees;charset=utf8", $utilisateur, $mot_de_passe);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($e->getMessage()));
}

// Récupérer les données du formulaire
$nom_prof = $_POST['nom_prof'];
$prenom_prof = $_POST['prenom_prof'];
$email_prof = $_POST['email_prof'];
$mdp_prof = password_hash($_POST['mdp_prof'], PASSWORD_DEFAULT);

// Préparer la requête d'insertion dans la table prof
$stmt = $dbh->prepare(
    "INSERT INTO prof (nom_prof, prenom_prof, email_prof, mdp_prof, roles_p) 
     VALUES (:nom_prof, :prenom_prof, :email_prof, :mdp_prof, 2)"
);

// Lier les paramètres
$stmt->bindParam(':nom_prof', $nom_prof);
$stmt->bindParam(':prenom_prof', $prenom_prof);
$stmt->bindParam(':email_prof', $email_prof);
$stmt->bindParam(':mdp_prof', $mdp_prof);

// Exécution de la requête avec gestion des erreurs
try {
    $stmt->execute();
    echo "Le compte professeur a été créé avec succès !";
} catch (PDOException $e) {
    echo "Erreur : " . htmlspecialchars($e->getMessage());
}

// Fermeture de la connexion
$dbh = null;
?>
