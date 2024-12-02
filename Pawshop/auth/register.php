<?php
session_start();
require '../functions.php';

if (isset($_SESSION['login'])) {
  header('Location: /');
  exit;
}

if (isset($_POST["register"])) {
  if (register($_POST) > 0) {
    echo "
        <script>
            alert('User berhasil ditambahkan');
        </script>
        ";
    header("Location: login.php");
  } else {
    echo mysqli_error($conn);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../assets/img/halo.webp">
  <title>OldShop | Register Page</title>
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    /* Custom Gradient Background */
    body {
      background: linear-gradient(135deg, rgba(98, 33, 109, 1) 0%, rgba(70, 12, 66, 0.8) 25%, rgba(29, 8, 55, 1) 50%, rgba(55, 27, 73, 1) 75%, rgba(150, 23, 100, 0.8) 100%);
      color: #fff; /* Make all text white */
    }

    .container {
      max-width: 600px;
    }

    /* Card Style for Form */
    .form-container {
      background-color: rgba(255, 255, 255, 0.9); /* Slight transparency */
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      color: #333; /* Form text should be dark for readability */
    }

    h1 {
      color: #8A2BE2; /* Violet color for the title */
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
      color: #f44336; /* Red for error messages */
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
    <h1 class="text-center">Register</h1>
    <form action="" method="post" class="needs-validation form-container" novalidate>
      <div class="mb-3">
        <label for="firstname" class="form-label">Name</label>
        <div class="input-group">
          <input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name" required>
          <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name" required>
          <div class="invalid-feedback">
            Please enter your name.
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="Username here" autocomplete="username" required>
        <div class="invalid-feedback">
          Please enter your username.
        </div>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Email here" autocomplete="email" required>
        <div class="invalid-feedback">
          Please enter your email.
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
        <label for="password2" class="form-label">Confirm Password</label>
        <input type="password" name="password2" id="password2" class="form-control" required>
        <div class="invalid-feedback">
          Please confirm your password.
        </div>
      </div>
      <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
      <div class="mt-3 text-center">
        <a href="login.php" class="text-secondary">Already have an account? Login here</a>
      </div>
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
