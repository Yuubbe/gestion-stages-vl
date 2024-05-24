<?php

$upload_dir = 'uploads/';


if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}


if ($_FILES['pdf-file']['error'] === UPLOAD_ERR_OK) {

    $file_name = $_FILES['pdf-file']['name'];
    $file_tmp = $_FILES['pdf-file']['tmp_name'];
    $file_path = $upload_dir . basename($file_name);


    if (move_uploaded_file($file_tmp, $file_path)) {
        echo "Fichier téléchargé avec succès : " . $file_name;
    } else {
        echo "Erreur lors du déplacement du fichier.";
    }
} else {
    echo "Erreur lors du téléchargement du fichier.";
}
?>
