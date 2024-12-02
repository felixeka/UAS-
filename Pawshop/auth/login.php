<?php
session_start();
require '../functions.php';

// Check cookies
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
  $id = $_COOKIE['id'];
  $key = $_COOKIE['key'];

  // Fetch username using id
  $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  // Check cookie and username
  if ($key === hash('sha256', $row['username'])) {
    $_SESSION['login'] = true;
    $_SESSION['user_id'] = $id;
  }
}

if (isset($_SESSION['login'])) {
  header('Location: /');
  exit;
}

if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Fetch user data using prepared statement
  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row["password"])) {
      // Set session
      $_SESSION["login"] = true;
      $_SESSION["user_id"] = $row["id"];
      $_SESSION["admin"] = $row['is_admin'] ? true : false;

      // Check remember me
      if (isset($_POST["remember"])) {
        // Set cookies for 1 week
        setcookie('id', $row['id'], time() + (7 * 24 * 60 * 60), "/");
        setcookie('key', hash('sha256', $row['username']), time() + (7 * 24 * 60 * 60), "/");
      }

      header("Location: /");
      exit;
    }
  }

  $error = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../assets/img/halo.webp">
  <title>OldShop | Login Page</title>
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    /* Custom Dark Background with Gradient */
    body {
      background: linear-gradient(135deg, rgba(98, 33, 109, 1) 0%, rgba(70, 12, 66, 0.8) 25%, rgba(29, 8, 55, 1) 50%, rgba(55, 27, 73, 1) 75%, rgba(150, 23, 100, 0.8) 100%);
      color: #fff; /* Ensure all body text is white */
    }

    .container {
      max-width: 500px;
    }

    /* Form Container Styling */
    .form-container {
      background-color: rgba(255, 255, 255, 0.9); /* Light opacity white background */
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      color: #333; /* Form text should be dark for readability */
    }

    h1 {
      color: #8A2BE2;
      font-family: 'Arial', sans-serif;
      margin-bottom: 30px;
    }

    /* Form Inputs Styling */
    .form-control {
      border-radius: 8px;
      border: 1px solid #ddd;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: #8A2BE2;
      box-shadow: 0 0 8px rgba(138, 43, 226, 0.6);
    }

    /* Button Styling */
    .btn-primary {
      background-color: #8A2BE2;
      border-color: #8A2BE2;
      border-radius: 8px;
      padding: 12px;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #6a1d9b;
      border-color: #6a1d9b;
    }

    .invalid-feedback {
      font-size: 0.875rem;
      color: #f44336; /* Error messages in red */
    }

    /* Hover Effects for Links */
    .text-secondary:hover {
      color: #8A2BE2;
      text-decoration: underline;
    }

    /* Responsive Adjustments */
    @media (max-width: 576px) {
      .form-container {
        padding: 20px;
      }

      h1 {
        font-size: 1.5rem;
      }
    }
  </style>
</head>

<body class="d-flex flex-column min-vh-100">
  <div class="container my-5">
    <h1 class="text-center">Login</h1>
    <form action="" method="post" class="needs-validation form-container" novalidate>
      <div class="mb-3">
        <label for="username" class="form-label">Username <span class="text-secondary"></span></label>
        <input type="text" name="username" id="username" class="form-control" placeholder="Username here" autocomplete="username" required>
        <div class="invalid-feedback">
          Please enter your username.
        </div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
        <div class="invalid-feedback">
          Please enter your password.
        </div>
      </div>
      <div class="mb-3">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember" class="form-label">Remember Me</label>
      </div>
      <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
      <div class="mt-3 text-center">
        <a href="register.php" class="text-secondary">Doesn't have an account? Register here</a>
      </div>
      <?php if (isset($error)): ?>
        <div class="alert alert-danger mt-3">Incorrect username or password</div>
      <?php endif; ?>
    </form>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <script>
    // Bootstrap form validation
    (function () {
      'use strict'

      var forms = document.querySelectorAll('.needs-validation')

      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }

            form.classList.add('was-validated')
          }, false)
        })
    })()
  </script>
</body>

</html>
