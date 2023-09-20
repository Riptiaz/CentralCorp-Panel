<?php
session_start();
$configFilePath = '../config.php';

if (!file_exists($configFilePath)) {
    header('Location: ../setdb');
    exit();
}

if (isset($_SESSION['user_id'])) {
    header('Location: ../settings');
    exit();
}
require_once '../connexion_bdd.php';
$sql = "SELECT COUNT(*) as count FROM users";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $comptesExistants = $row['count'] > 0;
            
        if (!$comptesExistants) {
                header('Location: register.php'); // Remplacez par l'URL de votre page d'inscription
                exit();
            }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérification de l'email et du mot de passe
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse email invalide.";
    }

    if (empty($password)) {
        $errors[] = "Veuillez saisir votre mot de passe.";
    }

    // Vérification des identifiants dans la base de données
    if (empty($errors)) {
        try {
            require_once '../connexion_bdd.php';


            $sth = $pdo->prepare("SELECT id, password FROM users WHERE email = :email");
            $sth->execute(['email' => $email]);

            if ($sth->rowCount() === 0) {
                $errors[] = "Adresse email ou mot de passe incorrect.";
            } else {
                $user = $sth->fetch();

                if (!password_verify($password, $user['password'])) {
                    $errors[] = "Adresse email ou mot de passe incorrect.";
                } else {
                    // Ouverture de la session et redirection vers la page d'accueil
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user'] = $user;
                    header('Location: ../settings');
                    exit();
                }
            }
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données: " . $e->getMessage();
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="login-box">
        <h2>Connexion</h2>
        <?php if (!empty($errors)) : ?>
            <div class="error-box">
                <?php foreach ($errors as $error) : ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="user-box">
                <input type="email" name="email" required="">
                <label>Adresse email</label>
            </div>
            <div class="user-box">
                <input type="password" name="password" required="">
                <label>Mot de passe</label>
            </div>
            <script src="https://www.google.com/recaptcha/enterprise.js?render=6LfQWIglAAAAAEzTj18fKpd0udB2MBkUojHnRr3p"></script>
<script>
grecaptcha.enterprise.ready(function() {
    grecaptcha.enterprise.execute('6LfQWIglAAAAAEzTj18fKpd0udB2MBkUojHnRr3p', {action: 'login'}).then(function(token) {
       ...
    });
});
</script>
            <button type="submit" name="submit">Se connecter</button>
        </form>
    </div>
</body>

</html>
