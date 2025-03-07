<?php
// src/clients/create_client.php
require_once '../../navebar.php';
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom       = $_POST['nom'];
    $email     = $_POST['email'];
    $telephone = $_POST['telephone'];

    $sql = "INSERT INTO clients (nom, email, telephone) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$nom, $email, $telephone])) {
        header("Location: list_clients.php");
        exit;
    } else {
        $error = "Erreur lors de l'ajout du client.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un Client</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>Ajouter un Client</h1>
    <?php if(isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
    <form method="POST">
      <div class="form-group">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Téléphone</label>
        <input type="text" name="telephone" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <br>
    <a href="list_clients.php" class="btn btn-secondary">Retour à la liste</a>
  </div>
</body>
</html>
