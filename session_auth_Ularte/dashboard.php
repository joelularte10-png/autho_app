<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$username = htmlspecialchars($_SESSION['username']);
$userId   = (int) $_SESSION['user_id'];
$sid      = session_id();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard - SessionAuthSystem</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand fw-bold" href="dashboard.php">SessionAuthSystem</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
      </ul>
      <span class="navbar-text text-white me-3"><?= $username ?></span>
      <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div  class="card g-5 ms-5 me-5 shadow-sm">
  <div class="col-md-12">
    <div class="card-body">
      <div class="mb-5">
        <h1 class="display-5 fw-bold text-primary">Welcome, <?= $username ?>!</h1>
        <p class="text-muted fs-5">This page is protected and only visible to logged-in users.</p>
        <a href="#details" class="btn btn-primary btn-lg">Explore Dashboard</a>
      </div>
    </div>
  </div>
</div>

</div>
  <div class="row g-4" id="details">
    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title text-success">Account Status</h5>
          <p class="card-text text-muted">Your session is active and protected against Session Fixation using <code>session_regenerate_id(true)</code>.</p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title text-primary">User Details</h5>
          <p class="mb-1"><strong>User ID:</strong> <?= $userId ?></p>
          <p class="mb-0"><strong>Username:</strong> <?= $username ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title text-warning">Active Session ID</h5>
          <p class="mb-1"><strong>Current Session ID:</strong></p>
          <code class="d-block text-break mb-2"><?= htmlspecialchars($sid) ?></code>
          <small class="text-muted">Generated after login call to <code>session_regenerate_id()</code></small>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
