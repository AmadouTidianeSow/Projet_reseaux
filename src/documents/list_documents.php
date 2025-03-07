<?php
// src/documents/list_documents.php
require_once '../../navebar.php';
require_once '../../config/db.php';
$stmt = $pdo->query("SELECT * FROM documents");
$documents = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des Documents</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>Liste des Documents</h1>
    <a href="create_document.php" class="btn btn-primary mb-3">Ajouter un Document</a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Titre</th>
          <th>Description</th>
          <th>Chemin Fichier</th>
          <th>Date d'Upload</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($documents as $doc): ?>
        <tr>
          <td><?= $doc['id'] ?></td>
          <td><?= $doc['titre'] ?></td>
          <td><?= $doc['description'] ?></td>
          <td><?= $doc['chemin_fichier'] ?></td>
          <td><?= $doc['date_creation'] ?></td>
          <td>
            <a href="update_document.php?id=<?= $doc['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
            <a href="delete_document.php?id=<?= $doc['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous supprimer ce document ?');">Supprimer</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="../../index.php" class="btn btn-secondary">Retour à l'accueil</a>
  </div>
</body>
</html>
