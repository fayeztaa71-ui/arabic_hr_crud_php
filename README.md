# نظام إدارة الموظفين (PHP + MySQL) — عربي بالكامل

هذا مشروع جاهز كبداية لمتطلبات **Web Development (PHP + MySQL)**:
- استخدام **Frontend جاهز (Bootstrap RTL)**.
- Backend بـ **PHP + PDO**.
- عمليات **الإدخال، العرض، التعديل، الحذف، البحث** مكتملة.
- ربط بـ **MySQL**.
- يعمل على **XAMPP (سيرفر محلي)**.

## المتطلبات
- XAMPP (Apache + MySQL)
- PHP 8+ (يفضّل)
- مستعرض حديث

## خطوات التشغيل
1. انسخ المجلد إلى: `C:\xampp\htdocs\arabic_hr_crud_php` (أو على لينكس/ماك إلى مجلد الويب المناسب).
2. شغّل Apache و MySQL من XAMPP.
3. افتح phpMyAdmin وأنشئ قاعدة البيانات عبر استيراد الملف `db.sql` الموجود داخل المشروع.
4. افتح المتصفح على: `http://localhost/arabic_hr_crud_php/index.php`
5. بيانات الدخول:
   - المستخدم: **admin**
   - كلمة المرور: **admin123**

## بنية المشروع
```
/arabic_hr_crud_php
  config/config.php            # إعداد الاتصال بقاعدة البيانات + الجلسة
  includes/header.php          # رأس الصفحة + Bootstrap RTL
  includes/footer.php          # ذيل الصفحة
  includes/auth.php            # تحقق من تسجيل الدخول
  index.php                    # شاشة تسجيل الدخول
  dashboard.php                # لوحة التحكم + إحصائيات
  logout.php                   # تسجيل الخروج
  modules/
    departments/               # CRUD الأقسام + البحث
      index.php | create.php | edit.php | delete.php
    employees/                 # CRUD الموظفين + البحث
      index.php | create.php | edit.php | delete.php
  db.sql                       # ملف SQL لإنشاء وتعبئة قاعدة البيانات
  README-AR.md                 # هذا الملف
```

## ملاحظات أمنية سريعة
- تم استخدام **PDO مع معاملات محضّرة** لمنع SQL Injection.
- الجلسات مفعّلة؛ تأكد من تفعيل **cookies** في المتصفح.
- لتغيير كلمة مرور الأدمن، غيّرها من داخل الموقع ثم حدث الحقل في قاعدة البيانات.

---

## قالب تقرير التسليم (انسخه وعدّل عليه)

### 1) فكرة المشروع
نظام إدارة الموظفين يسمح بإدارة الأقسام والموظفين، مع وظائف إضافة/عرض/تعديل/حذف + البحث.

### 2) شرح قاعدة البيانات
- **users**: تخزين مستخدمي النظام (id, username, password_hash, role, created_at).
- **departments**: الأقسام (id, name).
- **employees**: الموظفون (id, full_name, email, phone, department_id, hire_date, salary).
- العلاقات: employees.department_id → departments.id (ON DELETE SET NULL).

### 3) الوظائف المنفّذة
- تسجيل الدخول والخروج.
- CRUD للأقسام + بحث بالاسم.
- CRUD للموظفين + بحث (الاسم/الإيميل/الهاتف/القسم).
- إحصائيات مبسطة في لوحة التحكم.

### 4) صور الشاشة (Screenshots)
(أدرج لقطات شاشة للصفحات الرئيسية، قائمة الموظفين، إضافة موظف، إلخ.)

### 5) بيئة التشغيل
- XAMPP 8.x (Apache + MySQL)
- PHP 8.x
- المتصفح: Chrome/Firefox

### 6) تعليمات التثبيت السريعة
مذكورة في الأعلى (README).

> **الأصالة**: الكود مكتوب من الصفر ويصلح كنقطة بداية لتطوير وظائف إضافية (صلاحيات، رفع ملفات، ترقيم الصفحات، إلخ).
