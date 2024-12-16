<?php
session_start();
require_once("bd/dbconnect.php");

if (isset($_GET['id'])) {
    $idPartenaire = $_GET['id'];
    $query = "DELETE FROM partenaire WHERE idPartenaire = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $idPartenaire);
    
    if ($stmt->execute()) {
        header("Location: admin.php"); // Rediriger après suppression
    } else {
        echo "Erreur lors de la suppression du partenaire.";
    }
}
?>
