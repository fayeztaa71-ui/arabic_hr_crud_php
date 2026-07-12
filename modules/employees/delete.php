<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("DELETE FROM employees WHERE id = ?");
$stmt->execute([$id]);
header('Location: /arabic_hr_crud_php/modules/employees/index.php'); exit;
