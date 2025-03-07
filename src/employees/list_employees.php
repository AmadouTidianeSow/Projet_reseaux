<?php
// src/employees/list_employees.php
require_once '../../navebar.php';
require_once '../../config/db.php';
$stmt = $pdo->query("SELECT * FROM employees");
$employees = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des Employés</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>Liste des Employés</h1>
    <a href="create_employee.php" class="btn btn-primary mb-3">Ajouter un Employé</a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Email</th>
          <th>Poste</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($employees as $employee): ?>
        <tr>
          <td><?= $employee['id'] ?></td>
          <td><?= $employee['nom'] ?></td>
          <td><?= $employee['prenom'] ?></td>
          <td><?= $employee['email'] ?></td>
          <td><?= $employee['poste'] ?></td>
          <td>
            <a href="update_employee.php?id=<?= $employee['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
            <a href="delete_employee.php?id=<?= $employee['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous supprimer cet employé ?');">Supprimer</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="../../index.php" class="btn btn-secondary">Retour à l'accueil</a>
  </div>
</body>
</html>
