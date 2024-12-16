<?php
session_start();
require_once("../bd/dbconnect.php"); // Fichier PHP contenant la connexion à votre BDD
require_once("fonction.php");

// Récupérer les produits depuis la base de données
$query = "SELECT * FROM produit"; // Assurez-vous que le nom de votre table est correct
$result = $conn->query($query);

$produits = [];
if ($result->rowCount() > 0) { // Utilisez rowCount() au lieu de num_rows
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $produits[] = $row;
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-blue: #3f3d99;
            --primary-orange: #ff5722;
        }

        body {
            font-family: Arial, sans-serif;
        
        }

        .header {
            width: 100%;
            padding: 1rem;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
        }

        .logo-mark {
            color: var(--primary-blue);
        }

        .logo-gros {
            color: var(--primary-orange);
        }

        .logo-icon {
            width: 24px;
            height: 24px;
            margin-right: 8px;
            color: var(--primary-blue);
        }

        .user-actions {
            display: flex;
            gap: 1rem;
        }

        .icon-button {
            background: none;
            border: none;
            color: var(--primary-blue);
            cursor: pointer;
            padding: 0.5rem;
        }

        .search-bar {
            max-width: 60%;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-left:20%
        }

        .home-button {
            color: var(--primary-orange);
        }

        .search-container {
            flex: 1;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-right: 3rem;
            border-radius: 50px;
            border: 2px solid var(--primary-blue);
            font-size: 1rem;
        }

        .search-button {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--primary-blue);
            cursor: pointer;
        }

        .cart-button {
            color: var(--primary-blue);
        }

        @media (min-width: 768px) {
            .header {
                padding: 1rem 2rem;
            }

            .logo {
                font-size: 2rem;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-blue: #3f3d99;
            --primary-orange: #ff5722;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-700: #374151;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--gray-100);
        }

        /* Nouveaux styles */
        .main-title {
            color: var(--primary-blue);
            text-align: center;
            font-size: 1.5rem;
            padding: 1.5rem 0;
            margin: 0 1rem;
            border-bottom: 2px solid var(--primary-blue);
        }

        .categories {
            padding: 1rem;
            display: flex;
            gap: 1rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .category-tab {
            padding: 0.75rem 1.5rem;
            background: white;
            border: 2px solid var(--primary-blue);
            border-radius: 25px;
            color: var(--primary-blue);
            font-weight: bold;
            cursor: pointer;
            white-space: nowrap;
        }

        .category-tab.active {
            background: var(--primary-blue);
            color: white;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            padding: 1rem;
        }

        .carte-produit {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            position: relative;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .carte-produit:hover {
            transform: translateY(-5px);
        }

        .badge-nouveau {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--primary-orange);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.875rem;
        }

        .carte-produit img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .titre {
            color: var(--gray-700);
            font-size: 1.125rem;
            margin-bottom: 0.5rem;
        }

        .prix {
            color: var(--primary-blue);
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .evaluation {
            color: gold;
            margin-bottom: 1rem;
        }

        .btn-panier, .btn-acheter {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-panier {
            background: var(--primary-blue);
            color: white;
            margin-bottom: 0.5rem;
        }

        .btn-acheter {
            background: var(--primary-orange);
            color: white;
        }

        @media (min-width: 768px) {
            .main-title {
                font-size: 2rem;
                padding: 2rem 0;
            }

            .categories {
                padding: 2rem 1rem;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="top-bar">
            <a href="/" class="logo">
                <svg class="logo-icon" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M3 3h18v18H3V3m16 16V5H5v14h14Z"/>
                </svg>
                <span class="logo-mark">Mark</span><span class="logo-gros">gros</span>
            </a>
            <div class="user-actions">
                <a href="infoPerson.php">
                    <button class="icon-button">
                        <svg width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4Z"/>
                        </svg>
                    </button>
                </a>

                <button class="icon-button">
                    <svg width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M4 4h4v4H4V4m6 0h4v4h-4V4m6 0h4v4h-4V4M4 10h4v4H4v-4m6 0h4v4h-4v-4m6 0h4v4h-4v-4M4 16h4v4H4v-4m6 0h4v4h-4v-4m6 0h4v4h-4v-4"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="search-bar">
            <button class="icon-button home-button">
                <svg width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M10 20v-6h4v6h5v-8h3L12 3L2 12h3v8h5Z"/>
                </svg>
            </button>
            <div class="search-container">
                <input type="search" class="search-input" placeholder="Recherchez un produit...">
                <button class="search-button">
                    <svg width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M9.5 3A6.5 6.5 0 0 1 16 9.5c0 1.61-.59 3.09-1.56 4.23l.27.27h.79l5 5l-1.5 1.5l-5-5v-.79l-.27-.27A6.516 6.516 0 0 1 9.5 16A6.5 6.5 0 0 1 3 9.5A6.5 6.5 0 0 1 9.5 3m0 2C7 5 5 7 5 9.5S7 14 9.5 14S14 12 14 9.5S12 5 9.5 5Z"/>
                    </svg>
                </button>
            </div>
            <button class="icon-button cart-button">
                <svg width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M17 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2M1 2v2h2l3.6 7.59l-1.35 2.45c-.16.28-.25.61-.25.96a2 2 0 0 0 2 2h12v-2H7.42a.25.25 0 0 1-.25-.25c0-.05.01-.09.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2M7 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2Z"/>
                </svg>
            </button>
        </div>
    </header>





    <h1 class="main-title">Vos produits électroménagers</h1>
    
    <div class="categories">
        <button class="category-tab active">Gros électroménager</button>
        <button class="category-tab">Petit électroménager</button>
    </div>

    <div class="products-grid">
        <?php foreach ($produits as $produit): ?>
            <div class="carte-produit">
                <div class="badge-nouveau">Nouveau</div>
                <img src="<?php echo $produit['imageProduit']; ?>" alt="<?php echo $produit['nomProduit']; ?>" />
                <h3 class="titre"><?php echo $produit['nomProduit']; ?></h3>
                <p class="prix"><?php echo number_format($produit['prixUniProduit'], 0, ',', ' ') . ' FCFA'; ?></p>
                <div class="evaluation">⭐⭐⭐⭐⭐</div>
                <button class="btn-panier">
                    <svg width="20" height="20" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M17 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2M1 2v2h2l3.6 7.59l-1.35 2.45c-.16.28-.25.61-.25.96a2 2 0 0 0 2 2h12v-2H7.42a.25.25 0 0 1-.25-.25c0-.05.01-.09.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2M7 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2Z"/>
                    </svg>
                    Ajouter au panier
                </button>
                <button class="btn-acheter">
                    <svg width="20" height="20" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M5 6h14c.55 0 1.02-.2 1.41-.59c.4-.39.59-.86.59-1.41s-.2-1.02-.59-1.41C20.02 2.2 19.55 2 19 2H5c-.55 0-1.02.2-1.41.59C3.2 2.98 3 3.45 3 4s.2 1.02.59 1.41C3.98 5.8 4.45 6 5 6m0 4h14c.55 0 1.02-.2 1.41-.59c.4-.39.59-.86.59-1.41s-.2-1.02-.59-1.41C20.02 6.2 19.55 6 19 6H5c-.55 0-1.02.2-1.41.59C3.2 6.98 3 7.45 3 8s.2 1.02.59 1.41C3.98 9.8 4.45 10 5 10M5 14h14c.55 0 1.02-.2 1.41-.59c.4-.39.59-.86.59-1.41s-.2-1.02-.59-1.41C20.02 10.2 19.55 10 19 10H5c-.55 0-1.02.2-1.41.59C3.2 10.98 3 11.45 3 12s.2 1.02.59 1.41c.39.4.86.59 1.41.59M5 18h14c.55 0 1.02-.2 1.41-.59c.4-.39.59-.86.59-1.41s-.2-1.02-.59-1.41C20.02 14.2 19.55 14 19 14H5c-.55 0-1.02.2-1.41.59C3.2 14.98 3 15.45 3 16s.2 1.02.59 1.41c.39.4.86.59 1.41.59"/>
                    </svg>
                    Acheter
                </button>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        
    </script>
</body>
</html>