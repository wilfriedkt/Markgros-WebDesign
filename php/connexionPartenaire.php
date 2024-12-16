<?php
session_start(); // Démarrer la session

require_once("../bd/dbconnect.php");  // connection bd
require_once("fonction.php");


// Traiter les données du formulaire
$postData = $_POST;

if (isset($postData['connexion'])) {
    // Vérifier si les champs email et mot de passe ne sont pas vides
    if (!empty($postData['email']) && !empty($postData['motpasse'])) {
        $email = htmlspecialchars($postData['email']);
        $motPasse = htmlspecialchars(($postData['motpasse']));

        // Valider l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errEmail = 'Il faut un email valide pour se connecter.';
        } else {
            try {
                // Vérifier l'existence de l'email dans la table User
                $reqEmail = $conn->prepare("SELECT *FROM partenaire WHERE emailPartenaire = ?");
                $reqEmail->execute([$email]);
                $partenaire = $reqEmail->fetch(PDO::FETCH_ASSOC);

                if ($partenaire) {
                    $idPartenaire = $partenaire['idPartenaire'];

                    // Vérifier l'existence du mot de passe pour l'utilisateur trouvé
                    $reqMotPasse = $conn->prepare("SELECT * FROM partenaire WHERE idPartenaire = ? AND passwordPartenaire = ?");
                    $reqMotPasse->execute([$idPartenaire, $motPasse]);
                    $compte = $reqMotPasse->fetch(PDO::FETCH_ASSOC);

                    if ($compte) {
                        // Compte valide, enregistrer l'ID de l'utilisateur dans la session
                        $_SESSION['LOGIN_PARTENAIRE'] = [
                            'partenaire_id' => $idPartenaire,
                            'email_partenaire' => $email,
                            'nom_partenaire' => $compte['nomPartenaire']
                        ];
                       

                        // Redirection vers la page d'accueil
                        redirectToUrl('dashbordPartenaire.php');
                    } else {
                        $errCompte = "Désolé, nous ne trouvons pas ce compte.";
                    }
                } else {
                    $errCompte = "Désolé, nous ne trouvons pas ce compte.";
                }
            } catch (PDOException $e) {
                echo 'Erreur: ' . $e->getMessage();
                exit;
            }
        }
    } else {
        $remplirChamps = 'Remplissez tous les champs';
    }
} 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Partenaire</title>
    <style>
        /* Style amélioré pour le formulaire de connexion */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #2c3e50;
            margin: 60px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #ecf0f1;
        }

        .gdiv {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #34495e;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }

        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 20px;
        }

        .connexion {
            color: #ecf0f1;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        label {
            display: block;
            font-size: 14px;
            color: #333;
            margin-bottom: 8px;
            font-weight: 600;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #bdc3c7;
            margin-bottom: 15px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 600;
        }

        button:hover {
            background-color: #2ecc71;
        }

        .div {
            margin: 10px 0;
            text-align: center;
            color: #ecf0f1;
        }

        .seconnecter {
            width: 100%;
            padding: 12px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 600;
        }

        .seconnecter:hover {
            background-color: #3498db;
        }

        @media (max-width: 600px) {
            .gdiv {
                padding: 20px;
            }

            form {
                padding: 20px;
            }

            .connexion {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="gdiv">
        <img class="logo" src="../img/logoMarkgros.png" alt="logo">
        <div class="connexion"><strong>SE CONNECTER</strong></div><br>

        <?php if (isset($errCompte)) : ?>
            <div style="color: red;"><?php echo $errCompte; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="Email">Email</label>
            <input type="text" id="email" name="email" required>

            <label for="mot_de_pass">Mot de passe</label>
            <input type="password" id="motpasse" name="motpasse" required>
            <br><br>

            <button type="submit" name="connexion">Connexion</button>
            <div class="div">ou</div>
            <button type="button" class="seconnecter">S'inscrire</button>
        </form>
    </div>
</body>
</html>
