<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';
$id = (int)($_GET['id'] ?? 0);
// منع الحذف إن كان مستخدماً في employees
$used = $pdo->prepare("SELECT COUNT(*) AS c FROM employees WHERE department_id = ?");
$used->execute([$id]);
if (($used->fetch()['c'] ?? 0) > 0) {
  die("لا يمكن حذف القسم لوجود موظفين مرتبطين به.");
}
$stmt = $pdo->prepare("DELETE FROM departments WHERE id = ?");
$stmt->execute([$id]);
header('Location: /arabic_hr_crud_php/modules/departments/index.php'); exit;
