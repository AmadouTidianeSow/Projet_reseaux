<?php
// login.php
session_start();
require_once 'config/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Récupérer l'administrateur depuis la base
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();
    
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = $admin;
        header("Location: index.php");
        exit;
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion Administrateur</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>Connexion Administrateur</h1>
    <?php if ($error != ""): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" placeholder="admin@smarttech.sn" required>
      </div>
      <div class="form-group">
        <label>Mot de passe</label>
        <input type="password" name="password" class="form-control" placeholder="Votre mot de passe" required>
      </div>
      <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
  </div>
</body>
</html>
