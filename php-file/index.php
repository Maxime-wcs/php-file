<?php

if (!empty($_FILES['fichier']['name']) && count($_FILES['fichier']['name']) > 0) {

    // boucle pour tester les images
    for ($i = 0; $i < count($_FILES['fichier']['name']); $i++) {

        //fichier temporaire
        $tmpFilePath = $_FILES['fichier']['tmp_name'][$i];

        // vérifier la taille du fichier ---------------------------------------
        if ($_FILES['fichier']['size'][$i]> 1000000) {
            echo 'La taille du fichier doit être inférieur à 1 MO. ';
            break;
        }

        // vérifier l'extension ------------------------------------------------
        $extensionAutorisees = ['jpg', 'png', 'gif']; // tableau des extensions autorisées
        // Récupérer l'extension du fichier
        $extensionFichier = strtolower(pathinfo($_FILES['fichier']['name'][$i], PATHINFO_EXTENSION));
        // Vérifier si le format correspond à une valeur du tableau
        if (!in_array($extensionFichier, $extensionAutorisees)) {
            echo 'Les formats jpg, gif et png sont autorisés';
            break;
        }

        // renommer les images avec un identifiant unique ------------------------
        $idUnique = uniqid();
        $nomImage = 'image' . $idUnique . '.' . $extensionFichier;

        // transférer les images -------------------------------------------------
        $transfere =  'repertoire/' . $nomImage;
        // transférer le fichier dans le répertoire
        move_uploaded_file($tmpFilePath, $transfere);
        $files[] = $nomImage;
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php

// stocker les images dans répertoire
$repertoiresImages = scandir ( "repertoire");
// rechercher fichier qui commence par 'image'
$images = preg_grep("/image/", $repertoiresImages);




?>

<div class="container">
<form action="" enctype="multipart/form-data" method="post">
    <div>
        <label for='fichier'>Ajouter un fichier</label>
        <input id='fichier' name="fichier[]" type="file" multiple="multiple" /><br>
    </div>

    <p><input type="submit" name="submit" value="Envoyer"></p>
</form>

<p style="margin-bottom: 40px"> Actualiser la page si l'image ne s'affiche pas immédiatement</p>


<div class="row">
    <?php foreach ($images as $file) : ?>

        <div class="col-md-4">
            <div class="card">
                <div class="card-image">
                    <img src="repertoire/<?= $file; ?>" style="height: 200px; width: 200px" alt="image">
                </div>
                <div class="card-card-content">
                    <p><?= $file; ?></p>
                </div>
                <div class="card-action">
                    <a href="delete.php?id=<?= $file;?>" class="btn btn-warning" role="button">Supprimer</a>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
</div>
</div>

</body>
</html>

