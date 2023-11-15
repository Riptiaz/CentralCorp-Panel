<?php
session_start();
$configFilePath = '../config.php';

if (!file_exists($configFilePath)) {
    header('Location: ../setdb');
    exit();
}
require_once '../connexion_bdd.php';
if (isset($_SESSION['user_token'])) {
  $stmt = $pdo->prepare("SELECT * FROM users WHERE token = :token");
  $stmt->bindParam(':token', $_SESSION['user_token']);
  $stmt->execute();
  $utilisateur = $stmt->fetch();

  if ($utilisateur) {
      header('Location: accueil.php');
      exit();
  }
}
$sql = "SELECT COUNT(*) as count FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row['count'] > 0) {
    header('Location: connexion');
    exit();
}
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    $errors = array();

    if (empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse email invalide.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    require_once '../connexion_bdd.php';

    $query = "SELECT id FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array('email' => $email));

    if ($stmt->rowCount() > 0) {
        $errors[] = "Adresse email déjà utilisée.";
    }

    if (count($errors) === 0) {
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $query = "INSERT INTO users (email, password) VALUES (:email, :password)";
        $stmt = $pdo->prepare($query);

        $stmt->execute(array(
            'email' => $email,
            'password' => $hashed_password
        ));

        header('Location: connexion?register=success');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr"data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Inscription</h1>
                </div>
                <div class="card-body">
                    <form method="post" action="register">
                        <?php if (isset($errors) && count($errors) > 0) : ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php foreach ($errors as $error) : ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="email">E-mail :</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe :</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirmez votre mot de passe :</label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3" name="submit">S'inscrire</button>
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
