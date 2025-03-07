<?php
// src/documents/update_document.php
require_once '../../navebar.php';
require_once '../../config/db.php';
require_once '../../config/ftp.php';



$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM documents WHERE id = ?");
$stmt->execute([$id]);
$document = $stmt->fetch();

if (!$document) {
    die("Document non trouvé");
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];

    // Si un nouveau fichier est uploadé, traiter l'upload FTP
    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
        $file = $_FILES['document'];
        
        // Connexion au serveur FTP
        $ftp_conn = ftp_connect($ftp_server) or die("Impossible de se connecter à $ftp_server");
        $login = ftp_login($ftp_conn, $ftp_user, $ftp_pass);
        if (!$login) {
            die("Échec de l'authentification FTP.");
        }
        ftp_pasv($ftp_conn, true);

        $remote_file = '/uploads/' . basename($file['name']);

        // Transfert du fichier en mode binaire
        if (ftp_put($ftp_conn, $remote_file, $file['tmp_name'], FTP_BINARY)) {
            // Mettre à jour la base avec le nouveau chemin du fichier
            $sql = "UPDATE documents SET titre = ?, description = ?, chemin_fichier = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$titre, $description, $remote_file, $id])) {
                $message = "Document mis à jour avec succès (nouveau fichier uploadé).";
            } else {
                $message = "Erreur lors de la mise à jour en base.";
            }
        } else {
            $message = "Erreur lors du transfert du fichier via FTP.";
        }
        ftp_close($ftp_conn);
    } else {
        // Mise à jour sans modification du fichier
        $sql = "UPDATE documents SET titre = ?, description = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$titre, $description, $id])) {
            $message = "Document mis à jour avec succès (sans modification du fichier).";
        } else {
            $message = "Erreur lors de la mise à jour en base.";
        }
    }
    
    // Rafraîchir les données du document après mise à jour
    $stmt = $pdo->prepare("SELECT * FROM documents WHERE id = ?");
    $stmt->execute([$id]);
    $document = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier un Document</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>Modifier un Document</h1>
    <?php if($message != "") { echo "<div class='alert alert-info'>$message</div>"; } ?>
    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label>Titre</label>
        <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($document['titre']) ?>" required>
      </div>
      <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control"><?= htmlspecialchars($document['description']) ?></textarea>
      </div>
      <div class="form-group">
        <label>Fichier Actuel</label>
        <p><?= htmlspecialchars($document['chemin_fichier']) ?></p>
      </div>
      <div class="form-group">
        <label>Changer le fichier (optionnel)</label>
        <input type="file" name="document" class="form-control-file">
      </div>
      <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
    <br>
    <a href="list_documents.php" class="btn btn-secondary">Retour à la liste</a>
  </div>
</body>
</html>
