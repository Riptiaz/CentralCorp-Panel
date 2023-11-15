<?php
session_start();
require_once 'connexion_bdd.php';
require('auth.php');
header('Location: account/connexion.php');
exit();
?>