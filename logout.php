<?php
require_once 'auth.php';

logout_user();
header('../idm250-sir/login.php');
exit;