<?php
require_once __DIR__ . '/user-auth.php';

if (!is_logged_in()) {
  header('Location: ../idm250-sir/user/login.php');
  exit;
}
