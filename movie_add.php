<?php 
$currentPageTitle = 'Ajouter un film';
// On inclue le fichier header.php sur la page :
require_once(__DIR__ . '/partials/header.php'); 

//traitement du formulaire
$titleMov = $descripMov = $vidLinkMov = $coverMov = $releasedAtMov = $idCat = null;

// le formulaire est soumis
if (!empty($_POST)) {
    $titleMov = $_POST['titleMov'];
    $descripMov = ($_POST['descripMov']);
    $vidLinkMov = $_POST['vidLinkMov'];
    $coverMov = $_FILES['coverMov']; // Tableau avec toutes les infos sur l'image uploadée
    $releasedAtMov = $_POST['releasedAtMov'];
    $idCat = $_POST['idCat'];
    //$nameCat = $_POST['nameCat'];

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
    if (empty($idCat) || !in_array($idCat, ['1', '2', '3', '4', '5', '6', '7', '8'])) {
        $errors['idCat'] = 'La catégorie n\'est pas valide';
    }

    // Upload de l'image
    //var_dump($coverMov);
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
            INSERT INTO movie (`title_mov`, `description_mov`, `video_link_mov`, `cover_mov`, `released_at_mov`, `id_cat`) VALUES (:title, :description, :video_link, :cover, :released_at, :id_cat)
        ');
        $query->bindValue(':title', $titleMov, PDO::PARAM_STR);
        $query->bindValue(':description', $descripMov, PDO::PARAM_STR);
        $query->bindValue(':video_link', $vidLinkMov, PDO::PARAM_STR);
        $query->bindValue(':cover', $fileName, PDO::PARAM_STR);
        $query->bindValue(':released_at', $releasedAtMov, PDO::PARAM_STR);
        $query->bindValue(':id_cat', $idCat, PDO::PARAM_INT);

        if ($query->execute()) { // On insère le film dans la BDD
            $success = true;
        }
    }
}
?>



    <main class="container">
        <h1>Ajout d'un film</h1>

        <?php if (isset($success) && $success) { ?>
        <div class="alert alert-success alert-dismissible fade show">
            Le film <strong>
                <?php echo $titleMov; ?></strong> a bien été ajouté avec l'id <strong>
                <?php echo $db->lastInsertId(); ?></strong> !
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php } ?>

        <!-- ////////// Formulaire /////////// -->
        <form method="POST" enctype="multipart/form-data">
            <div class="container">
                <div class="row">
                    <!-- Titre -->
                    <div class="form-group col-sm-12 col-md-6">
                        <label for="titleMov">Titre : </label>
                        <input type="text" name="titleMov" class="form-control <?php echo isset($errors['titleMov']) ? 'is-invalid' : null; ?>" 
                                id="titleMov" placeholder="Entrez le titre du film" value="<?php echo $titleMov; ?>">
                        <?php if (isset($errors['titleMov'])) {
                            echo '<div class="invalid-feedback">';
                            echo $errors['titleMov'];
                            echo '</div>';
                        } ?>
                    </div>
                    <!-- Date de sortie -->
                    <div class="form-group col-sm-12 col-md-6">
                        <label for="releasedAtMov">Date de sortie : </label>
                        <input type="date" name="releasedAtMov" class="form-control <?php echo isset($errors['releasedAtMov']) ? 'is-invalid' : null; ?>" 
                                id="releasedAtMov" placeholder="Saisir la date de sortie du film" value="<?php echo $releasedAtMov; ?>">
                        <?php if (isset($errors['releasedAtMov'])) {
                            echo '<div class="invalid-feedback">';
                            echo $errors['releasedAtMov'];
                            echo '</div>';
                        } ?>                    
                    </div>
                </div>

                <div class="row">
                    <!-- Desciption -->
                    <div class="form-group col-sm-12">
                        <label for="descripMov">Description : </label>
                        <textarea class="form-control <?php echo isset($errors['descripMov']) ? 'is-invalid' : null; ?>" name="descripMov" id="descripMov" 
                                rows="5" placeholder="Saisir une description pour ce film" value="<?php echo $descripMov; ?>"></textarea>
                        <?php if (isset($errors['descripMov'])) {
                            echo '<div class="invalid-feedback">';
                            echo $errors['descripMov'];
                            echo '</div>';
                        } ?>                     
                    </div>
                </div>

                <div class="row">
                    <!-- Couveture -->
                    <div class="form-group col-sm-12 col-md-6">
                        <label for="coverMov">Couverture : </label>
                        <input type="file" name="coverMov" class="form-control <?php echo isset($errors['coverMov']) ? 'is-invalid' : null; ?>" id="coverMov" 
                                placeholder="Choisir une jaquette">
                        <?php if (isset($errors['coverMov'])) {
                            echo '<div class="invalid-feedback">';
                            echo $errors['coverMov'];
                            echo '</div>';
                        } ?>                          
                    </div>
                    <!-- URL de la vidéo -->
                    <div class="form-group col-sm-12 col-md-6">
                        <label for="vidLinkMov">URL de la vidéo : </label>
                        <input type="text" name="vidLinkMov" class="form-control <?php echo isset($errors['vidLinkMov']) ? 'is-invalid' : null; ?>" 
                                id="vidLinkMov" placeholder="Saisir l'URL de la vidéo" value="<?php echo $vidLinkMov; ?>">
                        <?php if (isset($errors['vidLinkMov'])) {
                            echo '<div class="invalid-feedback">';
                            echo $errors['vidLinkMov'];
                            echo '</div>';
                        } ?>                                
                    </div>
                </div>
                <div class="row">
                    <!-- Catégorie -->
                    <label for="idCat">Catégorie :</label>
                    <select name="idCat" id="idCat" class="form-control <?php echo isset($errors['idCat']) ? 'is-invalid' : null; ?>">
                        <option value="">Choisir la catégorie</option>
                        <option <?php echo ($idCat=='1' ) ? 'selected' : '' ; ?> value="1">SF</option>
                        <option <?php echo ($idCat=='2' ) ? 'selected' : '' ; ?> value="2">Thriller</option>
                        <option <?php echo ($idCat=='3' ) ? 'selected' : '' ; ?> value="3">Comédie</option>
                        <option <?php echo ($idCat=='4' ) ? 'selected' : '' ; ?> value="4">Autre</option>
                        <option <?php echo ($idCat=='5' ) ? 'selected' : '' ; ?> value="5">drame</option>
                        <option <?php echo ($idCat=='6' ) ? 'selected' : '' ; ?> value="6">action</option>
                        <option <?php echo ($idCat=='7' ) ? 'selected' : '' ; ?> value="7">fantastique</option>
                        <option <?php echo ($idCat=='8' ) ? 'selected' : '' ; ?> value="8">horreur</option>
                    </select>
                    <?php if (isset($errors['idCat'])) {
                            echo '<div class="invalid-feedback">';
                            echo $errors['idCat'];
                            echo ' - $idCat = ' . $idCat;
                            echo '</div>';
                    } ?>  
                </div>

                <button class="btn btn-lg btn-block btn-success text-uppercase font-weight-bold">Ajouter le film</button>
            </div>
        </form>



    </main>


    <?php 
// On inclue le fichier footer.php sur la page :
require_once(__DIR__ . '/partials/footer.php'); ?>