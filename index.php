<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Smarttech Application</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    /* Définir l'image de fond pour toute la page */
    body {
      background: url('image.avif') no-repeat center center fixed;
      background-size: cover;
    }
    /* Personnalisation de la navbar */
    .navbar-custom {
      background-color: rgba(0, 0, 0, 0.7);
    }
    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link,
    .navbar-custom .navbar-text {
      color: #fff;
    }
    /* Container avec fond translucide pour améliorer la lisibilité */
    .container-custom {
      background: rgba(255, 255, 255, 0.85);
      padding: 20px;
      border-radius: 10px;
      margin-top: 50px;
    }
  </style>
</head>
<body>
  <!-- Navbar Bootstrap -->
  <nav class="navbar navbar-expand-lg navbar-custom">
    <a class="navbar-brand" href="index.php">Smarttech</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Basculer la navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="src/employees/list_employees.php">Gestion des Employés</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="src/clients/list_clients.php">Gestion des Clients</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="src/documents/list_documents.php">Gestion des Documents</a>
        </li>
      </ul>
      <span class="navbar-text">
        Connecté en tant que : <?= htmlspecialchars($_SESSION['admin']['email']) ?>
      </span>
      <a href="logout.php" class="btn btn-danger ml-3">Déconnexion</a>
    </div>
  </nav>

  <!-- Contenu principal -->
  <div class="container container-custom">
    <h1 class="mt-3">Bienvenue dans l'application Smarttech</h1>
    <p>Utilisez la barre de navigation pour accéder aux différentes fonctionnalités de gestion.</p>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
