<?php
require_once '../lib/user-auth.php';

logout_user();
header('Location: ../user/login.php');
exit;
