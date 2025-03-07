<?php
// src/clients/list_clients.php
require_once '../../navebar.php';
require_once '../../config/db.php';
$stmt = $pdo->query("SELECT * FROM clients");
$clients = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des Clients</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>Liste des Clients</h1>
    <a href="create_client.php" class="btn btn-primary mb-3">Ajouter un Client</a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom</th>
          <th>Email</th>
          <th>Téléphone</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($clients as $client): ?>
        <tr>
          <td><?= $client['id'] ?></td>
          <td><?= $client['nom'] ?></td>
          <td><?= $client['email'] ?></td>
          <td><?= $client['telephone'] ?></td>
          <td>
            <a href="update_client.php?id=<?= $client['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
            <a href="delete_client.php?id=<?= $client['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous supprimer ce client ?');">Supprimer</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="../../index.php" class="btn btn-secondary">Retour à l'accueil</a>
  </div>
</body>
</html>
