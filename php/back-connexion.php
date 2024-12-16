<?php
// Inclure le fichier de configuration pour la connexion à la base de données
require 'C:/xampp/htdocs/markgros/bd/connexionDB.php';

// Démarrer la session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $tel = trim($_POST['tel']);
    $password = trim($_POST['password']);

    // Vérifier si le numéro de téléphone existe dans la base de données
    $sql = "SELECT idUtilisateur, emailUtilisateur, passwordUtilisateur FROM utilisateur WHERE telUtilisateur = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tel);
    $stmt->execute();
    $stmt->store_result();

    // Vérifier si un utilisateur existe avec ce numéro de téléphone
    if ($stmt->num_rows > 0) {
        // Récupérer les informations de l'utilisateur
        $stmt->bind_result($idUtilisateur, $emailUtilisateur, $hashed_password);
        $stmt->fetch();

        // Vérifier que le mot de passe saisi correspond au mot de passe hashé
        if (password_verify($password, $hashed_password)) {
            // Connexion réussie, enregistrer les informations dans la session
            $_SESSION['user_id'] = $idUtilisateur;
            $_SESSION['user_email'] = $emailUtilisateur;

            // Rediriger vers la page d'accueil ou tableau de bord
            header("Location: acceuil.php");
            exit();
        } else {
            // Mauvais mot de passe
            $error = "Mot de passe incorrect.";
        }
    } else {
        // Numéro de téléphone non trouvé
        $error = "Aucun compte trouvé avec ce numéro de téléphone.";
    }

    // Fermer la requête préparée
    $stmt->close();
}

// En cas d'erreur, rediriger vers la page de connexion avec un message d'erreur
if (isset($error)) {
    header("Location: connexion.php?error=" . urlencode($error));
    exit();
}
?>
