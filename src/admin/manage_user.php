<?php
session_start();

// Connexion à la base de données (à adapter selon votre configuration)
$serveur = "127.0.0.1";
$base_de_donnees = "stages";
$utilisateur = "root";
$mot_de_passe = "root";

try {
    $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees;charset=utf8", $utilisateur, $mot_de_passe);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $utilisateur_id = $_POST['utilisateur_id'];
        $action = $_POST['action'];

        if ($action === 'changer_role' && $_SESSION['role'] != 4) {
            $nouveau_role = $_POST['nouveau_role'];
            $stmt = $dbh->prepare("UPDATE eleve SET roles_p = :nouveau_role WHERE id_eleve = :utilisateur_id");
            $stmt->bindParam(':nouveau_role', $nouveau_role);
            $stmt->bindParam(':utilisateur_id', $utilisateur_id);
            $stmt->execute();
        } elseif ($action === 'modifier_mot_de_passe') {
            $nouveau_mot_de_passe = password_hash($_POST['nouveau_mot_de_passe'], PASSWORD_DEFAULT);
            $stmt = $dbh->prepare("UPDATE eleve SET mdp = :nouveau_mot_de_passe WHERE id_eleve = :utilisateur_id");
            $stmt->bindParam(':nouveau_mot_de_passe', $nouveau_mot_de_passe);
            $stmt->bindParam(':utilisateur_id', $utilisateur_id);
            $stmt->execute();
        } elseif ($action === 'supprimer_utilisateur' && $_SESSION['role'] != 4) {
            $stmt = $dbh->prepare("DELETE FROM eleve WHERE id_eleve = :utilisateur_id");
            $stmt->bindParam(':utilisateur_id', $utilisateur_id);
            $stmt->execute();
        }
    }

    $search_query = '';
    if (isset($_GET['search'])) {
        $search_query = $_GET['search'];
        $stmt = $dbh->prepare("SELECT * FROM eleve WHERE nom_eleve LIKE :search OR prenom_eleve LIKE :search OR mail_eleve LIKE :search");
        $stmt->execute([':search' => '%' . $search_query . '%']);
    } else {
        $stmt = $dbh->prepare("SELECT * FROM eleve");
        $stmt->execute();
    }
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
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

<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="text" name="search" placeholder="Rechercher par nom ou email" value="<?php echo htmlspecialchars($search_query); ?>">
    <input type="submit" value="Rechercher">
</form>

<table>
    <tr>
        <th>Nom</th>
        <th>Email</th>
        <th>Rôle</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($utilisateurs as $utilisateur) { ?>
        <tr>
            <td><?php echo htmlspecialchars($utilisateur['nom_eleve'] . ' ' . $utilisateur['prenom_eleve']); ?></td>
            <td><?php echo htmlspecialchars($utilisateur['mail_eleve']); ?></td>
            <td><?php echo htmlspecialchars($utilisateur['roles_p']); ?></td>
            <td>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="utilisateur_id" value="<?php echo $utilisateur['id_eleve']; ?>">
                    <input type="hidden" name="action" value="changer_role">
                    <input type="radio" name="nouveau_role" value="1"> Utilisateur
                    <input type="radio" name="nouveau_role" value="2"> Tuteur ou Professeur
                    <input type="radio" name="nouveau_role" value="3" <?php echo ($_SESSION['role'] == 4 ? '' : 'enabled'); ?>> Admin
                    <input type="radio" name="nouveau_role" value="4" <?php echo ($_SESSION['role'] == 4 ? '' : 'disabled'); ?>> Superadmin
                    <input type="submit" value="Modifier rôle">
                </form>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="utilisateur_id" value="<?php echo $utilisateur['id_eleve']; ?>">
                    <input type="hidden" name="action" value="modifier_mot_de_passe">
                    Nouveau mot de passe: <input type="password" name="nouveau_mot_de_passe">
                    <input type="submit" value="Modifier mot de passe">
                </form>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="utilisateur_id" value="<?php echo $utilisateur['id_eleve']; ?>">
                    <input type="hidden" name="action" value="supprimer_utilisateur">
                    <input type="submit" value="Supprimer utilisateur">
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
