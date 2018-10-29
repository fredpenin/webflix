<?php 
$currentPageTitle = 'Ajouter un film';
// On inclue le fichier header.php sur la page :
require_once(__DIR__ . '/partials/header.php'); 

//traitement du formulaire
$titleMov = $descripMov = $vidLinkMov = $coverMov = $releasedAtMov = $nameCat = null;

// le formulaire est soumis
if (!empty($_POST)) {
    $titleMov = $_POST['titleMov'];
    $descripMov = ($_POST['descripMov']);
    $vidLinkMov = $_POST['vidLinkMov'];
    $coverMov = $_FILES['coverMov']; // Tableau avec toutes les infos sur l'image uploadée
    $releasedAtMov = $_POST['releasedAtMov'];

    // Définir un tableau d'erreur vide qui va se remplir après chaque erreur
    $errors = [];
    // Vérifier le titre
    if (empty($titleMov)) {
        $errors['titleMov'] = 'Le titre n\'est pas valide';
    }
    // Vérifier la description
    if (empty($descripMov)) {
        $errors['descripMov'] = 'La description ne doit pas être vide';
    }
    // Si l'URL de la vidéo n'est pas valide
    if (!filter_var($vidLinkMov, FILTER_VALIDATE_URL)){
        $errors['vidLinkMov'] = 'L\'URL de la vidéo n\'est pas valide';
    }
    // Vérifier la jaquette
    if ($coverMov['error'] === 4) { // erreur 4 = "Aucun fichier n'a été téléchargé"
        $errors['coverMov'] = 'L\'image n\'est pas valide';
    }
    // Vérifier la date de sortie
    if (empty($releasedAtMov)) {
        $errors['releasedAtMov'] = 'La date de sortie n\'est pas valide';
    }
    // Vérifier la catégorie
    if (empty($nameCat)) {
        $errors['nameCat'] = 'La catégorie n\'est pas valide';
    }

    // Upload de l'image
    var_dump($coverMov);
    $file = $coverMov['tmp_name']; // Emplacement du fichier temporaire
    $fileName = 'img/jackets/'.$coverMov['name']; // Variable pour la base de données
    $finfo = finfo_open(FILEINFO_MIME_TYPE); // Permet d'ouvrir un fichier
    $mimeType = finfo_file($finfo, $file); // Ouvre le fichier et renvoie image/jpg
    $allowedExtensions = ['image/jpg', 'image/jpeg', 'image/gif', 'image/png'];
    // Si l'extension n'est pas autorisée, il y a une erreur
    if (!in_array($mimeType, $allowedExtensions)) {
        $errors['coverMov'] = 'Ce type de fichier n\'est pas autorisé';
    }
    // Vérifier la taille du fichier
    // Le 3000 est défini en Ko
    if ($coverMov['size'] / 1024 > 3000) {
        $errors['coverMov'] = 'L\image est trop lourde';
    }
    if (!isset($errors['coverMov'])) {
        move_uploaded_file($file, __DIR__.'/assets/'.$fileName); // On déplace le fichier uploadé où on le souhaite
    }
    // S'il n'y a pas d'erreurs dans le formulaire
    if (empty($errors)) {
        $query = $db->prepare('
            INSERT INTO movie (`title_mov`, `description_mov`, `video_link_mov`, `cover_mov`, `released_at_mov`) VALUES (:title, :description, :video_link, :cover, :released_at)
        ');
        $query->bindValue(':title_mov', $titleMov, PDO::PARAM_STR);
        $query->bindValue(':description_mov', $descripMov, PDO::PARAM_STR);
        $query->bindValue(':video_link_mov', $vidLinkMov, PDO::PARAM_STR);
        $query->bindValue(':cover_mov', $coverMov, PDO::PARAM_STR);
        $query->bindValue(':released_at_mov', $releasedAtMov, PDO::PARAM_STR);
        if ($query->execute()) { // On insère le film dans la BDD
            $success = true;
        }
    }
}
?>





    <main class="container">
        <h1>Ajout d'un film</h1>
            <!-- ////////// Formulaire /////////// -->
            <form method="POST" enctype="multipart/form-data">
                <div class="container">
                    <div class="row">
                        <!-- Titre -->
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="titleMov">Titre : </label>
                            <input type="text" name="titleMov" class="form-control <?php echo isset($errors['titleMov']) ? 'is-invalid' : null; ?>" id="titleMov" placeholder="Entrez le titre du film">
                        </div>
                        <!-- Date de sortie -->
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="releasedAtMov">Date de sortie : </label>
                            <input type="date" name="releasedAtMov" class="form-control <?php echo isset($errors['releasedAtMov']) ? 'is-invalid' : null; ?>" id="releasedAtMov" placeholder="Saisir la date de sortie du film">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Desciption -->
                        <div class="form-group col-sm-12">
                            <label for="descripMov">Description : </label>
                            <textarea class="form-control <?php echo isset($errors['descripMov']) ? 'is-invalid' : null; ?>" name="descripMov" id="descripMov" rows="5" placeholder="Saisir une description pour ce film"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Couveture -->
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="coverMov">Couverture : </label>
                            <input type="file" name="coverMov" class="form-control <?php echo isset($errors['coverMov']) ? 'is-invalid' : null; ?>" id="coverMov" placeholder="Choisir une jaquette">
                        </div>
                        <!-- URL de la vidéo -->
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="vidLinkMov">URL de la vidéo : </label>
                            <input type="text" name="vidLinkMov" class="form-control <?php echo isset($errors['vidLinkMov']) ? 'is-invalid' : null; ?>" id="vidLinkMov" placeholder="Saisir l'URL de la vidéo">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Catégorie -->
                        <label for="nameCat">Catégorie :</label>
                        <select name="nameCat" id="nameCat" class="form-control <?php echo isset($errors['nameCat']) ? 'is-invalid' : null; ?>">
                            <option value="">Choisir la catégorie</option>
                            <option <?php echo ($nameCat==='SF' ) ? 'selected' : '' ; ?> value="SF">SF</option>
                            <option <?php echo ($nameCat==='Thriller' ) ? 'selected' : '' ; ?> value="Thriller">Thriller</option>
                            <option <?php echo ($nameCat==='Comédie' ) ? 'selected' : '' ; ?> value="Comédie">Comédie</option>
                            <option <?php echo ($nameCat==='Autre' ) ? 'selected' : '' ; ?> value="Autre">Autre</option>
                            <option <?php echo ($nameCat==='drame' ) ? 'selected' : '' ; ?> value="drame">drame</option>
                            <option <?php echo ($nameCat==='action' ) ? 'selected' : '' ; ?> value="action">action</option>
                            <option <?php echo ($nameCat==='fantastique' ) ? 'selected' : '' ; ?> value="fantastique">fantastique</option>
                            <option <?php echo ($nameCat==='horreur' ) ? 'selected' : '' ; ?> value="horreur">horreur</option>
                        </select>
                    </div>

                    <button class="btn btn-lg btn-block btn-success text-uppercase font-weight-bold">Ajouter le film</button>
                </div>
            </form>



    </main>


    <?php 
// On inclue le fichier footer.php sur la page :
require_once(__DIR__ . '/partials/footer.php'); ?>