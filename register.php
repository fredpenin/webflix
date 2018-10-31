<?php 
$currentPageTitle = "S'enregistrer";
// On inclue le fichier header.php sur la page :
require_once(__DIR__ . '/partials/header.php'); 

//traitement du formulaire
$usernameUser = $emailUser = $passwordUser = $tokenExpirationUser = $tokenUser = null;

// le formulaire est soumis
if (!empty($_POST)) {
    $usernameUser = $_POST['txtUsername'];
    $emailUser = ($_POST['txtEmail']);
    $pwdUser = $_POST['txtPwd'];
    $confirmPwdUser = $_POST['txtConfirmPwd'];
    
    // $tokenExpirationUser = ; 
    // $tokenUser = ;

    //VERIF DU FORMULAIRE
    // Définir un tableau d'erreur vide qui va se remplir après chaque erreur
    $errors = [];
    // Vérifier le username
    if (empty($usernameUser) || strlen($usernameUser) < 3) {
        $errors['usernameUser'] = 'Le nom d\'utilisateur n\'est pas valide.';
    }
    // Vérifier l'email
    if (!filter_var($emailUser, FILTER_VALIDATE_EMAIL)) {
        $errors['emailUser'] = 'Vous devez saisir un e-mail valide.';
    }
    // vérifier le password
    if (strlen($pwdUser) < 6){
        $errors['pwdUser'] = 'Le mot de passe doit contenir au moins 6 caractères.';
    }
    // Vérifier la confirmation du password
    if ($confirmPwdUser !== $pwdUser) {
        $errors['confirmPwdUser'] = 'Les champs de mot de passe ne correspondent pas.';
    }


    // S'il n'y a pas d'erreurs dans le formulaire
    if (empty($errors)) {
        //hash du password pour la bdd
        $pwdUser = password_hash($pwdUser, PASSWORD_DEFAULT);
        
        $query = $db->prepare('
            INSERT INTO user (`username_user`, `email_user`, `password_user`) 
            VALUES (:username, :email, :password)
        ');

    $query->bindValue(':username', $usernameUser, PDO::PARAM_STR);
    $query->bindValue(':email', $emailUser, PDO::PARAM_STR);
    $query->bindValue(':password', $pwdUser, PDO::PARAM_STR);

        if ($query->execute()) { // On ajoute l'utilisateur dans la BDD
            $success = true;
        }
    }
}


?>

    <main class="container">
        <h1>WebFlix</h1>
        <h4>Enregistrez-vous</h4>

        <?php if (isset($success) && $success) { ?>
        <div class="alert alert-success alert-dismissible fade show">
            Félicitations! Vous êtes à présent enregistré avec le login <strong><?php echo $usernameUser; ?></strong>
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php } ?>

        <form method="POST">
            <div class="form-group">
                <label for="email_user">Email : </label>
                <input name="txtEmail" type="text" class="form-control <?php echo isset($errors['emailUser']) ? 'is-invalid' : null; ?>" 
                    id="email_user" placeholder="Saisissez votre adresse e-mail" value="<?php echo $emailUser; ?>">
                    <?php if (isset($errors['emailUser'])) {
                            echo '<div class="invalid-feedback">';
                            echo $errors['emailUser'];
                            echo '</div>';
                    } ?>
            </div>
            <div class="form-group">
                <label for="txtUsername">Nom d'utilisateur (3 caractères minimum) : </label>
                <input name="txtUsername" type="text" class="form-control <?php echo isset($errors['usernameUser']) ? 'is-invalid' : null; ?>" 
                    id="username_user" placeholder="Choisissez un nom d'utilisateur"  value="<?php echo $usernameUser; ?>">
                    <?php if (isset($errors['usernameUser'])) {
                            echo '<div class="invalid-feedback">';
                            echo $errors['usernameUser'];
                            echo '</div>';
                    } ?>                    
            </div>
            <div class="form-group">
                <label for="password_user">Mot de passe : </label>
                <input name="txtPwd" type="password" class="form-control <?php echo isset($errors['pwdUser']) ? 'is-invalid' : null; ?>" 
                    id="password_user" placeholder="Choisissez un mot de passe">
                <?php if (isset($errors['pwdUser'])) {
                        echo '<div class="invalid-feedback">';
                        echo $errors['pwdUser'];
                        echo '</div>';
                    } ?> 
            </div>
            <div class="form-group">
                <label for="confirm_password_user">Mot de passe : </label>
                <input name="txtConfirmPwd" type="password" class="form-control <?php echo isset($errors['confirmPwdUser']) ? 'is-invalid' : null; ?>" 
                    id="confirm_password_user" placeholder="Confirmer le mot de passe">
                    <?php if (isset($errors['confirmPwdUser'])) {
                        echo '<div class="invalid-feedback">';
                        echo $errors['confirmPwdUser'];
                        echo '</div>';
                    } ?>                
            </div>
            <button class="btn btn-block btn-primary">Valider</button>
        </form>


    </main>


    <?php 
// On inclue le fichier footer.php sur la page :
require_once(__DIR__ . '/partials/footer.php'); ?>