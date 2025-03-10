<?php
// src/documents/download_document.php
require_once '../../config/ftp.php';

if (!isset($_GET['file'])) {
    die("Fichier non spécifié.");
}

$file_path = $_GET['file']; // Le chemin distant complet, par exemple "/uploads/documents/nomdufichier.ext"

// Connexion au serveur FTP
$ftp_conn = ftp_connect($ftp_server, $ftp_port, 10);
if (!$ftp_conn) {
    die("Erreur : Impossible de se connecter au serveur FTP.");
}

$login = ftp_login($ftp_conn, $ftp_user, $ftp_pass);
if (!$login) {
    ftp_close($ftp_conn);
    die("Erreur : Échec de l'authentification FTP.");
}
ftp_pasv($ftp_conn, true);

// Création d'un fichier temporaire pour stocker le téléchargement
$tmp_file = tempnam(sys_get_temp_dir(), 'dl_');

if (!ftp_get($ftp_conn, $tmp_file, $file_path, FTP_BINARY)) {
    ftp_close($ftp_conn);
    unlink($tmp_file);
    die("Erreur lors du téléchargement du fichier depuis le serveur FTP.");
}

ftp_close($ftp_conn);

// Envoi des headers pour forcer le téléchargement
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($tmp_file));

// Lecture et envoi du contenu du fichier
readfile($tmp_file);

// Suppression du fichier temporaire
unlink($tmp_file);
exit;
?>
