<?php 
$currentPageTitle = 'Login';
// On inclue le fichier header.php sur la page :
require_once(__DIR__ . '/partials/header.php'); 


$emailUser = $pwdUser = $pwdHash = null;

// le formulaire est soumis
if (!empty($_POST)) {
    $emailUser = ($_POST['email_user']);
    $pwdUser = $_POST['password_user'];

    //Récupération de l'utilisateur dans la BDD s'il existe
    $query = $db->prepare('SELECT * FROM user WHERE email_user = :emailUser'); 
    $query->bindValue(':emailUser', $emailUser, PDO::PARAM_STR);
    $query-> execute(); // execute la requête
    $query = $query->fetch();
    //var_dump($query);
    $pwdHash = $query['password_user'];


    //VERIF DU FORMULAIRE
    // Définir un tableau d'erreur vide qui va se remplir après chaque erreur
    $errors = [];
    //vérifie si l'email existe dans la BDD. // var_dump($query); : renvoie 'false' si le fetch ne renvoie aucun user
    if($query === false){
        $errors['email'] = 'Votre e-mail n\'est pas reconnu. Vérifiez la saisie ou enregistrez-vous.';
    }
    //Vérifie si le PWD saisi concorde avec le Hash de la BDD //Retourne true ou false si correspondance
    if(!password_verify($pwdUser, $pwdHash)) {
    $errors['password'] = 'Mot de passe incorrect.';
    }

    if (empty($errors)) {
        //passe la session en active
        
        //var_dump($_SESSION);
        $_SESSION['sessionActive'] = true;
        $_SESSION['username'] = $query['username_user'];
        $_SESSION['email'] = $emailUser;
        $success = true;
    } else {
        $_SESSION['sessionActive'] = false;
        //var_dump($_SESSION);
    }
}
?>


    <main class="container">
        <h1>WebFlix</h1>
        <h4>Connectez-vous</h4>

        <?php if (isset($success) && $success) { ?>
        <div class="alert alert-success alert-dismissible fade show">
             Connexion résussie. Bienvenue, <?php echo $_SESSION['username']; ?>
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php } ?>

        <form method="POST">
            <div class="form-group">
                <label for="email_user">Email : </label>
                <input name="email_user" type="text" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : null; ?>" id="email_user" 
                placeholder="Saisissez votre adresse e-mail" value="<?php echo $emailUser; ?>">
                <?php 
                    if (isset($errors['email'])) {
                        echo '<div class="invalid-feedback">';
                        echo $errors['email'];
                        echo '</div>';
                    } 
                ?>                
            </div>
            <div class="form-group">
                <label for="password_user">Mot de passe : </label>
                <input name="password_user" type="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : null; ?>" 
                id="password_user" placeholder="Password">
                <?php 
                    if (isset($errors['password'])) {
                        echo '<div class="invalid-feedback">';
                        echo $errors['password'];
                        echo '</div>';
                    } 
                ?>
            </div>
            <button class="btn btn-block btn-success">Connexion</button>
        </form>
    </main>


<?php 
// On inclue le fichier footer.php sur la page :
require_once(__DIR__ . '/partials/footer.php'); ?>