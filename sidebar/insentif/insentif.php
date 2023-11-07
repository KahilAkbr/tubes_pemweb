<?php
session_start();
include "../../db_conn.php";
if (!isset($_SESSION["email"])) {
    header("Location: ../../index.php");
}
$sql = "SELECT * FROM kriteria_insentif";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Set the default values for the form inputs
$hadir = $row["hadir"];
$izin = $row["izin"];
$sakit = $row["sakit"];
$cuti = $row["cuti"];
$tanpa_keterangan = $row["tanpa_keterangan"];

include "update_status_insentif.php";
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
    <link rel="stylesheet" href="insentif.css">
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
                    <input type="text" class="form-control" placeholder="Cari Berdasarkan Nama"
                        style="margin-top: 10px">
                    <div class="custom-form-container" id="judulHlm">
                        <div class="container" style="padding-top:10px">
                            <div class="text-center mb-4">
                                <h3 style="margin-top: 10px;font-size:35px">Insentif Karyawan</h3>
                                <p class="text-muted" style="font-size:15px">Lihat dan Kelola Syarat Insentif Karyawan
                                </p>
                            </div>
                        </div>
                    </div>
                    <button id="btnTambahKaryawan" class="btn btn-dark btn-primary"
                        style="margin-bottom:10px;margin-top: 10px;color:#FFF6E0">Edit Kriteria</button>
                    <div class="custom-form-container" id="formContainer" style="display:none;">
                        <div class="container">
                            <div class="text-center mb-4">
                                <h3 style="margin-top: 20px;font-size:35px">Edit Kriteria Insentif</h3>
                                <p class="text-muted" style="font-size:15px">Edit Kriteria untuk Mendapatkan Insentif
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div style="justify-content: center;display:flex">
                                <!-- Form -->
                                <form action="" method="post" enctype="multipart/form-data"
                                    style="width:50vw; min-width:300px;">
                                    <div style="text-align:left">
                                        <h7>Catatan: <br> Form Hadir Diisi dengan Jumlah Kehadiran Minimum untuk
                                            Mendapatkan Insentif<br> Form Izin Diisi dengan Jumlah Maksimum Izin untuk
                                            Mendapatkan Insentif<br>Form Sakit Diisi dengan Jumlah Maksimum Sakit untuk
                                            Mendapatkan Insentif<br>Form Cuti Diisi dengan Jumlah Maksimum Cuti untuk
                                            Mendapatkan Insentif<br>Form Tanpa Keterangan Diisi dengan Jumlah Maksimum
                                            Tanpa Keterangan untuk Mendapatkan Insentif<br></h7>
                                    </div>
                                    <div class="row">
                                        <div class="col md-6 mb-3">
                                            <label class="form-label" style="margin-top:25px">Hadir:</label>
                                            <input type="number" class="form-control" name="hadir_input"
                                                placeholder="Hadir" value="<?php echo $hadir; ?>" required>
                                        </div>
                                        <div class="col md-6 mb-3">
                                            <label class="form-label" style="margin-top:25px">Izin:</label>
                                            <input type="number" class="form-control" name="izin_input"
                                                placeholder="Izin" value="<?php echo $izin; ?>" required>
                                        </div>
                                        <div class="col md-6 mb-3">
                                            <label class="form-label" style="margin-top:25px">Sakit:</label>
                                            <input type="number" class="form-control" name="sakit_input"
                                                placeholder="Sakit" value="<?php echo $sakit; ?>" required>
                                        </div>
                                        <div class="col md-6 mb-3">
                                            <label class="form-label" style="margin-top:25px">Cuti:</label>
                                            <input type="number" class="form-control" name="cuti_input"
                                                placeholder="Cuti" value="<?php echo $cuti; ?>" required>
                                        </div>
                                        <div class="col md-6 mb-3">
                                            <label class="form-label" style="margin-top:25px">Tanpa Keterangan:</label>
                                            <input type="number" class="form-control" name="tanpa_keterangan_input"
                                                placeholder="Tanpa Keterangan" value="<?php echo $tanpa_keterangan; ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="button" class="btn btn-dark btn-secondary" id="btnCancel"
                                            style="color:#FFF6E0">Cancel</button>
                                        <button type="submit" class="btn btn-dark btn-success" name="submit"
                                            style="color:#FFF6E0">Save</button>
                                        <br><br>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>

                    <table class="table table-hover text-center" style="background-color:#FFFFFF" id="table-container">
                        <colgroup>
                            <col style="width: 5%">
                            <col style="width: 40%">
                            <col style="width: 30%">
                            <col style="width: 25%">
                        </colgroup>
                        <thead class="table-dark" style="color:#FFF6E0">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Nomor KTP</th>
                                <th scope="col">Status Insentif</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="noDataMessage" style="display: none;">
                                <td colspan="4">No Data Available</td>
                            </tr>
                            <?php
                        $sql = "SELECT * FROM daftar_karyawan JOIN insentif_karyawan ON daftar_karyawan.id_karyawan = insentif_karyawan.id_karyawan";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            $rowNumber = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $rowNumber++; ?></td>
                                <td><?php echo $row["nama"]; ?></a></td>
                                <td><?php echo $row["no_ktp"]; ?></td>
                                <td><?php echo $row["status_insentif"]; ?></td>
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
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        function toggleForm() {
            const formContainer = document.getElementById("formContainer");
            const submitBtn = document.querySelector("button[name='submit']");
            const cancelBtn = document.getElementById("btnCancel");
            const tambahKaryawanBtn = document.getElementById("btnTambahKaryawan");

            if (formContainer.style.display === "none") {
                formContainer.style.display = "block";
                submitBtn.style.display = "inline-block";
                cancelBtn.style.display = "inline-block";
                tambahKaryawanBtn.style.display = "none"; // Hide the "Tambah Karyawan" button
                judulHlm.style.display = "none";
            } else {
                formContainer.style.display = "none";
                submitBtn.style.display = "none";
                cancelBtn.style.display = "none";
                tambahKaryawanBtn.style.display = "inline-block"; // Show the "Tambah Karyawan" button
                judulHlm.style.display = "block";
            }
        }

        const btnTambahKaryawan = document.getElementById("btnTambahKaryawan");
        btnTambahKaryawan.addEventListener("click", toggleForm);

        const btnCancel = document.getElementById("btnCancel");
        btnCancel.addEventListener("click", toggleForm);
    });

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

    function successAlert() {
        Swal.fire(
            'Berhasil!',
            'Kriteria Insentif Berhasil Diganti!',
            'success'
        );
    }
    <?php
        if (isset($_SESSION["update_success"]) && $_SESSION["update_success"]) {
            echo 'successAlert()';
            unset($_SESSION["update_success"]);
        }
        ?>
    // search
    let timeoutId;
    const searchInput = document.querySelector(".form-control");
    searchInput.addEventListener("input", delayedSearch);
    searchKaryawan();
    </script>
</body>

</html>