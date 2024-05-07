<?php
session_start();

// Connexion à la base de données (à adapter selon votre configuration)
$serveur = "127.0.0.1";
$base_de_donnees = "gestion_stages";
$utilisateur = "root";
$mot_de_passe = "root";

try {
    $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $utilisateur_id = $_POST['utilisateur_id'];
        $action = $_POST['action'];


        if ($action === 'changer_role' && $_SESSION['role'] != 4) {
            
            $nouveau_role = $_POST['nouveau_role'];

            
            $stmt = $dbh->prepare("UPDATE tbl_personne SET roles_p = :nouveau_role WHERE id_p = :utilisateur_id");
            $stmt->bindParam(':nouveau_role', $nouveau_role);
            $stmt->bindParam(':utilisateur_id', $utilisateur_id);
            $stmt->execute();
        } elseif ($action === 'modifier_mot_de_passe') {
            
            $nouveau_mot_de_passe = password_hash($_POST['nouveau_mot_de_passe'], PASSWORD_DEFAULT);

            
            $stmt = $dbh->prepare("UPDATE tbl_personne SET password_p = :nouveau_mot_de_passe WHERE id_p = :utilisateur_id");
            $stmt->bindParam(':nouveau_mot_de_passe', $nouveau_mot_de_passe);
            $stmt->bindParam(':utilisateur_id', $utilisateur_id);
            $stmt->execute();
        } elseif ($action === 'supprimer_utilisateur' && $_SESSION['role'] != 4) {
            
        }
    }

    $stmt = $dbh->prepare("SELECT * FROM tbl_personne");
    $stmt->execute();
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .user-info {
            float: right;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="user-info">
    <?php if(isset($_SESSION['user'])): ?>
        Connecté en tant que: <?php echo $_SESSION['roles_p']; ?>
    <?php else: ?>
        Non connecté
    <?php endif; ?>
</div>

<h2>Liste des utilisateurs</h2>

<table>
    <tr>
        
        <th>Nom</th>
        <th>Email</th>
        <th>Mot de passe</th>
        <th>Rôle</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($utilisateurs as $utilisateur) { ?>
        <tr>
            
            <td><?php echo $utilisateur['nom_p']; ?></td>
            <td><?php echo $utilisateur['mail_p']; ?></td>
            <td><?php echo $utilisateur['password_p']; ?></td>
            <td><?php echo $utilisateur['roles_p']; ?></td>
            <td>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="utilisateur_id" value="<?php echo $utilisateur['id_p']; ?>">
                    <input type="hidden" name="action" value="changer_role">
                    <input type="radio" name="nouveau_role" value="1"> Utilisateur
                    <input type="radio" name="nouveau_role" value="2"> Tuteur ou Professeur
                    <input type="radio" name="nouveau_role" value="3" <?php echo ($_SESSION['role'] == 4 ? '' : 'enabled'); ?>> Admin
                    <input type="radio" name="nouveau_role" value="4" <?php echo ($_SESSION['role'] == 4 ? '' : 'disabled'); ?>> Superadmin
                    <input type="submit" value="Modifier rôle">
                </form>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="utilisateur_id" value="<?php echo $utilisateur['id_p']; ?>">
                    <input type="hidden" name="action" value="modifier_mot_de_passe">
                    Nouveau mot de passe: <input type="password" name="nouveau_mot_de_passe">
                    <input type="submit" value="Modifier mot de passe">
                </form>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="utilisateur_id" value="<?php echo $utilisateur['id_p']; ?>">
                    <input type="hidden" name="action" value="supprimer_utilisateur" <?php echo ($_SESSION['role'] == 3 ? 'enabled' : ''); ?>>
                    <input type="submit" value="Supprimer utilisateur" <?php echo ($_SESSION['role'] == 3 ? 'enabled' : ''); ?>>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
