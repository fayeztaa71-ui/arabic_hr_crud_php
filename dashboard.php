<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/auth.php';
$page_title = "لوحة التحكم";

$stats = [
  'employees' => $pdo->query("SELECT COUNT(*) AS c FROM employees")->fetch()['c'] ?? 0,
  'departments' => $pdo->query("SELECT COUNT(*) AS c FROM departments")->fetch()['c'] ?? 0,
];

include __DIR__ . '/includes/header.php';
?>

<div class="row g-4">
  <div class="col-md-6 col-lg-4">
    <div class="card border-0 shadow-sm text-center py-4 hover-shadow">
      <div class="card-body">
        <i class="bi bi-people-fill display-4 text-primary mb-2"></i>
        <h5 class="text-muted">عدد الموظفين</h5>
        <div class="display-5 fw-bold"><?php echo (int)$stats['employees']; ?></div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-lg-4">
    <div class="card border-0 shadow-sm text-center py-4 hover-shadow">
      <div class="card-body">
        <i class="bi bi-building display-4 text-success mb-2"></i>
        <h5 class="text-muted">عدد الأقسام</h5>
        <div class="display-5 fw-bold"><?php echo (int)$stats['departments']; ?></div>
      </div>
    </div>
  </div>
</div>

<div class="card mt-5 border-0 shadow-sm">
  <div class="card-body">
    <h4 class="mb-3">روابط سريعة</h4>
    <div class="d-flex flex-wrap gap-2">
      <a class="btn btn-primary btn-lg" href="/arabic_hr_crud_php/modules/employees/create.php">+ إضافة موظف</a>
      <a class="btn btn-outline-primary btn-lg" href="/arabic_hr_crud_php/modules/departments/create.php">+ إضافة قسم</a>
      <a class="btn btn-outline-success btn-lg" href="/arabic_hr_crud_php/modules/departments/index.php">عرض الأقسام</a>
      <a class="btn btn-outline-info btn-lg" href="/arabic_hr_crud_php/modules/employees/index.php">عرض الموظفين</a>
    </div>
  </div>
</div>

<style>
.hover-shadow:hover {
  transform: translateY(-5px);
  transition: all 0.3s ease;
  box-shadow: 0 0.75rem 1.5rem rgba(0,0,0,0.15) !important;
}
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
