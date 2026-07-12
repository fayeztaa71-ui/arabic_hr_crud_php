<?php
require_once __DIR__ . '/config/config.php';
if (!empty($_SESSION['user'])) { header('Location:/arabic_hr_crud_php/dashboard.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT id, username, password_hash, role FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user'] = ['id'=>$user['id'], 'username'=>$user['username'], 'role'=>$user['role']];
        header('Location: /arabic_hr_crud_php/dashboard.php'); exit;
    } else {
        $error = 'بيانات الدخول غير صحيحة';
    }
}
$page_title = "تسجيل الدخول";
include __DIR__ . '/includes/header.php';
?>

<div class="d-flex align-items-center justify-content-center" >
  <div class="col-md-6 col-lg-4">
    <div class="card shadow-lg border-0 rounded-4"  style="background: linear-gradient(135deg, #6C63FF 0%, #8F9EFF 100%);">
      <div class="card-body p-5">
        <h1 class="h4 mb-4 text-center fw-bold text-white ">تسجيل الدخول</h1>

        <?php if ($error): ?>
          <div class="alert alert-danger py-2"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post" novalidate>
          <div class="mb-3 position-relative">
            <label class="form-label fw-semibold required">اسم المستخدم</label>
            
<input type="text" name="username" class="form-control rounded-3 py-2 bg-white text-dark" placeholder="ادخل اسم المستخدم" required/>
          </div>

          <div class="mb-4 position-relative">
            <label class="form-label fw-semibold required">كلمة المرور</label>
<input type="password" name="password" class="form-control rounded-3 py-2 bg-white text-dark" placeholder="ادخل كلمة المرور" required/>
          </div>

<button class="btn btn-light w-100 py-2 fw-bold text-primary">دخول</button>
        </form>

        <p class="text-muted small mt-3 text-center">المستخدم الافتراضي: admin — كلمة المرور: admin123</p>
      </div>
    </div>
  </div>
</div>

<style>
.card:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
    box-shadow: 0 1rem 2rem rgba(0,0,0,0.2);
}
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
