<?php
// src/documents/delete_document.php

require_once '../../config/db.php';
require_once '../../config/ftp.php';

if (!isset($_GET['id'])) {
    header("Location: list_documents.php");
    exit;
}

$id = $_GET['id'];
// Récupérer le document pour obtenir le chemin du fichier
$stmt = $pdo->prepare("SELECT * FROM documents WHERE id = ?");
$stmt->execute([$id]);
$document = $stmt->fetch();

if (!$document) {
    die("Document non trouvé");
}

// Connexion au serveur FTP pour supprimer le fichier associé
$ftp_conn = ftp_connect($ftp_server) or die("Impossible de se connecter à $ftp_server");
$login = ftp_login($ftp_conn, $ftp_user, $ftp_pass);
if (!$login) {
    die("Échec de l'authentification FTP.");
}
ftp_pasv($ftp_conn, true);

// Suppression du fichier sur le serveur FTP (optionnel)
ftp_delete($ftp_conn, $document['chemin_fichier']);
ftp_close($ftp_conn);

// Suppression de l'enregistrement dans la base de données
$stmt = $pdo->prepare("DELETE FROM documents WHERE id = ?");
$stmt->execute([$id]);

header("Location: list_documents.php");
exit;
?>
