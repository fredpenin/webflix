<?php
// Inclusion du fichier functions.php
require_once(__DIR__ . '/../config/functions.php');
// Inclusion du fichier config
require_once(__DIR__ . '/../config/config.php');
// On inclue le fichier database.php sur la page :
require_once(__DIR__ . '/../config/database.php'); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Les meilleurs pizzas de tous les mondes de tous les univers">
    <meta name="author" content="">
    <link rel="icon" href="assets/img/favicon.ico">

    <title>
        <?php
            if(empty($CurrentPageTitle)){ // Si on est sur la page d'accueil
                echo $siteName . ' - Accueil'; 
            } else { // Si on est sur une autre page
                echo $CurrentPageTitle . ' - ' . $siteName;
            }
        ?>
    </title>

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- My Style -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-warning progress-bar-striped progress-bar-animated">
        <a class="navbar-brand" href="#">WebFlix</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php echo ($CurrentPageUrl === 'index') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php">Accueil </a>
                </li>
                <li class="nav-item <?php echo ($CurrentPageUrl === 'movie_single') ? 'active' : ''; ?>">
                    <a class="nav-link" href="movie_single.php">Voir un film</a>
                </li>
                <li class="nav-item <?php echo ($CurrentPageUrl === 'movie_add') ? 'active' : ''; ?>">
                    <a class="nav-link" href="movie_add.php">Ajouter un film</a>
                </li>
                <li class="nav-item <?php echo ($CurrentPageUrl === 'movie_random') ? 'active' : ''; ?>">
                    <a class="nav-link" href="movie_random.php">J'ai de la chance - Random</a>
                </li>
                <li class="nav-item <?php echo ($CurrentPageUrl === 'register') ? 'active' : ''; ?>">
                    <a class="nav-link" href="register.php">S'enregistrer</a>
                </li>
                <li class="nav-item <?php echo ($CurrentPageUrl === 'login') ? 'active' : ''; ?>">
                    <a class="nav-link" href="login.php">Connexion</a>
                </li>
            </ul>
        </div>
    </nav>
</header>