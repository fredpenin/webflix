<?php 
// On inclue la base de donnée pour pouvoir paramétert le $CurrentPageTitle avant l'appel du header :
require_once(__DIR__ . '/config/database.php'); 

 //Récupération du film sélectionné en récupérant l'id dans l'url
$id = isset($_GET['id']) ? $_GET['id'] : 0;
// récup des infos du film
$query = $db->prepare('SELECT * FROM movie WHERE id_mov = :id'); 
$query->bindValue(':id', $id, PDO::PARAM_INT); // on s'assure que l'id est bien un entier
$query-> execute(); // execute la requête
$movie = $query->fetch();


//renvoyer une 404 si le film n'existe pas (pour éviter le référencement de nos "404" si l'utilisateur change l'id manuellement dans l'url)
// puis renvoie su' l'index après 5 secondes
if ($movie === false) {
    http_response_code(404);
    echo "404";
    
    require_once(__DIR__.'/partials/header.php'); ?>
    <h1>404. Redirection dans 5 secondes...</h1>
    <script>
        setTimeout(function(){
            window.location = 'index.php';
        }, 5000);
    </script>
    <?php require_once(__DIR__.'/partials/footer.php');
    die();
}
///////////////////////////////////////////////

$currentPageTitle = 'Supprimer le film';
// On inclue le fichier header.php sur la page :
require_once(__DIR__ . '/partials/header.php'); 

//Suppression du film SI on clique sur le bouton
if (isset($_POST['delete'])){
    $delQuery = $db->prepare('DELETE FROM movie WHERE id_mov = :id');
    $delQuery->bindValue(':id', $id, PDO::PARAM_INT);
    $delQuery-> execute();
    ?>

    <div class="alert alert-success alert-dismissible fade show">
        Le film <strong><?php echo $movie['title_mov']; ?></strong> a été supprimé avec succès.<strong>
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

    <main class="container">
        <h1>WebFlix</h1>
        <h4>Supprimer le film</h4>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 card card-img-top-container" style="width: 18rem;">
                <img class="card-img-top card-img-top-zoom-effect " src="assets/<?php echo $movie['cover_mov']; ?>" alt="<?php echo $movie['title_mov']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $movie['title_mov']; ?></h5>
                        <p class="card-text"><?php echo $movie['description_mov']; ?></p>
                        <form method="POST">
                            <button name="delete" value="delete" class="btn btn-block btn-danger">SUPPRIMER LE FILM</button>
                        </form>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>

    </main>




<?php
// On inclue le fichier footer.php sur la page :
require_once(__DIR__ . '/partials/footer.php'); ?>