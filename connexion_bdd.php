<?php
require_once 'conn.php';

$host = $databaseConfig['host'];
$dbname = $databaseConfig['dbname'];
$user = $databaseConfig['username'];
$password = $databaseConfig['password'];

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
  // Activation des erreurs PDO pour afficher les erreurs en cas d'échec de la connexion
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  // En cas d'erreur, affichage du message d'erreur et arrêt de l'exécution du script
  echo "Erreur de connexion à la base de données : " . $e->getMessage();
  exit();
}