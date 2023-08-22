<?php
session_start();
$configFilePath = '..\config.php';

if (!file_exists($configFilePath)) {
    header('Location: ..\setdb');
    exit();
}

// Si l'utilisateur est déjà connecté, on le redirige vers la page d'accueil
if (isset($_SESSION['user_id'])) {
    header('Location: ..\settings');
    exit();
}
require_once '..\connexion_bdd.php';
$sql = "SELECT COUNT(*) as count FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row['count'] > 0) {
    header('Location: connexion'); // Rediriger vers la page de connexion
    exit();
}

// Traitement du formulaire d'inscription
if (isset($_POST['submit'])) {
    // Vérification des données saisies par l'utilisateur
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    $errors = array();

    // Vérification des champs obligatoires
    if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    // Vérification de l'adresse email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse email invalide.";
    }

    // Vérification que les mots de passe correspondent
    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // Vérification que l'adresse email n'est pas déjà utilisée
    require_once '..\connexion_bdd.php';

    $query = "SELECT id FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array('email' => $email));

    if ($stmt->rowCount() > 0) {
        $errors[] = "Adresse email déjà utilisée.";
    }

    // Si aucune erreur n'a été trouvée, on enregistre l'utilisateur dans la base de données
    if (count($errors) === 0) {
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $query = "INSERT INTO users (nom, prenom, email, password) VALUES (:nom, :prenom, :email, :password)";
        $stmt = $pdo->prepare($query);

        $stmt->execute(array(
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => $hashed_password
        ));

        // On redirige l'utilisateur vers la page de connexion
        header('Location: connexion?register=success');
        exit();
    }
}

// Affichage du formulaire d'inscription
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <link rel="stylesheet" type="text/css" href="..\css\register.css">
</head>
<body>
  <div class="container">
    <div class="register-box">
      <h1>Inscription</h1>
      <form method="post" action="register">
        <?php if (isset($errors) && count($errors) > 0) : ?>
          <div class="error-box">
            <ul>
              <?php foreach ($errors as $error) : ?>
                <li><?php echo $error; ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
        <div class="user-box">
          <label for="nom">Nom :</label>
          <input type="text" name="nom" id="nom" required>
        </div>
        <div class="user-box">
          <label>Prénom</label>
          <input type="text" name="prenom" id="prenom" required>
        </div>
        <div class="user-box">
          <label for="email">E-mail :</label>
          <input type="email" name="email" id="email" required>
        </div>
        <div class="user-box">
          <label for="password">Mot de passe :</label>
          <input type="password" name="password" id="password" required>
        </div>
        <div class="user-box">
          <label for="confirm_password">Confirmez votre mot de passe :</label>
          <input type="password" name="confirm_password" id="confirm_password" required>
        </div>
        <script src="https://www.google.com/recaptcha/enterprise.js?render=6LfQWIglAAAAAEzTj18fKpd0udB2MBkUojHnRr3p"></script>
        <script>
        grecaptcha.enterprise.ready(function() {
            grecaptcha.enterprise.execute('6LfQWIglAAAAAEzTj18fKpd0udB2MBkUojHnRr3p', {action: 'login'}).then(function(token) {
               ...
            });
        });
        </script>
        <button type="submit" name="submit">S'inscrire</button>
      </form>
    </div>
  </div>
</body>
</html>



