<?php
// navbar.php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<!-- Début de la Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom">
  <a class="navbar-brand" href="/smrttech/index.php">Smarttech</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Basculer la navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/smarttech/src/employees/list_employees.php">Gestion des Employés</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/smarttech/src/clients/list_clients.php">Gestion des Clients</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/smarttech/src/documents/list_documents.php">Gestion des Documents</a>
      </li>
    </ul>
    <span class="navbar-text">
      Connecté en tant que : <?= htmlspecialchars($_SESSION['admin']['email']) ?>
    </span>
    <a href="/smarttech/logout.php" class="btn btn-danger ml-3">Déconnexion</a>
  </div>
</nav>
<!-- Fin de la Navbar -->

<!-- Style optionnel pour la navbar -->
<style>
  .navbar-custom {
    background-color: rgba(0, 0, 0, 0.7);
  }
  .navbar-custom .navbar-brand,
  .navbar-custom .nav-link,
  .navbar-custom .navbar-text {
    color: #fff;
  }
</style>
