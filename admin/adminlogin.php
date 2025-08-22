<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "dbconnect.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $adminInfo = $stmt->fetch();

    if ($adminInfo && password_verify($password, $adminInfo["password"])) {
        $_SESSION['loginSuccess'] = true;
        $_SESSION['email'] = $email;
        header("Location: viewProduct.php");
        exit;
    } else {
        $errorMessage = "Email or password is incorrect!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(to right, #a8edea, #fed6e3);">

<div class="container py-5">
    <div class="row"><?php include("navbarcopy.php"); ?></div>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-center mb-4">Admin Login</h3>
                <form method="post" action="adminlogin.php">
                    <?php if (isset($errorMessage)): ?>
                        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
