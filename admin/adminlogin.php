<?php
require_once "dbconnect.php";

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $adminInfo = $stmt->fetch();

    if($adminInfo) {
        if(password_verify($password, $adminInfo["password"])) {
            echo "<script>alert('Login successful!');</script>";
        } else {
            $errorMessage = "Email or password might be incorrect!";
        }
    } else {
        $errorMessage = "Email or password might be incorrect!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #a8edea, #fed6e3);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-card {
            background: #ffffffee;
            border-radius: 16px;
            padding: 40px 35px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-card h3 {
            color: #333;
        }

        .form-label {
            color: #444;
            font-weight: 500;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #38b6ff;
            box-shadow: 0 0 0 0.2rem rgba(56, 182, 255, 0.25);
        }

        .btn-custom {
            background-color: #38b6ff;
            color: #fff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #1da1f2;
        }

        .alert-danger {
            background-color: #ffcdd2;
            border: none;
            color: #b71c1c;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h3 class="text-center mb-4"><i class="bi bi-person-circle me-2"></i>Admin Login</h3>

    <form action="adminlogin.php" method="post">
        <?php if(isset($errorMessage)): ?>
            <div class="alert alert-danger"><?= $errorMessage ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="email" class="form-label">Email <i class="bi bi-envelope-fill"></i></label>
            <input type="email" class="form-control" name="email" placeholder="Enter email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password <i class="bi bi-lock-fill"></i></label>
            <input type="password" class="form-control" name="password" placeholder="Enter password" required>
        </div>

        <button type="submit" class="btn btn-custom w-100" name="login">
            <i class="bi bi-box-arrow-in-right me-1"></i> Login
        </button>
    </form>
</div>

</body>
</html>
