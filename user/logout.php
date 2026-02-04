<?php
require_once '../lib/user-auth.php';

logout_user();
header('Location: ../idm250-sir/login.php');
exit;
