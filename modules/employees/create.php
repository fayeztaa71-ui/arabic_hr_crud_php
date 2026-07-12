<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';
$page_title = "إضافة موظف";
$err = '';
$deps = $pdo->query("SELECT id, name FROM departments ORDER BY name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = trim($_POST['full_name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $department_id = (int)($_POST['department_id'] ?? 0);
  $hire_date = $_POST['hire_date'] ?? null;
  $salary = (float)($_POST['salary'] ?? 0);

  if ($full_name === '' || $email === '') {
    $err = 'الاسم والإيميل مطلوبان';
  } else {
    $stmt = $pdo->prepare("INSERT INTO employees (full_name, email, phone, department_id, hire_date, salary) VALUES (?,?,?,?,?,?)");
    $stmt->execute([$full_name, $email, $phone, $department_id ?: null, $hire_date ?: null, $salary ?: null]);
    header('Location: /arabic_hr_crud_php/modules/employees/index.php'); exit;
  }
}

include __DIR__ . '/../../includes/header.php';
?>

<div class="container mt-4">
  <div class="card shadow-lg border-0 rounded-3">
    <div class="card-header bg-primary text-white d-flex align-items-center">
      <i class="fas fa-user-plus me-2"></i>
      <h5 class="mb-0">إضافة موظف جديد</h5>
    </div>
    <div class="card-body">
      
      <?php if ($err): ?>
        <div class="alert alert-danger">
          <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($err); ?>
        </div>
      <?php endif; ?>

      <form method="post">
        <div class="row g-3">

          <div class="col-md-6">
            <label class="form-label required">الاسم الكامل</label>
              <input name="full_name" class="form-control" required/>
          </div>

          <div class="col-md-6">
            <label class="form-label required">الإيميل</label>
              <input type="email" name="email" class="form-control" required/>
          </div>

          <div class="col-md-6">
            <label class="form-label">الهاتف</label>
              <input name="phone" class="form-control"/>
          </div>

          <div class="col-md-6">
            <label class="form-label">القسم</label>
            <select name="department_id" class="form-select">
              <option value="">— اختر القسم —</option>
              <?php foreach ($deps as $d): ?>
                <option value="<?php echo $d['id']; ?>"><?php echo htmlspecialchars($d['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">تاريخ التعيين</label>
            <input type="date" name="hire_date" class="form-control"/>
          </div>

          <div class="col-md-6">
            <label class="form-label">الراتب</label>
              <input type="number" step="0.01" name="salary" class="form-control"/>
          </div>

        </div>

        <div class="mt-4 d-flex justify-content-between">
          <a class="btn btn-secondary" href="/arabic_hr_crud_php/modules/employees/index.php">
            رجوع
          </a>
          <button class="btn btn-success">
            حفظ
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
