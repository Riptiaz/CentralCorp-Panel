<?php
session_start();
if (isset($_SESSION['connected'])) {
  // l'utilisateur est connecté, redirection vers la page de gestion de tickets
  header("Location: settings");
  exit();
} else {
  // l'utilisateur n'est pas connecté, redirection vers la page de connexion
  header("Location: account/connexion");
  exit();
}
?>
