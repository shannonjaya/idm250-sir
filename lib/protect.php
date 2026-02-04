<?php
require_once __DIR__ . '/user-auth.php';

if (!is_logged_in()) {
  header('Location: /login.php');
  exit;
}
