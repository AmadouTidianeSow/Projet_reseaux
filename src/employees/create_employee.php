<?php
// src/employees/create_employee.php
require_once '../../config/db.php';
require_once '../../config/mail.php';
require_once '../../navebar.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom    = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email  = $_POST['email'];
    $poste  = $_POST['poste'];

    $sql = "INSERT INTO employees (nom, prenom, email, poste) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$nom, $prenom, $email, $poste])) {
        // Envoi de la notification par e-mail
        $subject = "Bienvenue chez Smarttech";
        $body = "<p>Bonjour {$prenom},</p>
                 <p>felicitation pour votre nouvau poste  chez Smarttech vous avez reussi votre entretien. Bienvenue dans l'equipe !</p>";
        sendNotification($email, $subject, $body);
        header("Location: list_employees.php");
        exit;
    } else {
        $error = "Erreur lors de l'ajout de l'employé.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un Employé</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>Ajouter un Employé</h1>
    <?php if(isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
    <form method="POST">
      <div class="form-group">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Prénom</label>
        <input type="text" name="prenom" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Poste</label>
        <input type="text" name="poste" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <br>
    <a href="list_employees.php" class="btn btn-secondary">Retour à la liste</a>
  </div>
</body>
</html>
