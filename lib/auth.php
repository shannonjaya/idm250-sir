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

function login_user($email, $password) {
  global $connection;

  $stmt = $connection->prepare("
      SELECT id, email, password_hash
      FROM idm250_user
      WHERE email = ?
      LIMIT 1
  ");

  if (!$stmt) {
    return false;
  }

  $stmt->bind_param('s', $email);
  $stmt->execute();

  $result = $stmt->get_result();

  if ($result && $result->num_rows === 1) {

      $user = $result->fetch_assoc();

      if (password_verify($password, $user['password_hash'])) {

          $_SESSION['user_id']    = $user['id'];
          $_SESSION['user_email'] = $user['email'];

          return true;
      }
  }

  return false;
}

function is_logged_in() {
  return isset($_SESSION['user_id']);
}

function logout_user() {
  session_destroy();
}
