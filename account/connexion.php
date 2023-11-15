<?php
session_start();
$configFilePath = '../config.php';
require_once '../connexion_bdd.php';

if (!file_exists($configFilePath)) {
    header('Location: ../setdb');
    exit();
}

if (isset($_SESSION['user_token'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE token = :token");
    $stmt->bindParam(':token', $_SESSION['user_token']);
    $stmt->execute();
    $utilisateur = $stmt->fetch();

    if ($utilisateur) {
        header('Location: ../settings');
        exit();
    }
}
function generateToken( $length = 40 ) {
    $characters       = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_!?./$';
    $charactersLength = strlen( $characters );
    $token            = '';
    for( $i = 0; $i < $length; $i++ ) {
        $token .= $characters[rand(0, $charactersLength - 1)];
    }
    return $token;
}

$sql = "SELECT COUNT(*) as count FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$comptesExistants = $row['count'] > 0;

if (!$comptesExistants) {
    header('Location: register.php');
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse email invalide.";
    }

    if (empty($password)) {
        $errors[] = "Veuillez saisir votre mot de passe.";
    }

    if (empty($errors)) {
        try {
            $sth = $pdo->prepare("SELECT id, password FROM users WHERE email = :email");
            $sth->execute(['email' => $email]);

            if ($sth->rowCount() === 0) {
                $errors[] = "Adresse email ou mot de passe incorrect.";
            } else {
                $user = $sth->fetch();

                if (!password_verify($password, $user['password'])) {
                    $errors[] = "Adresse email ou mot de passe incorrect.";
                } else {
                    $token = generateToken();

                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_token'] = $token;

                    $stmt = $pdo->prepare("UPDATE users SET token = :token WHERE email = :email");
                    $stmt->bindParam(':token', $token);
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();
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
<html lang="fr" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Connexion</h2>
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger">
                                <?php foreach ($errors as $error) : ?>
                                    <p><?php echo $error; ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" name="email" class="form-control" required="">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" name="password" class="form-control" required="">
                            </div>
                            <script src="https://www.google.com/recaptcha/enterprise.js?render=6LfQWIglAAAAAEzTj18fKpd0udB2MBkUojHnRr3p"></script>
                            <script>
                                grecaptcha.enterprise.ready(function () {
                                    grecaptcha.enterprise.execute('6LfQWIglAAAAAEzTj18fKpd0udB2MBkUojHnRr3p', { action: 'login' }).then(function (token) {
                                    });
                                });
                            </script>
                            <button type="submit" name="submit" class="btn btn-primary">Se connecter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
