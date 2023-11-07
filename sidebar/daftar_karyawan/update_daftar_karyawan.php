<?php
session_start();
include "../../db_conn.php";
if (!isset($_SESSION["email"])) {
    header("Location: ../../index.php");
}
$id_karyawan = $no_ktp = $nama = $alamat = $telp = $email = $jenis_kelamin = '';

// Check if id_karyawan is provided in the query string
if (isset($_GET["id_karyawan"])) {
    $id_karyawan = $_GET["id_karyawan"];

    // Retrieve the data from the database for the given id_karyawan
    $query = "SELECT * FROM daftar_karyawan WHERE id_karyawan = '$id_karyawan'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Assign the retrieved data to variables
        $id_karyawan = $row["id_karyawan"];
        $no_ktp = $row["no_ktp"];
        $nama = $row["nama"];
        $alamat = $row["alamat"];
        $telp = $row["telp"];
        $email = $row["email"];
        $jenis_kelamin = $row["jenis_kelamin"];
    }
}

include"sql/update_daftar_karyawan.php";
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
    <script src="../../search/search.js"></script>
    <link rel="stylesheet" href="daftar.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
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
                    <input type="text" class="form-control" placeholder="Cari Berdasarkan Nama"
                        style="margin-top: 10px">
                    <div class="container">
                        <div class="text-center mb-4">
                            <h3 style="margin-top: 10px">Update Data</h3>
                            <p class="text-muted">Update Data Karyawan</p>
                        </div>
                    </div>
                    <div class="container d-flex justify-content-center">
                        <!-- Form -->
                        <form action="" method="post" enctype="multipart/form-data"
                            style="width:50vw; min-width:300px;">
                            <input type="hidden" name="id_karyawan" value="<?php echo $id_karyawan; ?>">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor KTP:</label>
                                    <input type="text" class="form-control" name="no_ktp" placeholder="NO KTP"
                                        maxlength="16" required value="<?php echo $no_ktp; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama:</label>
                                    <input type="text" class="form-control" name="nama" placeholder="Nama"
                                        maxlength="100" required value="<?php echo $nama; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Alamat:</label>
                                    <input type="text" class="form-control" name="alamat" placeholder="Alamat"
                                        maxlength="250" required value="<?php echo $alamat; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor Telefon:</label>
                                    <input type="tel" class="form-control" name="telp" placeholder="+62"
                                        pattern="[0-9]{1,15}" required value="<?php echo $telp; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email:</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email"
                                        maxlength="100" required value="<?php echo $email; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Kelamin:</label>
                                    <select class="form-control" name="jenis_kelamin" required>
                                        <option value="Laki-laki"
                                            <?php if ($jenis_kelamin === 'Laki-laki') echo 'selected'; ?>>Laki-laki
                                        </option>
                                        <option value="Perempuan"
                                            <?php if ($jenis_kelamin === 'Perempuan') echo 'selected'; ?>>Perempuan
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="text-center">
                                <br>
                                <button type="button" class="btn btn-dark btn-secondary" id="btnCancel"
                                    style="color:#FFF6E0">Batal</button>
                                <button type="submit" class="btn btn-dark btn-success" name="submit"
                                    style="color:#FFF6E0">Simpan</button>
                                <br><br>
                            </div>
                        </form>
                    </div>
                    <table class="table table-hover text-center" style="background-color:#FFFFFF" id="table-container">
                        <colgroup>
                            <col style="width: 5%">
                            <col style="width: 25%">
                            <col style="width: 15%">
                            <col style="width: 25%">
                            <col style="width: 15%">
                            <col style="width: 15%">
                        </colgroup>
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Nomor KTP</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Nomor Telepon</th>
                                <th scope="col">Email</th>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // JavaScript code to handle the cancel button click event
    document.getElementById("btnCancel").addEventListener("click", function() {
        window.location.href = "daftar_karyawan.php";
    });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const rows = document.querySelectorAll("tbody tr");
        const noDataMessage = document.getElementById("noDataMessage");
        const originalData = []; // Array untuk menyimpan data asli

        // Fungsi untuk menyimpan data asli
        rows.forEach((row) => {
            originalData.push(row);
        });
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
    // search
    let timeoutId;
    const searchInput = document.querySelector(".form-control");
    searchInput.addEventListener("input", delayedSearch);
    searchKaryawan();
    </script>
</body>

</html>