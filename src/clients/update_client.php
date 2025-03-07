<?php
// src/clients/update_client.php
require_once '../../navebar.php';
require_once '../../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: list_clients.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
$stmt->execute([$id]);
$client = $stmt->fetch();

if (!$client) {
    die("Client non trouvé");
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom       = $_POST['nom'];
    $email     = $_POST['email'];
    $telephone = $_POST['telephone'];

    $sql = "UPDATE clients SET nom = ?, email = ?, telephone = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$nom, $email, $telephone, $id])) {
        header("Location: list_clients.php");
        exit;
    } else {
        $error = "Erreur lors de la mise à jour.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier un Client</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>Modifier un Client</h1>
    <?php if($error) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
    <form method="POST">
      <div class="form-group">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($client['nom']) ?>" required>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($client['email']) ?>" required>
      </div>
      <div class="form-group">
        <label>Téléphone</label>
        <input type="text" name="telephone" class="form-control" value="<?= htmlspecialchars($client['telephone']) ?>">
      </div>
      <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
    <br>
    <a href="list_clients.php" class="btn btn-secondary">Retour à la liste</a>
  </div>
</body>
</html>
