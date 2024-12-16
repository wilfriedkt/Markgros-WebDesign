<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markgros - Inscription</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/inscription.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <div class="logo-icon">📊</div>
            <div class="logo-text">Mark<span>gros</span></div>
        </div>
        
        <form action="back-inscription.php" method="post">
            <div class="form-group">
                <label for="nom">Nom</label>
                <div class="input-container">
                    <i class="fas fa-user"></i>
                    <input type="text" id="nom" name="nom" required 
                           pattern="[A-Za-z\s]+" 
                           title="Lettres uniquement"
                           placeholder="TOURE">
                </div>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <div class="input-container">
                    <i class="fas fa-user"></i>
                    <input type="text" id="prenom" name="prenom" required
                           pattern="[A-Za-z\s]+"
                           title="Lettres uniquement"
                           placeholder="Wilfried Kigninman">
                </div>
            </div>

            <div class="form-group">
                <label for="date">Date de naissance</label>
                <div class="input-container">
                    <i class="fas fa-calendar"></i>
                    <input type="date" id="date" name="date" required>
                </div>
            </div>

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

            <!-- Ajout du champ Email -->
            <div class="form-group">
                <label for="email">Adresse Email</label>
                <div class="input-container">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" required
                           placeholder="exemple@mail.com"
                           title="Veuillez entrer une adresse email valide.">
                </div>
            </div>

            <div class="photo-upload">
                <div class="photo-container">
                    <label for="photo-input" class="photo-placeholder">
                        <span class="initials">Me</span>
                        <img src="" alt="Photo de profil" class="photo-preview">
                    </label>
                    <label for="photo-input" class="camera-icon">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input type="file" 
                           id="photo-input" 
                           class="photo-input" 
                           accept="image/*"
                           capture="user">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <div class="input-container">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required
                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                           title="8 caractères minimum, avec majuscules, minuscules et chiffres">
                </div>
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirmer le mot de passe</label>
                <div class="input-container">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-check-circle"></i>
                <span>Valider votre inscription</span>
            </button>
        </form>

        <div class="login-link">
            <p>Avez-vous déjà un compte ?</p>
            <a href="./connexion.php" class="login-btn">
                <i class="fas fa-sign-in-alt"></i>
                <span>Se connecter</span>
            </a>
        </div>
    </div>

    <script>
        const photoInput = document.getElementById('photo-input');
        const photoPreview = document.querySelector('.photo-preview');
        const photoPlaceholder = document.querySelector('.photo-placeholder');
        const initials = document.querySelector('.initials');

        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    photoPreview.style.display = 'block';
                    photoPreview.src = e.target.result;
                    photoPlaceholder.classList.add('has-image');
                }
                
                reader.readAsDataURL(file);
            }
        });

        // Ajout de la possibilité de glisser-déposer
        const photoContainer = document.querySelector('.photo-container');

        photoContainer.addEventListener('dragover', (e) => {
            e.preventDefault();
            photoContainer.style.opacity = '0.7';
        });

        photoContainer.addEventListener('dragleave', (e) => {
            e.preventDefault();
            photoContainer.style.opacity = '1';
        });

        photoContainer.addEventListener('drop', (e) => {
            e.preventDefault();
            photoContainer.style.opacity = '1';
            
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    photoPreview.style.display = 'block';
                    photoPreview.src = e.target.result;
                    photoPlaceholder.classList.add('has-image');
                }
                
                reader.readAsDataURL(file);
            }
        });
    </script>   
</body>
</html>
