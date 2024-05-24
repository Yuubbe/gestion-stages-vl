<?php

$serveur = "127.0.0.1"; 
$utilisateur = "root"; 
$mot_de_passe = "root"; 
$base_de_donnees = "gestion_stages"; 

try {

    $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees;charset=utf8", $utilisateur, $mot_de_passe);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

$stmt = $dbh->prepare("INSERT INTO tbl_personne (password_p, nom_p, prenom_p, mail_p, roles_p) VALUES (:password_p, :nom_p, :prenom_p, :mail_p, 1)"); // Ajout de la valeur par défaut du rôle (1)

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$mail = $_POST['email'];
$mot_de_passe = $_POST['mdp'];

$mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

$stmt->bindParam(':password_p', $mot_de_passe_hash);
$stmt->bindParam(':nom_p', $nom);
$stmt->bindParam(':prenom_p', $prenom);
$stmt->bindParam(':mail_p', $mail);

try {

    $stmt->execute();
    echo "Création du compte réussie !";
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$dbh = null;

session_start();
$_SESSION['prenom'] = $prenom;

// Redirection vers la nouvelle page
header("Location: index.php");

?>
