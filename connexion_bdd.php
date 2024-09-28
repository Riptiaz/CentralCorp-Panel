<?php
require_once 'conn.php';

$host = $databaseConfig['host'];
$dbname = $databaseConfig['dbname'];
$user = $databaseConfig['username'];
$password = $databaseConfig['password'];

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Erreur de connexion à la base de données : " . $e->getMessage();
  exit();
}