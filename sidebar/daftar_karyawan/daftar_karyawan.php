<?php
session_start();
include "../../db_conn.php";
if (!isset($_SESSION["email"])) {
    header("Location: ../../index.php");
}
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
include "sql/daftar_karyawan.php";
if (isset($_GET['id_karyawan']) && !empty($_GET['id_karyawan'])) {
    $id_karyawan = $_GET['id_karyawan'];

    $sql = "DELETE FROM daftar_karyawan WHERE id_karyawan = '$id_karyawan'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION["delete_success"] = true;
        header("Location: daftar_karyawan.php");
        exit();
    } else {
        echo "Error deleting karyawan: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>main menu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script src="../../search/search.js"></script>
    <link rel="stylesheet" href="daftar.css">
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
                <!-- Content -->
                <main role="main" class="col-md-10 ml-sm-auto" style="background-color:whitesmoke">
                    <!-- Add a new button to toggle the form and buttons -->
                    <input autofocus type="text" class="form-control" placeholder="Cari Berdasarkan Nama"
                        style="margin-top: 10px">
                    <div class="custom-form-container" id="judulHlm">
                        <div class="container">
                            <div class="text-center mb-4">
                                <h3 style="margin-top: 20px;font-size:35px">Daftar Karyawan</h3>
                                <p class="text-muted" style="font-size:15px">Lihat Semua Daftar Karyawan Disini!</p>
                            </div>
                        </div>
                    </div>
                    <button id="btnTambahKaryawan" class="btn btn-dark btn-primary"
                        style="margin-bottom:10px;margin-top: 10px;color:#FFF6E0">Tambah Karyawan</button>
                    <div class="custom-form-container" id="formContainer" style="display:none;">
                        <div class="container">
                            <div class="text-center mb-4">
                                <h3 style="margin-top: 20px;font-size:35px;">Tambah Data</h3>
                                <p class="text-muted" style="font-size:15px">Tambah Data Karyawan</p>
                            </div>
                        </div>
                        <div class="row">
                            <div style="justify-content: center;display:flex">
                                <!-- Form -->
                                <form action="" method="post" enctype="multipart/form-data"
                                    style="width:50vw; min-width:300px;">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nomor KTP:</label>
                                            <input type="text" class="form-control" name="no_ktp" placeholder="NO KTP"
                                                maxlength="16" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nama:</label>
                                            <input type="text" class="form-control" name="nama" placeholder="Nama"
                                                maxlength="100" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Alamat:</label>
                                            <input type="text" class="form-control" name="alamat" placeholder="Alamat"
                                                maxlength="250" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nomor Telefon:</label>
                                            <input type="tel" class="form-control" name="telp" placeholder="+62"
                                                pattern="[0-9]{1,15}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email:</label>
                                            <input type="email" class="form-control" name="email" placeholder="Email"
                                                maxlength="100" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Jenis Kelamin:</label>
                                            <select class="form-control" name="jenis_kelamin" required>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="button" class="btn btn-dark btn-secondary" id="btnCancel"
                                            style="color:#FFF6E0">Batal</button>
                                        <button type="submit" class="btn btn-dark btn-success" name="submit"
                                            style="color:#FFF6E0">Tambah</button>
                                        <br><br>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>

                    <table class="table table-hover text-center" style="background-color:#FFFFFF" id="table-container">
                        <colgroup>
                            <col style="width: 5%">
                            <col style="width: 20%">
                            <col style="width: 15%">
                            <col style="width: 20%">
                            <col style="width: 15%">
                            <col style="width: 15%">
                            <col style="width: 10%">
                        </colgroup>
                        <thead class="table-dark" style="color:#FFF6E0">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Nomor KTP</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Nomor Telepon</th>
                                <th scope="col">Email</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="noDataMessage" style="display: none;">
                                <td colspan="7">No Data Available</td>
                            </tr>
                            <?php
                        $sql = "SELECT * FROM `daftar_karyawan`";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            $rowNumber = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $rowNumber++; ?></td>
                                <td><a href="view_karyawan.php?id_karyawan=<?php echo $row["id_karyawan"]; ?>"
                                        class="link-dark"><?php echo $row["nama"]; ?></a></td>
                                <td><?php echo $row["no_ktp"]; ?></td>
                                <td><?php echo $row["alamat"]; ?></td>
                                <td><?php echo $row["telp"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>

                                <td>
                                    <a href="update_daftar_karyawan.php?id_karyawan=<?php echo $row["id_karyawan"]; ?>"
                                        class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                                    <a href="#" class="link-dark" data-id="<?php echo $row['id_karyawan']; ?>"
                                        onclick="delete_karyawan(event)">
                                        <i class="fa-solid fa-trash fs-5"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        }
                        ?>
                        </tbody>
                    </table>
                </main>
            </div>
        </div>
    </main>

    <script src="function.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php
            if (isset($_SESSION["tambah_success"]) && $_SESSION["tambah_success"]) {
                echo 'successAlert();';
                unset($_SESSION["tambah_success"]);
            }
            ?>

        function successAlert() {
            Swal.fire(
                'Tambah Karyawan Berhasil!',
                'Data karyawan telah ditambahkan.',
                'success'
            );
        }
    });
    document.addEventListener("DOMContentLoaded", function() {
        <?php
            if (isset($_SESSION["update_success"]) && $_SESSION["update_success"]) {
                echo 'successUpdateAlert();';
                unset($_SESSION["update_success"]);
            }
            ?>

        function successUpdateAlert() {
            Swal.fire(
                'Update Data Karyawan Berhasil!',
                'Data karyawan Berhasil Diubah.',
                'success'
            );
        }
    });

    document.querySelector("a[href='../logout/logout.php']").addEventListener("click", function(event) {
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
            if (result.isConfirmed) {} else if (result.dismiss === Swal.DismissReason.cancel) {
                window.location.href = "../logout/logout.php";
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        <?php
            if (isset($_SESSION["delete_success"]) && $_SESSION["delete_success"]) {
                echo 'successDeleteAlert();';
                unset($_SESSION["delete_success"]);
            }
            ?>

        function successDeleteAlert() {
            Swal.fire(
                'Data Karyawan Terhapus!',
                'Data karyawan telah berhasil dihapus.',
                'success'
            );
        }
    });

    function delete_karyawan(event) {
        event.preventDefault(); // Prevent the default link behavior (page navigation)

        const karyawanId = event.currentTarget.getAttribute('data-id');

        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data karyawan akan dihapus. Tindakan ini tidak dapat diurungkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Batal',
            cancelButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                // User clicked Cancel, do nothing
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                window.location.href = `daftar_karyawan.php?id_karyawan=${karyawanId}`;
            }
        });
    }
    </script>
</body>

</html>