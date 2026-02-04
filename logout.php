<?php
require_once 'auth.php';

logout_user();
header('Location: ../idm250-sir/login.php');
exit;