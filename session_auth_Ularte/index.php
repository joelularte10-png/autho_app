<?php
session_start();
require "db.php";

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);   
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login - SessionAuthSystem</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-primary">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card shadow border-0 rounded-4 p-4" style="width:100%;max-width:400px;">
    <div class="text-center mb-4">
      <h3 class="fw-bold mt-2 mb-0">Welcome Back</h3>
      <small class="text-muted">Login to your account</small>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger py-2"><i class="bi bi-exclamation-circle me-1"></i><?= htmlspecialchars($error) ?></div>
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
        <label class="form-label fw-semibold">Password</label>
        <div class="input-group">
          <span class="input-group-text"></span>
          <input type="password" name="password" class="form-control" placeholder="Enter password" required>
        </div>
      </div>
      <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
    </form>

    <p class="text-center text-muted mt-3 mb-0">No account yet? <a href="register.php">Register here</a></p>
  </div>
</div>
</body>
</html>
