<?php
session_start();
require "db.php";

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $email === '' || $password === '') {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $error = "Username or email already exists.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hash]);
            $success = "Account created! You can now log in.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register - SessionAuthSystem</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-primary">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card shadow border-0 rounded-4 p-4" style="width:100%;max-width:400px;">
    <div class="text-center mb-4">
      <h3 class="fw-bold mt-2 mb-0">Create Account</h3>
      <small class="text-muted">Sign up to get started</small>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="alert alert-success py-2"><i class="bi bi-check-circle me-1"></i><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="mb-3">
        <label class="form-label fw-semibold">Username</label>
        <div class="input-group">
          <span class="input-group-text"></span>
          <input type="text" name="username" class="form-control" placeholder="Enter username" required>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label fw-semibold">Email Address</label>
        <div class="input-group">
          <span class="input-group-text"></span>
          <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label fw-semibold">Password</label>
        <div class="input-group">
          <span class="input-group-text"></span>
          <input type="password" name="password" class="form-control" placeholder="Create a password" required>
        </div>
      </div>
      <button type="submit" class="btn btn-success w-100 py-2">Register</button>
    </form>

    <p class="text-center text-muted mt-3 mb-0">Already have an account? <a href="index.php">Login here</a></p>
  </div>
</div>
</body>
</html>
