<!DOCTYPE html>
<html>
<head>
    <title>Page d'accueil</title>
</head>
<body>

<h2>Page d'accueil</h2>

<?php
session_start();

if(isset($_SESSION['prenom'])) {
    $prenom = $_SESSION['prenom'];

    echo "Bienvenue, $prenom!";
} else {

    echo '<a href="page_connexion.html">Se connecter</a>';
}
?>

</body>
</html>

