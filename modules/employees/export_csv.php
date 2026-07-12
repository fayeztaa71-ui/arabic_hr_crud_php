<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="employees.csv"');

$output = fopen("php://output", "w");
fputcsv($output, ['ID','Full Name','Email','Phone','Department','Hire Date','Salary']);

// جلب نفس البيانات مع الفلاتر
$q = trim($_GET['q'] ?? '');
$department_id = $_GET['department_id'] ?? '';
$salary_min = $_GET['salary_min'] ?? '';
$salary_max = $_GET['salary_max'] ?? '';

$sql = "SELECT e.*, d.name AS dept 
        FROM employees e 
        LEFT JOIN departments d ON d.id = e.department_id 
        WHERE 1=1";
$params = [];

if ($q !== '') {
    $sql .= " AND (e.full_name LIKE ? OR e.email LIKE ? OR e.phone LIKE ? OR d.name LIKE ?)";
    $params = array_merge($params, ["%$q%","%$q%","%$q%","%$q%"]);
}
if ($department_id !== '') {
    $sql .= " AND e.department_id = ?";
    $params[] = $department_id;
}
if ($salary_min !== '') {
    $sql .= " AND e.salary >= ?";
    $params[] = (float)$salary_min;
}
if ($salary_max !== '') {
    $sql .= " AND e.salary <= ?";
    $params[] = (float)$salary_max;
}

$sql .= " ORDER BY e.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, [
        $row['id'],
        $row['full_name'],
        $row['email'],
        $row['phone'],
        $row['dept'],
        $row['hire_date'],
        $row['salary']
    ]);
}
fclose($output);
exit;
