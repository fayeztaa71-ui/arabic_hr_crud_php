<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title><?php echo isset($page_title) ? $page_title . " | " : ""; ?>نظام إدارة الموظفين</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Cairo', system-ui, -apple-system, Segoe UI, Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Liberation Sans', 'Apple Color Emoji','Segoe UI Emoji', 'Segoe UI Symbol'; background:#f8fafc; }
    .navbar-brand { font-weight:700; }
    .card { border-radius:1rem; }
    .form-label.required:after { content:" *"; color:#dc3545; }
    .table thead th { white-space: nowrap; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light border-bottom shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand" href="/arabic_hr_crud_php/dashboard.php">إدارة الموظفين</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="القائمة">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if (!empty($_SESSION['user'])): ?>
          <li class="nav-item"><a class="nav-link" href="/arabic_hr_crud_php/modules/employees/index.php">الموظفون</a></li>
          <li class="nav-item"><a class="nav-link" href="/arabic_hr_crud_php/modules/departments/index.php">الأقسام</a></li>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php if (!empty($_SESSION['user'])): ?>
          <li class="nav-item"><span class="nav-link">مرحبًا، <?php echo htmlspecialchars($_SESSION['user']['username']); ?></span></li>
          <li class="nav-item"><a class="nav-link text-danger" href="/arabic_hr_crud_php/logout.php">تسجيل الخروج</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="/arabic_hr_crud_php/index.php">تسجيل الدخول</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container my-4">
