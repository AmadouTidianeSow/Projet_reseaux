<?php
// src/employees/update_employee.php
require_once '../../navebar.php';
require_once '../../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: list_employees.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->execute([$id]);
$employee = $stmt->fetch();

if (!$employee) {
    die("Employé non trouvé");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom    = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email  = $_POST['email'];
    $poste  = $_POST['poste'];

    $sql = "UPDATE employees SET nom = ?, prenom = ?, email = ?, poste = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$nom, $prenom, $email, $poste, $id])) {
        header("Location: list_employees.php");
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
  <title>Modifier un Employé</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>Modifier un Employé</h1>
    <?php if(isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
    <form method="POST">
      <div class="form-group">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" value="<?= $employee['nom'] ?>" required>
      </div>
      <div class="form-group">
        <label>Prénom</label>
        <input type="text" name="prenom" class="form-control" value="<?= $employee['prenom'] ?>" required>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= $employee['email'] ?>" required>
      </div>
      <div class="form-group">
        <label>Poste</label>
        <input type="text" name="poste" class="form-control" value="<?= $employee['poste'] ?>">
      </div>
      <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
    <br>
    <a href="list_employees.php" class="btn btn-secondary">Retour à la liste</a>
  </div>
</body>
</html>
