<?php
session_start();

// Vérifie si l'utilisateur est connecté


// Connexion à la base de données
$serveur = "127.0.0.1";
$utilisateur = "root";
$mot_de_passe = "root";
$base_de_donnees = "stages";

try {
    $dbh = new PDO("mysql:host=$serveur;dbname=$base_de_donnees;charset=utf8", $utilisateur, $mot_de_passe);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupère les données de la table validation_entreprise
    $stmt = $dbh->prepare("SELECT * FROM validation_entreprise");
    $stmt->execute();
    $entreprises = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

// Fonction pour valider une entreprise
function validerEntreprise($dbh, $id_entreprise)
{
    try {
        // Récupère les données de l'entreprise à valider
        $stmt_select = $dbh->prepare("SELECT * FROM validation_entreprise WHERE id_entreprise = :id");
        $stmt_select->bindParam(':id', $id_entreprise);
        $stmt_select->execute();
        $entreprise_data = $stmt_select->fetch(PDO::FETCH_ASSOC);

        // Insère les données de l'entreprise dans la table entreprise
        $stmt_insert = $dbh->prepare("INSERT INTO entreprise (nom_entreprise, rue_entreprise, cp_entreprise, ville_entreprise, pays_entreprise, tel_entreprise, fax_entreprise, email_entreprise) VALUES (:nom, :rue, :cp, :ville, :pays, :tel, :fax, :email)");
        $stmt_insert->bindParam(':nom', $entreprise_data['nom_entreprise']);
        $stmt_insert->bindParam(':rue', $entreprise_data['rue_entreprise']);
        $stmt_insert->bindParam(':cp', $entreprise_data['cp_entreprise']);
        $stmt_insert->bindParam(':ville', $entreprise_data['ville_entreprise']);
        $stmt_insert->bindParam(':pays', $entreprise_data['pays_entreprise']);
        $stmt_insert->bindParam(':tel', $entreprise_data['tel_entreprise']);
        $stmt_insert->bindParam(':fax', $entreprise_data['fax_entreprise']);
        $stmt_insert->bindParam(':email', $entreprise_data['email_entreprise']);
        $stmt_insert->execute();

        // Supprime la ligne correspondante dans la table validation_entreprise
        $stmt_delete = $dbh->prepare("DELETE FROM validation_entreprise WHERE id_entreprise = :id");
        $stmt_delete->bindParam(':id', $id_entreprise);
        $stmt_delete->execute();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

// Fonction pour refuser une entreprise
function refuserEntreprise($dbh, $id_entreprise)
{
    try {
        // Supprime la ligne correspondante dans la table validation_entreprise
        $stmt_delete = $dbh->prepare("DELETE FROM validation_entreprise WHERE id_entreprise = :id");
        $stmt_delete->bindParam(':id', $id_entreprise);
        $stmt_delete->execute();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entreprises en attente de validation - Gestion Stage</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Ajoute tes autres liens CSS et scripts ici -->
    <style>
    /* Ajoute ton style CSS ici */
    </style>
</head>

<body>

    <h1>Entreprises en attente de validation</h1>

    <!-- Tableau avec données -->
    <table border="1">
        <tr>
            <th>Nom de l'entreprise</th>
            <th>Rue</th>
            <th>Code Postal</th>
            <th>Ville</th>
            <th>Pays</th>
            <th>Téléphone</th>
            <th>Fax</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php foreach ($entreprises as $entreprise) : ?>
            <tr>
                <td><?= $entreprise['nom_entreprise'] ?></td>
                <td><?= $entreprise['rue_entreprise'] ?></td>
                <td><?= $entreprise['cp_entreprise'] ?></td>
                <td><?= $entreprise['ville_entreprise'] ?></td>
                <td><?= $entreprise['pays_entreprise'] ?></td>
                <td><?= $entreprise['tel_entreprise'] ?></td>
                <td><?= $entreprise['fax_entreprise'] ?></td>
                <td><?= $entreprise['email_entreprise'] ?></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="id_entreprise" value="<?= $entreprise['id_entreprise'] ?>">
                        <button type="submit" name="valider" class="btn btn-success">Valider</button>
                        <button type="submit" name="refuser" class="btn btn-danger">Refuser</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php
    // Traitement de l'action Valider ou Refuser
    if (isset($_POST['valider'])) {
        $id_entreprise = $_POST['id_entreprise'];
        validerEntreprise($dbh, $id_entreprise);
        header("Location: validation_entreprises.php"); // Redirige vers cette page pour actualiser la liste après traitement
        exit();
    }

    if (isset($_POST['refuser'])) {
        $id_entreprise = $_POST['id_entreprise'];
        refuserEntreprise($dbh, $id_entreprise);
        header("Location: validation_entreprises.php"); // Redirige vers cette page pour actualiser la liste après traitement
        exit();
    }
    ?>

</body>

</html>
