<?php
session_start();
include "../../db_conn.php";
include "dashboard_control.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>main menu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>
    <main>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background-color: #272829 !important">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"
                    style="color:#FFF6E0;font-size:25px;font-family: Arial, Helvetica, sans-serif;padding-left:13px">C H
                    E C K - O N</a>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <nav id="sidebar" class="col-md-2 bg-dark text-light py-3"
                    style="background: repeating-linear-gradient(20deg, #272829, #61677A 398px) !important">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="../dashboard/dashboard.php" style="color:#FFF6E0">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../daftar_karyawan/daftar_karyawan.php" style="color:#FFF6E0">
                                    <i class="fas fa-users"></i> Daftar Karyawan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../absensi_karyawan/absensi_karyawan.php"
                                    style="color:#FFF6E0">
                                    <i class="fas fa-calendar-check"></i> Absensi Karyawan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../jadwal_kerja/jadwal_kerja.php" style="color:#FFF6E0">
                                    <i class="fas fa-calendar"></i> Jadwal Kerja
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../insentif/insentif.php" style="color:#FFF6E0">
                                    <i class="fas fa-gift"></i> Insentif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../rekap_absen/rekap_absen.php" style="color:#FFF6E0">
                                    <i class="fas fa-file-alt"></i> Rekap Absensi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../logout/logout.php" style="color:#FFF6E0"
                                    onclick="showLogoutAlert(event)">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <main role="main" class="col-md-10 ml-sm-auto"
                    style="background-color:whitesmoke;padding-right:0px !important; padding-left:0px !important">
                    <div class="custom-form-container" id="judulHlm">
                        <div class="container" style="padding-top:10px">
                            <div class="text-center mb-4">
                                <h3 style="margin-top: 10px;font-size:35px">Dashboard</h3>
                                <p class="text-muted" style="font-size:15px">Selamat Datang di CHECK-ON</p>
                            </div>
                        </div>
                    </div>
                    <div class="kotak"
                        style="background-color:#D8D9DA;height: 11vw;width:100%; text-align: center;color:#FFF6E0; margin-bottom:100px;">
                        <div class="container mt-5">
                            <div class="row justify-content-center">
                                <div class="col-md-4 mb-3">
                                    <a href="../daftar_karyawan/daftar_karyawan.php" class="card bg-dark text-light">
                                        <div class="card-body" style="background-color:#272829;color:#FFF6E0">
                                            <h5 class="card-title">Banyak Karyawan</h5>
                                            <i class="icon fas fa-users"></i>
                                            <p class="card-text"><?php echo $total_karyawan; ?></p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="../jadwal_kerja/jadwal_kerja.php" class="card bg-dark text-light">
                                        <div class="card-body" style="background-color:#272829;color:#FFF6E0">
                                            <h5 class="card-title">Jadwal Kerja</h5>
                                            <i class="icon fas fa-calendar"></i>
                                            <p class="card-text"><?php echo $total_jadwal; ?></p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="../insentif/insentif.php" class="card bg-dark text-light">
                                        <div class="card-body" style="background-color:#272829;color:#FFF6E0">
                                            <h5 class="card-title">Karyawan yang Mendapat Insentif</h5>
                                            <i class="icon fas fa-gift"></i>
                                            <p class="card-text"><?php echo $count_insentif; ?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer style="background-color:whitesmoke; color: black;">
                        <p>&copy; <?php echo date("Y"); ?> CHECK-ON. Built by Kelompok 5</p>
                    </footer>
                </main>
            </div>
        </div>
    </main>
    <script>
    function successAlert() {
        Swal.fire(
            'Login Berhasil!',
            'Selamat datang di dashboard!',
            'success'
        );
    }

    function showLogoutAlert(event) {
        event.preventDefault(); // Prevent default link behavior (page navigation)

        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Anda Akan Kembali Ke Laman Login",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33', // Merubah warna tombol confirm menjadi merah
            cancelButtonColor: '#3085d6', // Merubah warna tombol cancel menjadi biru
            confirmButtonText: 'Batal', // Merubah teks tombol confirm menjadi "Cancel"
            cancelButtonText: 'Logout' // Merubah teks tombol cancel menjadi "Yes, logout"
        }).then((result) => {
            if (result.isConfirmed) {
                // Tidak ada tindakan lanjutan karena tombol "Cancel" ditekan
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Jika tombol "Yes, logout" ditekan, maka diarahkan ke halaman logout
                window.location.href = "../logout/logout.php";
            }
        });
    }
    <?php
            if (isset($_SESSION["login_success"]) && $_SESSION["login_success"] === true) {
                unset($_SESSION["login_success"]);
                echo 'window.addEventListener("DOMContentLoaded", successAlert)';
            }
        ?>
    </script>
</body>

</html>