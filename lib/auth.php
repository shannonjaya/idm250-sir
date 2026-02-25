<?php

// API KEY
require_once __DIR__ . '/db-connect.php';
function check_api_key($env) {
    $valid_api_key = $env['X_API_KEY'];
    $headers = getallheaders();
    $provided_key = null;
    
    foreach ($headers as $name => $value) {
        if(strtolower($name) === 'x-api-key') {
            $provided_key = $value;
            break;
        }
    }
    if ($provided_key !== $valid_api_key) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized', 'details' => 'Invalid API Key']);
        exit();
    }
}

// SESSIONS
if (!defined('API_REQUEST') && session_status() === PHP_SESSION_NONE) {
    session_start();
}

$USERS = [
    [
        'email' => 'ingrid@sir.com',
        'password' => '$2y$10$ykUfY/1kienmY3m.STG18OpHcBmKrT6e64mmhLg.zJnWk.7cYz.r.'
    ],
    [
        'email' => 'riley@sir.com',
        'password' => '$2y$10$8PwmuSfdboZoNhbV3z6vleZekdWcfUr4UScZeZrpnyLBpPwvuyyuq'
    ],
    [
        'email' => 'shannon@sir.com',
        'password' => '$2y$10$bBRUDQVLWrDZCj.Zj.I.0eIe6JSN2ODjzbYahrTh7Kum.eM1C07Iy'
    ]
];

function login_user($email, $password) {
  global $USERS;

  foreach ($USERS as $user) {
    if (
      $user['email'] === $email &&
      password_verify($password, $user['password'])
    ) {
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
