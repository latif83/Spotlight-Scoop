<?php

$success_message = '';
$error_message = '';

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username == "Spotlight_Admin" && $password = "justPassword"){
        $success_message = "Login Successful...Redirecting";

        ?>

        <script>
            setTimeout(() => {

                location.href = "dashboard.php"
                
            }, 2000);
        </script>

        <?php

    }
    else{
        $error_message = "Invalid username or password, please try again";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Spotlight Scoop Admin Login</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <style>
        body {
            background-color: #020d18;
        }
 
    </style>
</head>
<body>
    <div class="container h-100 d-flex align-items-center justify-content-center mt-5 pt-5">

        <div class="row w-100 justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-light text-center">
                        <h3 class="mb-0">Spotlight Scoop Admin Login</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">

                        <?php

if($success_message){
    ?>

<div class="alert alert-primary alert-dismissible fade show" role="alert">
<?= $success_message; ?>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

    <?php
}  elseif($error_message){
    ?>

<div class="alert alert-danger alert-dismissible fade show" role="alert">
<?= $error_message; ?>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

    <?php
}

?>
                            <div class="form-group mb-3">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" name="login" class="btn w-100 btn-dark btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>