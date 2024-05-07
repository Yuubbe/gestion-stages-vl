<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serveur = "127.0.0.1";
    $base_de_donnees = "gestion_stages";
    $utilisateur = "root";
    $mot_de_passe = "root";

    try {

        $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

        // Vérifie si l'utilisateur existe déjà dans la base de données
        $stmt = $dbh->prepare("SELECT * FROM tbl_personne WHERE mail_p = :mail_p");

        $mail = $_POST['email'];

        $stmt->bindParam(':mail_p', $mail);

        $stmt->execute();
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($_POST['mdp'], $row['password_p'])) {
                // Si l'utilisateur existe et le mot de passe est correct, connecte l'utilisateur
                $_SESSION['utilisateur_connecte'] = true;
                $_SESSION['prenom'] = $row['prenom_p'];
                $_SESSION['role'] = $row['roles_p'];
                header("Location: index.php");
                exit;
            } else {
                // Si le mot de passe est incorrect, redirige vers la page de connexion
                header("Location: index.php");
                exit;
            }
        } else {
            // Si l'utilisateur n'existe pas, crée un compte par défaut avec un rôle de 1 (utilisateur)
            $stmt = $dbh->prepare("INSERT INTO tbl_personne (mail_p, password_p, roles_p) VALUES (:mail_p, :password_p, 1)");

            $mail = $_POST['email'];
            $password_hash = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

            $stmt->bindParam(':mail_p', $mail);
            $stmt->bindParam(':password_p', $password_hash);

            $stmt->execute();

            // Connecte l'utilisateur
            $_SESSION['utilisateur_connecte'] = true;
            $_SESSION['prenom'] = ""; // Si le prénom est vide pour le nouvel utilisateur, laissez-le vide ou définissez une valeur par défaut

            header("Location: index.php");
            exit;
        }
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
