<?php

require "db/config.php";
session_start();

if (isset($_SESSION['login_status']) && $_SESSION['login_status'] === true) {
    header('location: index.php');
    exit;
}
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) && !empty(trim($_POST['name'])) ? $_POST['name'] : null;
    $email = isset($_POST['email']) && !empty(trim($_POST['email'])) ? $_POST['email'] : null;
    $password = isset($_POST['password']) && !empty(trim($_POST['password'])) ? $_POST['password'] : null;

    if (is_null($name)) {
        $name_error = "Name is required";
    }
    if (is_null($email)) {
        $email_error = "Email is required";
    }
    if (is_null($password)) {
        $password_error = "Password is required";
    }

    if (!is_null($name) && !is_null($email) && !is_null($password)) {
        $insert = $db->insert(
            'users',
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );
        $lastInsertId = $insert['lastInsertId'];
        $sql = "SELECT * FROM `users` WHERE id=$lastInsertId";
        $result = $db->rowsCount($sql);
        if ($result > 0) {
            $data = $db->find_data($sql);
            $_SESSION['login_status'] = true;
            $_SESSION['auth'] = $data;
            header("location: index.php");
        } else {
            $error = "Invalid Login Credentials";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/dist/img/favico.ico" type="image/ico" sizes="16x16">
    <title>Register || Food Online </title>
    <?php
    include 'include/css.php' ?>
</head>

<body class="hold-transition login-page">
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="javascript:;" class="h1">Food Online</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign Up to start your session</p>
            <?php
            if (!empty($error)) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
                <?php
            } ?>
            <form method="post">
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <span class="text-danger" role="alert">
                        <strong><?= isset($name_error) ? $name_error : '' ?></strong>
                    </span>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <span class="text-danger" role="alert">
                        <strong><?= isset($email_error) ? $email_error : '' ?></strong>
                    </span>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <span class="text-danger" role="alert">
                        <strong><?= isset($password_error) ? $password_error : '' ?></strong>
                    </span>
                <div class="row">
                    <div class="col-8">

                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <p class="mb-0">
                <a href="login.php" class="text-center">Sign In</a>
            </p>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->
<?php
include 'include/js.php' ?>
</body>

</html>
