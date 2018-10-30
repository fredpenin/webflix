<?php 
// On inclue le fichier header.php sur la page :
require_once(__DIR__ . '/partials/header.php'); 


?>

    <main class="container">
        <h1>WebFlix</h1>
        <h4>Enregistrez-vous</h4>

        <form>
            <div class="form-group">
                <label for="email_user">Email : </label>
                <input type="email" class="form-control" id="email_user" aria-describedby="emailHelp" placeholder="Saisissez votre adresse e-mail">
            </div>
            <div class="form-group">
                <label for="username_user">Login : </label>
                <input type="text" class="form-control" id="username_user" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="password_user">Mot de passe : </label>
                <input type="password" class="form-control" id="password_user" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="confirm_password_user">Mot de passe : </label>
                <input type="password" class="form-control" id="confirm_password_user" placeholder="Password">
            </div>
            <button class="btn btn-primary">Valider</button>
        </form>


    </main>


    <?php 
// On inclue le fichier footer.php sur la page :
require_once(__DIR__ . '/partials/footer.php'); ?>