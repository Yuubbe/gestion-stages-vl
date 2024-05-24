<?php
session_start();

$serveur = "127.0.0.1";
$utilisateur = "root";
$mot_de_passe = "root";
$base_de_donnees = "stages";

try {
    $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees;charset=utf8", $utilisateur, $mot_de_passe);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mail_prof']) && isset($_POST['mdp_prof'])) {
    $mail = $_POST['mail_prof'];
    $mot_de_passe = $_POST['mdp_prof'];

    $stmt = $dbh->prepare("SELECT * FROM prof WHERE mail_prof = :mail_prof");
    $stmt->bindParam(':mail_prof', $mail);

    try {
        $stmt->execute();
        $professeur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($professeur && password_verify($mot_de_passe, $professeur['mdp_prof'])) {
            // Connecte l'utilisateur
            $_SESSION['utilisateur_connecte'] = true;
            $_SESSION['prenom'] = $professeur['prenom_prof'];
            $_SESSION['role'] = $professeur['roles_p'];

            // Redirection vers la nouvelle page
            header("Location: _prof_index.php");
            exit;
        } else {
            echo "Email ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "Données requises non fournies.";
}

$dbh = null;
?>
