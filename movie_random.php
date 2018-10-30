<?php 
// On inclue la base de donnée pour pouvoir paramétert le $CurrentPageTitle avant l'appel du header :
require_once(__DIR__ . '/config/database.php'); 

$currentPageTitle = 'Modifier la fiche du film';

// On inclue le fichier header.php sur la page :
require_once(__DIR__ . '/partials/header.php'); 

//Récupération de quatre films aléatoires
$query = $db->query('SELECT * FROM movie ORDER BY RAND() LIMIT 4');
$movies = $query->fetchAll();
?>

    <main class="container">
        <h1>WebFlix</h1>
        <h4>Films au hasard</h4>

        <div class="row">
            <?php 
            //on affiche les 4 films au hazard
            foreach ($movies as $movie) { ?>
            <div class="col-sm-6 col-md-3 col-lg-2">
                <div class="card mb-4">
                    <div class="card-img-top-container">
                        <img class="card-img-top card-img-top-zoom-effect" src="assets/<?php echo $movie['cover_mov']; ?>" alt="<?php echo $movie['title_mov']; ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo $movie['title_mov']; ?>
                        </h5>
                        <!-- on envoie d'id du film dans l'url -->
                        <a href="movie_single.php?id=<?php echo $movie['id_mov']; ?>" class="btn btn-block btn-success">Regarder</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

    </main>

<?php 
// On inclue le fichier footer.php sur la page :
require_once(__DIR__ . '/partials/footer.php'); ?>