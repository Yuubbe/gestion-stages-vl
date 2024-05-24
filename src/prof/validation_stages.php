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

    // Récupère les données de la table validation_stage
    $stmt = $dbh->prepare("SELECT * FROM validation_stage");
    $stmt->execute();
    $stages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

// Fonction pour valider un stage
function validerStage($dbh, $id_stage)
{
    try {
        // Récupère les données du stage à valider
        $stmt_select = $dbh->prepare("SELECT * FROM validation_stage WHERE id_stage = :id");
        $stmt_select->bindParam(':id', $id_stage);
        $stmt_select->execute();
        $stage_data = $stmt_select->fetch(PDO::FETCH_ASSOC);

        // Insère les données du stage dans la table stage
        $stmt_insert = $dbh->prepare("INSERT INTO stage (classe_eleve, date_debut, date_fin, session, themes, commentaires) VALUES (:classe, :debut, :fin, :session, :themes, :commentaires)");
        $stmt_insert->bindParam(':classe', $stage_data['classe_eleve']);
        $stmt_insert->bindParam(':debut', $stage_data['date_debut']);
        $stmt_insert->bindParam(':fin', $stage_data['date_fin']);
        $stmt_insert->bindParam(':session', $stage_data['session']);
        $stmt_insert->bindParam(':themes', $stage_data['themes']);
        $stmt_insert->bindParam(':commentaires', $stage_data['commentaires']);
        $stmt_insert->execute();

        // Supprime la ligne correspondante dans la table validation_stage
        $stmt_delete = $dbh->prepare("DELETE FROM validation_stage WHERE id_stage = :id");
        $stmt_delete->bindParam(':id', $id_stage);
        $stmt_delete->execute();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

// Fonction pour refuser un stage
function refuserStage($dbh, $id_stage)
{
    try {
        // Supprime la ligne correspondante dans la table validation_stage
        $stmt_delete = $dbh->prepare("DELETE FROM validation_stage WHERE id_stage = :id");
        $stmt_delete->bindParam(':id', $id_stage);
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
    <title>Liste des Stages - Gestion Stage</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Ajoute tes autres liens CSS et scripts ici -->
    <style>
    /* Style pour le corps */
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }

    /* Style pour le titre */
    h1 {
        text-align: center;
        margin-top: 20px;
    }

    /* Style pour la table */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #343a40;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    /* Style pour les boutons */
    .btn {
        padding: 6px 12px;
        margin: 5px;
        cursor: pointer;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    /* Style pour le pied de page */
    .footer-clean {
        padding: 50px 0;
        color: #fff;
        background-color: #343a40;
    }

    .footer-clean h3 {
        margin-top: 0;
        margin-bottom: 12px;
        font-weight: bold;
        font-size: 16px;
    }

    .footer-clean ul {
        padding: 0;
        list-style: none;
        line-height: 1.6;
        margin-bottom: 0;
    }

    .footer-clean ul a {
        color: inherit;
        text-decoration: none;
        opacity: 0.6;
    }

    .footer-clean ul a:hover {
        opacity: 0.8;
    }

    .footer-clean .item.social {
        text-align: right;
    }

    .footer-clean .item.social > a {
        font-size: 24px;
        width: 40px;
        height: 40px;
        line-height: 40px;
        display: inline-block;
        text-align: center;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.4);
        margin-left: 10px;
        color: #fff;
        opacity: 0.75;
    }

    .footer-clean .item.social > a:hover {
        opacity: 0.9;
    }

    .footer-clean .item.social > ion-icon {
        margin-left: 10px;
        font-size: 24px;
    }

    .footer-clean .item.social > ion-icon:hover {
        opacity: 0.9;
    }

    .footer-clean .item > p {
        opacity: 0.6;
        margin-bottom: 0;
    }

    .footer-clean .item > p.terms {
        font-size: 13px;
        margin-top: 2px;
    }

    .footer-clean .item > p.terms > a {
        color: #fff;
        font-weight: bold;
    }

    .footer-clean .item > p.terms > a:hover {
        color: #222;
    }

    .footer-clean .item > p.terms > a:before {
        content: "(";
    }

    .footer-clean .item > p.terms > a:after {
        content: ")";
    }

    .footer-clean .item > p.terms > a:before,
    .footer-clean .item > p.terms > a:after {
        content: '';
        display: inline-block;
        width: 0;
    }

    /* Style pour le bouton de déconnexion */
    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
        margin-left: 10px;
    }

    .btn-outline-danger:hover {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }

    /* Style pour le bouton de connexion */
    .btn-outline-info {
        color: #007bff;
        border-color: #007bff;
    }

    .btn-outline-info:hover {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    /* Style pour le bouton d'inscription */
    .btn-outline-success {
        color: #28a745;
        border-color: #28a745;
    }

    .btn-outline-success:hover {
        color: #fff;
        background-color: #28a745;
        border-color: #28a745;
    }

    /* Style pour le formulaire */
    form {
        display: inline;
    }
</style>

</head>

<body>

    <h1>Validation des stages </h1>

    <!-- Tableau avec données -->
    <table border="1">
        <tr>
            <th>Classe de l'élève</th>
            <th>Date de début</th>
            <th>Date de fin </th>
            <th>Session</th>
            <th>Thèmes</th>
            <th>Commentaires</th>
            <th>Action</th>
        </tr>
        <?php foreach ($stages as $stage) : ?>
            <tr>
                <td><?= $stage['classe_eleve'] ?></td>
                <td><?= $stage['date_debut'] ?></td>
                <td><?= $stage['date_fin'] ?></td>
                <td><?= $stage['session'] ?></td>
                <td><?= $stage['themes'] ?></td>
                <td><?= $stage['commentaires'] ?></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="id_stage" value="<?= $stage['id_stage'] ?>">
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
        $id_stage = $_POST['id_stage'];
        validerStage($dbh, $id_stage);
        header("Location: nom_de_ce_fichier.php"); // Redirige vers cette page pour actualiser la liste après traitement
        exit();
    }

    if (isset($_POST['refuser'])) {
        $id_stage = $_POST['id_stage'];
        refuserStage($dbh, $id_stage);
        header("Location: nom_de_ce_fichier.php"); // Redirige vers cette page pour actualiser la liste après traitement
        exit();
    }
    ?>

</body>

</html>
