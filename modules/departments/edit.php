<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM departments WHERE id = ?");
$stmt->execute([$id]);
$dep = $stmt->fetch();

if (!$dep) {
    die("⚠️ القسم غير موجود");
}

$page_title = "تعديل قسم";
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name === '') {
        $err = '⚠️ الاسم مطلوب';
    } else {
        $stmt = $pdo->prepare("UPDATE departments SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);
        header('Location: /arabic_hr_crud_php/modules/departments/index.php');
        exit;
    }
}

include __DIR__ . '/../../includes/header.php';
?>

<div class="container mt-4">
  <div class="card shadow-sm border-0">
    <div class="card-header bg-warning text-dark">
      <h5 class="mb-0"><i class="bi bi-pencil-square"></i> تعديل القسم</h5>
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
          <input 
            type="text" 
            name="name" 
            class="form-control" 
            placeholder="أدخل اسم القسم" 
            required 
            value="<?php echo htmlspecialchars($dep['name']); ?>"
          >
        </div>

        <div class="d-flex justify-content-between">
          <a href="/arabic_hr_crud_php/modules/departments/index.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> إلغاء
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> تحديث
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
