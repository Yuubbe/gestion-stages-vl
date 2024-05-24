<?php
session_start();

$serveur = "127.0.0.1"; 
$utilisateur = "root"; 
$mot_de_passe = "root"; 
$base_de_donnees = "stages"; 

try {
    $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees;charset=utf8", $utilisateur, $mot_de_passe);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mail_prof']) && isset($_POST['mdp_prof']) && isset($_POST['nom_prof']) && isset($_POST['prenom_prof'])) {
    $nom = $_POST['nom_prof'];
    $prenom = $_POST['prenom_prof'];
    $mail = $_POST['mail_prof'];
    $mot_de_passe = $_POST['mdp_prof'];

    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    $stmt = $dbh->prepare("INSERT INTO prof (nom_prof, prenom_prof, mail_prof, mdp_prof, roles_p) VALUES (:nom_prof, :prenom_prof, :mail_prof, :mdp_prof, 2)"); // Rôle 2 pour professeur

    $stmt->bindParam(':nom_prof', $nom);
    $stmt->bindParam(':prenom_prof', $prenom);
    $stmt->bindParam(':mail_prof', $mail);
    $stmt->bindParam(':mdp_prof', $mot_de_passe_hash);

    try {
        $stmt->execute();
        echo "Création du compte professeur réussie !";

        // Connecte l'utilisateur
        $_SESSION['utilisateur_connecte'] = true;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['role'] = 2; // Rôle de professeur

        // Redirection vers la nouvelle page
        header("Location: index.php");
        exit;
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Données requises non fournies.";
}

$dbh = null;
?>
