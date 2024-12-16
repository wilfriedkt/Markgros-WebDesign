<?php 

// Connexion à la base de données
$servername = "localhost";
$username = "root";  // À adapter selon votre configuration
$password = "josue2005";  // À adapter selon votre configuration
$dbname = "markgros";  // Remplacez par le nom de votre base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

?>