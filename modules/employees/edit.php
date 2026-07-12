<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->execute([$id]);
$emp = $stmt->fetch();
if (!$emp) { die("الموظف غير موجود"); }

$page_title = "تعديل موظف";
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
    $stmt = $pdo->prepare("UPDATE employees SET full_name=?, email=?, phone=?, department_id=?, hire_date=?, salary=? WHERE id=?");
    $stmt->execute([$full_name, $email, $phone, $department_id ?: null, $hire_date ?: null, $salary ?: null, $id]);
    header('Location: /arabic_hr_crud_php/modules/employees/index.php'); exit;
  }
}

include __DIR__ . '/../../includes/header.php';
?>

<div class="container mt-4">
  <div class="card shadow-lg border-0 rounded-3">
    <div class="card-header bg-warning text-dark d-flex align-items-center">
      <i class="fas fa-user-edit me-2"></i>
      <h5 class="mb-0">تعديل بيانات الموظف</h5>
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
              <input name="full_name" class="form-control" required value="<?php echo htmlspecialchars($emp['full_name']); ?>"/>
          </div>

          <div class="col-md-6">
            <label class="form-label required">الإيميل</label>
              <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($emp['email']); ?>"/>
          </div>

          <div class="col-md-6">
            <label class="form-label">الهاتف</label>
              <input name="phone" class="form-control" value="<?php echo htmlspecialchars($emp['phone']); ?>"/>
          </div>

          <div class="col-md-6">
            <label class="form-label">القسم</label>
            <select name="department_id" class="form-select">
              <option value="">— اختر القسم —</option>
              <?php foreach ($deps as $d): ?>
                <option value="<?php echo $d['id']; ?>" <?php echo ($emp['department_id']==$d['id'])?'selected':''; ?>>
                  <?php echo htmlspecialchars($d['name']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">تاريخ التعيين</label>
            <input type="date" name="hire_date" class="form-control" value="<?php echo htmlspecialchars($emp['hire_date']); ?>"/>
          </div>

          <div class="col-md-6">
            <label class="form-label">الراتب</label>
              <input type="number" step="0.01" name="salary" class="form-control" value="<?php echo htmlspecialchars($emp['salary']); ?>"/>
          </div>

        </div>

        <div class="mt-4 d-flex justify-content-between">
          <a class="btn btn-secondary" href="/arabic_hr_crud_php/modules/employees/index.php">
         إلغاء
          </a>
          <button class="btn btn-warning text-dark">
           تحديث
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
