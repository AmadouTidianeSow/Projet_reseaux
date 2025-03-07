<?php
// src/documents/create_document.php
require_once '../../navebar.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/db.php';
require_once '../../config/ftp.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';
    $description = $_POST['description'] ?? '';

    // Vérifier qu'un fichier a été sélectionné
    if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['document'];
        $file_name = basename($file['name']);

        // Optionnel : vérifier la taille du fichier, ici limite à 10 Mo
        if ($file['size'] > 10 * 1024 * 1024) {
            $message = "Le fichier est trop volumineux (max 10 Mo).";
        } else {
            // Vous pouvez adapter ce chemin (par exemple ajouter un sous-dossier par date, etc.)
            $remote_dir = $ftp_upload_dir . "documents/";

            // Connexion au serveur FTP
            $ftp_conn = ftp_connect($ftp_server, $ftp_port, 10);
            if (!$ftp_conn) {
                die("Erreur : Impossible de se connecter au serveur FTP.");
            }

            // Authentification
            $login = ftp_login($ftp_conn, $ftp_user, $ftp_pass);
            if (!$login) {
                ftp_close($ftp_conn);
                die("Erreur : Échec de l'authentification FTP.");
            }
            ftp_pasv($ftp_conn, true);

            // Vérifier si le dossier distant existe
            if (!@ftp_chdir($ftp_conn, $remote_dir)) {
                // Le dossier n'existe pas, on tente de le créer
                if (!ftp_mkdir($ftp_conn, $remote_dir)) {
                    ftp_close($ftp_conn);
                    die("Erreur : Impossible de créer le dossier distant: " . $remote_dir);
                }
            }
           ftp_chdir($ftp_conn, "/");

            $remote_file = $remote_dir . $file_name;

            // Transférer le fichier en mode binaire
            if (ftp_put($ftp_conn, $remote_file, $file['tmp_name'], FTP_BINARY)) {
                // Enregistrer le document dans la base de données avec le chemin distant
                $sql = "INSERT INTO documents (titre, description, chemin_fichier) VALUES (?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                if ($stmt->execute([$titre, $description, $remote_file])) {
                    $message = "Document uploadé et enregistré avec succès.";
                } else {
                    $message = "Upload réussi mais erreur lors de l'enregistrement en base.";
                }
            } else {
                $message = "Erreur lors du transfert du fichier via FTP.";
            }
            ftp_close($ftp_conn);
        }
    } else {
        $message = "Aucun fichier sélectionné ou erreur de transfert.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un Document</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>Ajouter un Document</h1>
    <?php if (!empty($message)) { echo "<div class='alert alert-info'>$message</div>"; } ?>
    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label>Titre</label>
        <input type="text" name="titre" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control"></textarea>
      </div>
      <div class="form-group">
        <label>Fichier</label>
        <input type="file" name="document" class="form-control-file" required>
      </div>
      <button type="submit" class="btn btn-primary">Ajouter le Document</button>
    </form>
    <br>
    <a href="list_documents.php" class="btn btn-secondary">Retour à la liste</a>
  </div>
</body>
</html>
