<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

// Inclure le fichier de configuration pour la connexion à la base de données
require 'C:/xampp/htdocs/markgros/bd/connexionDB.php';

// Récupérer les informations de l'utilisateur connecté depuis la base de données
$sql = "SELECT nomUtilisateur, prenomUtilisateur, telUtilisateur, emailUtilisateur, dateNaissUtilisateur, photoUtilisateur 
        FROM utilisateur WHERE idUtilisateur = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($nom, $prenom, $telephone, $email, $date_naissance, $photo);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations Personnelles</title>
    <link rel="stylesheet" href="../css/infoPerson.css">
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body>
    <div class="container">
        <!-- En-tête -->
        <div class="en-tete">
            <button class="btn-retour">
                <i data-lucide="arrow-left"></i>
            </button>
            <img class="logo" src="../img/logoMarkgros.png" alt="logoMarkgros">
        </div>

        <div class="section-principale">
            <h1>Informations personnelles</h1>

            <div class="info-utilisateur">
                <div class="photo-utilisateur">
                    <img src="<?php echo htmlspecialchars($photo); ?>" alt="Photo de l'utilisateur" class="photo" />
                </div>
                <div class="champ">
                    <label for="nom">Nom :</label>
                    <p id="nom"><?php echo htmlspecialchars($nom); ?></p>
                </div>
                <div class="champ">
                    <label for="prenom">Prénom :</label>
                    <p id="prenom"><?php echo htmlspecialchars($prenom); ?></p>
                </div>
                <div class="champ">
                    <label for="date-naissance">Date de naissance :</label>
                    <p id="date-naissance"><?php echo htmlspecialchars($date_naissance); ?></p>
                </div>
                <div class="champ">
                    <label for="ville">Téléphone :</label>
                    <p id="telephone"><?php echo htmlspecialchars($telephone); ?></p>
                </div>
                <div class="champ">
                    <label for="email">Email :</label>
                    <p id="email"><?php echo htmlspecialchars($email); ?></p>
                </div>
            </div>

            <div class="groupe-boutons">
                <button class="btn-modifier">Modifier mes Informations</button>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
