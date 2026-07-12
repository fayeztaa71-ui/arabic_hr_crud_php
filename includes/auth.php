<?php
// includes/auth.php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (empty($_SESSION['user'])) {
    header("Location: /index.php?e=auth");
    exit;
}
