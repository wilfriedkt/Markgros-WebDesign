<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markgros - Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/connexion.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <div class="logo-icon">📊</div>
            <div class="logo-text">Mark<span>gros</span></div>
        </div>
        
        <form action="back-connexion.php" method="post">
            <div class="form-group">
                <label for="tel">Numéro de téléphone</label>
                <div class="input-container">
                    <i class="fas fa-phone"></i>
                    <input type="tel" id="tel" name="tel" required
                           pattern="[0-9]{10}"
                           title="Numéro à 10 chiffres"
                           placeholder="0123456789">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <div class="input-container">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required
                           placeholder="Entrez votre mot de passe">
                </div>
            </div>

            <div class="forgot-password">
                <a href="reset-password.html">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>
        </form>

        <div class="signup-link">
            <p>Pas encore de compte ?</p>
            <a href="inscription.php" class="signup-btn">
                <i class="fas fa-user-plus"></i> S'inscrire
            </a>
        </div>
    </div>
</body>
</html>