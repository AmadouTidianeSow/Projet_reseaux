<?php
// src/employees/delete_employee.php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require_once '../../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: list_employees.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM employees WHERE id = ?");
$stmt->execute([$id]);
header("Location: list_employees.php");
exit;
?>
