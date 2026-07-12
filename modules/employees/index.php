<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';
$page_title = "الموظفون";

// جلب الأقسام للفلاتر
$dept_stmt = $pdo->query("SELECT id, name FROM departments ORDER BY name");
$departments = $dept_stmt->fetchAll();

// فلاتر
$q = trim($_GET['q'] ?? '');
$department_id = $_GET['department_id'] ?? '';
$salary_min = $_GET['salary_min'] ?? '';
$salary_max = $_GET['salary_max'] ?? '';

$sql = "SELECT e.*, d.name AS dept 
        FROM employees e 
        LEFT JOIN departments d ON d.id = e.department_id 
        WHERE 1=1";
$params = [];

// بحث عام
if ($q !== '') {
    $sql .= " AND (e.full_name LIKE ? OR e.email LIKE ? OR e.phone LIKE ? OR d.name LIKE ?)";
    $params = array_merge($params, ["%$q%","%$q%","%$q%","%$q%"]);
}
// فلتر القسم
if ($department_id !== '') {
    $sql .= " AND e.department_id = ?";
    $params[] = $department_id;
}
// فلتر الراتب الأدنى
if ($salary_min !== '') {
    $sql .= " AND e.salary >= ?";
    $params[] = (float)$salary_min;
}
// فلتر الراتب الأعلى
if ($salary_max !== '') {
    $sql .= " AND e.salary <= ?";
    $params[] = (float)$salary_max;
}

$sql .= " ORDER BY e.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();

include __DIR__ . '/../../includes/header.php';
?>

<div class="d-flex justify-content-between mb-3">
  <h1 class="h4">الموظفون</h1>
  <div>
    <a class="btn btn-primary" href="/arabic_hr_crud_php/modules/employees/create.php">+ موظف جديد</a>
    <a class="btn btn-success" href="export_csv.php?<?php echo http_build_query($_GET); ?>"> تصدير CSV</a>
    <button class="btn btn-info" onclick="window.print()"> طباعة</button>
  </div>
</div>

<form class="row g-2 mb-3">
  <div class="col-md-3">
    <input class="form-control" name="q" placeholder="ابحث بالاسم/الإيميل/الهاتف/القسم..." value="<?php echo htmlspecialchars($q); ?>"/>
  </div>
  <div class="col-md-2">
    <select name="department_id" class="form-select">
      <option value="">-- كل الأقسام --</option>
      <?php foreach ($departments as $d): ?>
        <option value="<?php echo $d['id']; ?>" <?php if ($department_id==$d['id']) echo 'selected'; ?>>
          <?php echo htmlspecialchars($d['name']); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-2">
    <input type="number" step="0.01" class="form-control" name="salary_min" placeholder="راتب من" value="<?php echo htmlspecialchars($salary_min); ?>"/>
  </div>
  <div class="col-md-2">
    <input type="number" step="0.01" class="form-control" name="salary_max" placeholder="راتب إلى" value="<?php echo htmlspecialchars($salary_max); ?>"/>
  </div>
  <div class="col-md-2">
    <button class="btn btn-outline-secondary w-100">بحث</button>
  </div>
</form>

<div class="card">
  <div class="table-responsive">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th>#</th><th>الاسم الكامل</th><th>الإيميل</th><th>الهاتف</th>
          <th>القسم</th><th>تاريخ التعيين</th><th>الراتب</th><th>إجراءات</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $r): 
            $row_class = '';
            if ($r['salary'] >= 5000) $row_class = 'table-success';
            elseif ($r['dept'] === 'المحاسبة') $row_class = 'table-info';
        ?>
        <tr class="<?php echo $row_class; ?>">
          <td><?php echo (int)$r['id']; ?></td>
          <td><?php echo htmlspecialchars($r['full_name']); ?></td>
          <td><?php echo htmlspecialchars($r['email']); ?></td>
          <td><?php echo htmlspecialchars($r['phone']); ?></td>
          <td><?php echo htmlspecialchars($r['dept'] ?? '—'); ?></td>
          <td><?php echo htmlspecialchars($r['hire_date']); ?></td>
          <td><?php echo htmlspecialchars(number_format((float)$r['salary'], 2)); ?></td>
          <td>
            <a class="btn btn-sm btn-warning" href="/arabic_hr_crud_php/modules/employees/edit.php?id=<?php echo $r['id']; ?>">تعديل</a>
            <a class="btn btn-sm btn-danger" onclick="return confirm('حذف الموظف؟');" href="/arabic_hr_crud_php/modules/employees/delete.php?id=<?php echo $r['id']; ?>">حذف</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
