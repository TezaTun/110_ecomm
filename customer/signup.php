<?php
if(isset($_SESSION))
{
    session_start();
}
require_once "../admin/dbconnect.php";

function isStrongPassword($password) {
    
    $digitalCount=0;
    $specCount=0;
    $capitalCount=0;

    foreach(str_split($password) as $letter) {
        if(ctype_digit($letter)) {
            $digitalCount++;
        }
        else if (preg_match('/[A-Za-z0-9]/', $letter)) {
            $specCount++;
        }
        else if(ctype_upper($letter)) {
            $capitalCount++;
        }
    }
    if($digitalCount >= 1 && $specCount >= 1 && $capitalCount >= 1) {
        return true;
    }
    else {
        return false;
}
}

function isLengthOK($password) {
    return strlen($password) >= 8;
}

if($_SERVER['REQUEST_METHOD'] == "POST" &&
isset($_POST['signUp']))
{
  $email =  $_POST['email'];
  $fullname =  $_POST['fullname'];
  $password =  $_POST['password'];
  $cpassword =  $_POST['cpassword'];
  $bdate =  $_POST['bdate'];
  $gender = $_POST['gender'];
  $city = $_POST['city'];
  $profile = $_FILES['profile'];

if($password !== $cpassword) {
    $errMessage = "Passwords do not match.";
  }
else{
  if(!isLengthOK($password)) {
    if(isStrongPassword($password)) 
        {
            echo "Strong password";
        }
  else{
    $errMessage = "Password must be strong.";
    echo "$errMessage";
  }
}
}

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once"navi.php"?>

        </div>
        <div class="row">
            <div class="col-md-8 mx-auto py-5">
                <form action="signup.php" class="form" method="post" enctype="multipart/form-data">
                            <div class="row">   
                            <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="from-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" required placeholder="abc@gmail.com">
                            </div>
                            <div class="mb-3">
                                <label for="fullname" class="from-label">Full name</label>
                                <input type="fullname" class="form-control" name="fullname" id="fullname" required placeholder="Apple">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="from-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" required placeholder="Apple123">
                            </div>
                            <div class="mb-3">
                                <label for="cpassword" class="from-label">Comfirm Password</label>
                                <input type="password" class="form-control" name="cpassword" id="cpassword" required placeholder="apple123">
                            </div>
                            </div>

                            <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bdate" class="form-label">Birth Date</label>
                                <input type="date" class="form-control" name="bdate" id="bdate">
                            </div>
                            <div class="form-check mb-1">
                                <input type="radio" class="form-check-input" name="gender" id="gender">
                                <label for="gender" class="form-check-label" value="male">Male</label>
                            </div>
                            <div class="form-check mb-3">
                                <input type="radio" class="form-check-input" name="gender" id="gender">
                                <label for="gneder" class="form-check-label" value="female">Female</label>
                            </div>
                            <p>City</p>
                            <div class="mb-3">
                                <select name="city" id="city" class="form-select">
                                    <option value="ygn">Yangone</option>
                                    <option value="mdy">Mandalay</option>
                                    <option value="tgi">Taunggyi</option>
                                    <option value="kll">KalarLayYekKwat</option>
                                    <option value="sty">Sittway</option>
                                </select>
        </div>
        <div class="mb-3">
            <label for="profile" class="form-control">Choose Profile Picture</label>
            <input type="file" class="form-control" id="profile" name="profile">
        </div>
        <button class="btn btn-outline-primary mb-3" type="submit" name="signUp">Sign Up</button>
        </div>
        </div>
        </form>
        </div>
        </div>
        </div>
</body>
</html>