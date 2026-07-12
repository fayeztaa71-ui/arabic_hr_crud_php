<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';
$page_title = "الأقسام";

$q = trim($_GET['q'] ?? '');
$sql = "SELECT * FROM departments";
$params = [];

if ($q !== '') { 
  $sql .= " WHERE name LIKE ?"; 
  $params[] = "%$q%"; 
}
$sql .= " ORDER BY id DESC";
$stmt = $pdo->prepare($sql); 
$stmt->execute($params);
$rows = $stmt->fetchAll();

include __DIR__ . '/../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h4 mb-0">
    <i class="bi bi-diagram-3 text-primary"></i> الأقسام
  </h1>
  <a class="btn btn-primary" href="/arabic_hr_crud_php/modules/departments/create.php">
    <i class="bi bi-plus-circle"></i> قسم جديد
  </a>
</div>

<form class="row g-2 mb-4">
  <div class="col-md-6">
    <div class="input-group">
      <input 
        class="form-control" 
        name="q" 
        placeholder="ابحث باسم القسم..." 
        value="<?php echo htmlspecialchars($q); ?>"/>
      <button class="btn btn-outline-secondary">
        <i class="bi bi-search"></i> بحث
      </button>
    </div>
  </div>
</form>

<div class="card shadow-sm border-0">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 60px;">#</th>
            <th>اسم القسم</th>
            <th class="text-center" style="width: 200px;">إجراءات</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($rows): ?>
            <?php foreach ($rows as $r): ?>
              <tr>
                <td><?php echo (int)$r['id']; ?></td>
                <td><?php echo htmlspecialchars($r['name']); ?></td>
                <td class="text-center">
                  <a class="btn btn-sm btn-warning me-1" 
                     href="/arabic_hr_crud_php/modules/departments/edit.php?id=<?php echo $r['id']; ?>">
                     تعديل
                  </a>
                  <a class="btn btn-sm btn-danger" 
                     onclick="return confirm('هل أنت متأكد من الحذف؟');" 
                     href="/arabic_hr_crud_php/modules/departments/delete.php?id=<?php echo $r['id']; ?>">
                    حذف
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="3" class="text-center text-muted py-4">
                لا توجد أقسام
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
