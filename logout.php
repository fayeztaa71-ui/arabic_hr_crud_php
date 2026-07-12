<?php
require_once __DIR__ . '/config/config.php';
session_destroy();
header('Location: /arabic_hr_crud_php/index.php');
exit;
