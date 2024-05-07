<?php
require 'vendor/autoload.php'; // Assurez-vous que PHPMailer est installé via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objet = trim($_POST['objet']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $texte = trim($_POST['texte']);

    if ($email === false) {
        die("Adresse e-mail invalide.");
    }

    // Créez une nouvelle instance de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuration de PHPMailer pour utiliser SMTP
        $mail->isSMTP();
        $mail->Host = 'mail.infomaniak.com'; // Remplacez par le serveur SMTP approprié
        $mail->SMTPAuth = true;
        $mail->Username = 'gamblinvincent@ik.me'; // Votre nom d'utilisateur SMTP
        $mail->Password = '$Vincent0510'; // Votre mot de passe SMTP
        $mail->SMTPSecure = 'tls'; // Utilisez 'tls' ou 'ssl'
        $mail->Port = 587; // Le port SMTP (587 pour TLS, 465 pour SSL)

        // Paramètres de l'e-mail
        $mail->setFrom('gamblinvincent@ik.me', 'Gestion Stage'); // Adresse de l'expéditeur
        $mail->addAddress($email); // Destinataire
        $mail->Subject = $objet; // Sujet de l'e-mail
        $mail->Body = "Rapport :\n\n" . $texte; // Contenu du rapport

        // Envoyer l'e-mail
        $mail->send();
        echo "Rapport envoyé avec succès à $email.";
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'e-mail : " . $mail->ErrorInfo;
    }
} else {
    echo "Méthode de requête non autorisée.";
}
