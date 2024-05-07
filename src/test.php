<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage du rôle de l'utilisateur</title>
</head>
<body>
    <h1>Affichage du rôle de l'utilisateur</h1>

    <?php
    session_start();

    // Fonction pour vérifier si l'utilisateur est connecté
    function estConnecte() {
        return isset($_SESSION['utilisateur_connecte']) && $_SESSION['utilisateur_connecte'];
    }

    // Fonction pour déconnecter l'utilisateur
    function deconnexion() {
        session_destroy();
        // Rediriger l'utilisateur vers la page de connexion ou une autre page appropriée
        header("Location: login.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $serveur = "127.0.0.1";
        $base_de_donnees = "gestion_stages";
        $utilisateur = "root";
        $mot_de_passe = "root";

        try {
            $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Récupère l'adresse e-mail saisie dans le formulaire
            $mail = $_POST['email'];

            // Préparation de la requête pour récupérer le rôle de l'utilisateur
            $requete = $dbh->prepare("SELECT roles_p FROM tbl_personne WHERE mail_p = :mail");

            // Liaison des paramètres
            $requete->bindParam(':mail', $mail);

            // Exécution de la requête
            $requete->execute();

            // Récupération du résultat
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);

            // Affichage du rôle de l'utilisateur
            if ($resultat) {
                $role = "";
                switch ($resultat['roles_p']) {
                    case 1:
                        $role = "Utilisateur";
                        break;
                    case 2:
                        $role = "Tuteur ou Professeur";
                        break;
                    case 3:
                        $role = "Admin";
                        break;
                    case 4:
                        $role = "Superadmin";
                        break;
                    default:
                        $role = "Inconnu";
                        break;
                }
                echo "<p>Votre rôle : " . $role . "</p>";

                // Redirection en fonction du rôle
                if ($resultat['roles_p'] > 2) {
                    header("Location: _admin_index.php");
                    exit; 
                } else {
                    header("Location: index.php");
                    exit;
                }
            } else {
                echo "<p>Aucun utilisateur trouvé avec cette adresse e-mail.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Erreur : " . $e->getMessage() . "</p>";
        }
    }
    ?>

    <form method="post">
        <label for="email">Entrez votre adresse e-mail :</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <input type="submit" value="Vérifier le rôle">
    </form>

</body>
</html>
