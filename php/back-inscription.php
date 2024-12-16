<?php
// Inclure le fichier de connexion à la base de données
// require './bd/connexionDB.php'; // Fichier contenant les informations de connexion à la base de données
require 'C:/xampp/htdocs/markgros/bd/connexionDB.php';

// Démarrer une session
// session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer les données du formulaire
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $date_naissance = $_POST['date'];
    $tel = trim($_POST['tel']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    
    // Valider les données
    $errors = [];

    if (empty($nom) || !preg_match("/^[a-zA-Z\s]+$/", $nom)) {
        $errors[] = "Le nom n'est pas valide (lettres uniquement).";
    }

    if (empty($prenom) || !preg_match("/^[a-zA-Z\s]+$/", $prenom)) {
        $errors[] = "Le prénom n'est pas valide (lettres uniquement).";
    }

    if (empty($tel) || !preg_match("/^[0-9]{10}$/", $tel)) {
        $errors[] = "Le numéro de téléphone doit être un numéro valide à 10 chiffres.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    } elseif (!preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/", $password)) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères avec des majuscules, des minuscules et des chiffres.";
    }

    // Gérer l'upload de la photo de profil
    $photo_name = '';
    if (isset($_FILES['photo-input']) && $_FILES['photo-input']['error'] == 0) {
        $photo = $_FILES['photo-input'];
        $target_dir = "img/"; // Dossier où les fichiers seront stockés
        $target_file = $target_dir . basename($photo["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifier le type de fichier (seulement des images)
        $check = getimagesize($photo["tmp_name"]);
        if ($check === false) {
            $errors[] = "Le fichier n'est pas une image valide.";
        }

        // Limiter les types de fichiers autorisés
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $errors[] = "Seules les extensions JPG, JPEG, PNG, et GIF sont autorisées.";
        }

        // Déplacer l'image téléchargée dans le dossier de destination
        if (empty($errors)) {
            if (move_uploaded_file($photo["tmp_name"], $target_file)) {
                $photo_name = basename($photo["name"]); // Conserver le nom de l'image pour l'enregistrement en base
            } else {
                $errors[] = "Une erreur est survenue lors du téléchargement de l'image.";
            }
        }
    }

    // Si aucune erreur, enregistrer les données dans la base
    if (empty($errors)) {
        // Hasher le mot de passe
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        // Préparer et exécuter la requête d'insertion
        $sql = "INSERT INTO utilisateur (nomUtilisateur, prenomUtilisateur, dateNaissUtilisateur, telUtilisateur, emailUtilisateur, passwordUtilisateur, photoUtilisateur)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $nom, $prenom, $date_naissance, $tel, $email, $password_hashed, $photo_name);

        if ($stmt->execute()) {

            // Stocker les informations de l'utilisateur dans la session
            // $_SESSION['user_id'] = $user_id;
            // $_SESSION['tel'] = $tel;
            // $_SESSION['email'] = $email;

            // Rediriger vers la page de connexion ou afficher un message de succès
            header("Location: connexion.php");
            exit();
        } else {
            $errors[] = "Erreur lors de l'inscription : " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur d'inscription</title>
</head>
<body>
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</body>
</html>
