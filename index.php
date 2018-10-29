<?php 
// On inclue le fichier header.php sur la page :
require_once(__DIR__ . '/partials/header.php'); 

//Récupération de la liste des films
$query = $db->query('SELECT * FROM movie');
$movies = $query->fetchAll();
?>

    <main class="container">
        <h1>WebFlix</h1>
        <h4>Liste des films</h4>

        <div class="row">
            <?php 
            //on affiche la liste des films
            foreach ($movies as $movie) { ?>
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-img-top-container">
                        <img class="card-img-top card-img-top-zoom-effect" src="assets/<?php echo $movie['cover_mov']; ?>" alt="<?php echo $movie['title_mov']; ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo $movie['movie_title']; ?>
                        </h5>
                        <!-- on envoie d'id du film dans l'url -->
                        <a href="movie_single.php?id=<?php echo $movie['id_mov']; ?>" class="btn btn-danger">Voir ce film</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>


    </main>


    <?php 
// On inclue le fichier footer.php sur la page :
require_once(__DIR__ . '/partials/footer.php'); ?>