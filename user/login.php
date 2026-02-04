<?php
require_once '../lib/user-auth.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  if (login_user($email, $password)) {
    header('Location: ../index.php?view=sku');
    exit;
  } else {
    $error = 'Invalid email or password';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="../styles.css">
</head>
<body>
  <main class="main-content" style="margin-left:0; max-width:400px;">
    <h1>Login</h1>

    <form method="POST">
      <div class="form-item">
        <label>Email</label>
        <input type="email" name="email" required>
      </div>

      <div class="form-item">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>

      <?php if ($error): ?>
        <p style="color:red;"><?= $error ?></p>
      <?php endif; ?>

      <button class="primary-btn" type="submit">
        Log In
      </button>
    </form>
  </main>
</body>
</html>
