<?php
session_start();
include "db_conn.php";

function checkLogin($conn, $email, $password)
{
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM `akun_admin` WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if ($password === $user['password']) {
            $_SESSION["email"] = $email;
            $_SESSION["login_success"] = true;
            return true;
        }
    }

    return false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Manajemen Karyawan</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>

<body
    style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: whitesmoke;">
    <div class="container"
        style="color: black; font-family: Arial, Helvetica, sans-serif; width: 50%; background-color: white; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); border-radius: 8px;">
        <div class="row justify-content-center" style="color: black;padding-top: 50px">

            <div class="col-5">
                <h3 style="text-align:center">C H E K - O N</h3>
                <img src="img/login_img.png" alt="Gender"
                    style="display: block; margin: 0 auto; width:150px; height:150px;margin-bottom:20px;margin-top:20px">
                <h3 style="text-align:center">Sistem Manajemen Karyawan</h3>
            </div>

            <div class="col-6">
                <div style="padding-bottom: 50px;">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="index.php">
                                <h2>Login !</h2> <br> <br>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter your email" required>
                                </div>
                                <div class="mb-3" style="margin-top: 20px;">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter your password" required>
                                </div>
                                <div class="d-grid" style="padding-top:10px">
                                    <button type="submit" class="btn btn-dark" name="submit">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
        function fireSweetAlert() {
            Swal.fire(
                'Login Gagal!',
                'Periksa Kembali Email dan Password Anda!',
                'error'
            );
        }

        function successLogin() {
            window.location.href = "sidebar/dashboard/dashboard.php";
        }

        <?php
            if (isset($_POST['submit'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                if (checkLogin($conn, $email, $password)) {
                    echo 'window.addEventListener("DOMContentLoaded", successLogin);';
                } else {
                    echo 'window.addEventListener("DOMContentLoaded", fireSweetAlert);';
                }
            }
        ?>
        </script>
</body>

</html>