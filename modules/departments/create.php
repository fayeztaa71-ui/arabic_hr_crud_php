<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';

$page_title = "إضافة قسم";
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name === '') {
        $err = '⚠️ يرجى إدخال اسم القسم';
    } else {
        $stmt = $pdo->prepare("INSERT INTO departments (name) VALUES (?)");
        $stmt->execute([$name]);
        header('Location: /arabic_hr_crud_php/modules/departments/index.php');
        exit;
    }
}

include __DIR__ . '/../../includes/header.php';
?>

<div class="container mt-4">
  <div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0"><i class="bi bi-plus-circle"></i> إضافة قسم جديد</h5>
    </div>
    <div class="card-body">
      <?php if ($err): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php echo htmlspecialchars($err); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
      <?php endif; ?>

      <form method="post">
        <div class="mb-3">
          <label class="form-label fw-bold required">اسم القسم</label>
          <input type="text" name="name" class="form-control" placeholder="أدخل اسم القسم" required>
        </div>
        <div class="d-flex justify-content-between">
          <a href="/arabic_hr_crud_php/modules/departments/index.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> رجوع
          </a>
          <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> حفظ
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
