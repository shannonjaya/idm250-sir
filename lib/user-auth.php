<?php
session_start();

$USERS = [
  [
    'email' => 'admin@camfg.com',
    'password' => 'admin123'
  ]
];

function login_user($email, $password) {
  global $USERS;

  foreach ($USERS as $user) {
    if ($user['email'] === $email && $user['password'] === $password) {
      $_SESSION['user'] = [
        'email' => $email
      ];
      return true;
    }
  }
  return false;
}

function is_logged_in() {
  return isset($_SESSION['user']);
}

function logout_user() {
  session_destroy();
}
