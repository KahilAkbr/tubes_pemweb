<?php
session_start();
include "../../db_conn.php";
if (!isset($_SESSION["email"])) {
    header("Location: ../../index.php");
}

if (isset($_GET['id_jam_kerja_fix']) && !empty($_GET['id_jam_kerja_fix'])) {
    $id_jam_kerja_fix = $_GET['id_jam_kerja_fix'];

    include "../../db_conn.php";

    $sql = "DELETE FROM rekap_absensi WHERE id_jam_kerja_fix = '$id_jam_kerja_fix'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION["delete_success"] = true;
        header("Location: rekap_absen.php");
        exit();
    } else {
        echo "Error deleting shift: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
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
    <script src="../../search/search.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <link rel="stylesheet" href="rekap.css">
    <style>
    body::-webkit-scrollbar {
        display: none;
    }

    #sidebar {
        /* Add styles to make the sidebar take up the full height */
        display: flex;
        flex-direction: column;
        height: 100vh;
        /* 100% of the viewport height */
        position: sticky;
        top: 0;
    }

    #table-container {
        margin-bottom: 50px;
    }

    a.link-dark {
        color: inherit;
        text-decoration: none;
    }

    th {
        vertical-align: middle;
    }

    .black-box {
        background-color: black;
        color: white;
        padding: 10px;
        margin: 5px;
        height: 280px;
        overflow-y: auto;
        position: relative;
        border-radius: 10px;
    }

    /* Styling for scrollbar track */
    .black-box::-webkit-scrollbar {
        width: 8px;
        z-index: 1;
    }

    /* Styling for scrollbar thumb */
    .black-box::-webkit-scrollbar-thumb {
        background-color: #606C38;
        /* Color of the thumb */
        border-radius: 4px;
        /* Rounded corners for the thumb */
    }

    /* Styling for scrollbar track on Firefox */
    .black-box::-moz-scrollbar {
        width: 8px;
    }

    /* Styling for scrollbar thumb on Firefox */
    .black-box::-moz-scrollbar-thumb {
        background-color: #606C38;
        border-radius: 4px;
    }

    /* Styling for scrollbar track on IE and Edge */
    .black-box::-ms-scrollbar {
        width: 8px;
    }

    /* Styling for scrollbar thumb on IE and Edge */
    .black-box::-ms-scrollbar-thumb {
        background-color: #606C38;
        border-radius: 4px;
    }

    .black-box .action-buttons {
        position: sticky;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 5px;
        background-color: #606C38;
        display: flex;
        justify-content: space-around;
        z-index: 2;
        /* Add z-index to make buttons appear above the scrollbar */
    }

    .black-box .action-buttons button {
        background-color: #606C38;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }
    </style>
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
                    <div class="text-center mb-4">
                        <h3 style="margin-top: 10px;font-size:35px">Rekap Absensi</h3>
                        <p class="text-muted" style="font-size:15px">Lihat dan Kelola Rekap Absensi!</p>
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
                                <th scope="col">Hadir</th>
                                <th scope="col">Izin</th>
                                <th scope="col">Sakit</th>
                                <th scope="col">Cuti</th>
                                <th scope="col">Tanpa Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="noDataMessage" style="display: none;">
                                <td colspan="8">No Data Available</td>
                            </tr>
                            <?php
    $sql = "SELECT dk.nama, dk.no_ktp,
                   COALESCE(SUM(ra.statuss = 'hadir'), 0) AS hadir,
                   COALESCE(SUM(ra.statuss = 'izin'), 0) AS izin,
                   COALESCE(SUM(ra.statuss = 'sakit'), 0) AS sakit,
                   COALESCE(SUM(ra.statuss = 'cuti'), 0) AS cuti,
                   COALESCE(SUM(ra.statuss = 'tanpa_keterangan'), 0) AS tanpa_keterangan
            FROM daftar_karyawan dk
            LEFT JOIN rekap_absensi ra ON dk.nama = ra.nama_karyawan
            GROUP BY dk.nama, dk.no_ktp
            ORDER BY dk.nama ASC";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $rowNumber = 1;
        while ($row = mysqli_fetch_assoc($result)) {
    ?>
                            <tr>
                                <td><?php echo $rowNumber++; ?></td>
                                <td><?php echo $row["nama"]; ?></a></td>
                                <td><?php echo $row["no_ktp"]; ?></td>
                                <td><?php echo $row["hadir"]; ?></td>
                                <td><?php echo $row["izin"]; ?></td>
                                <td><?php echo $row["sakit"]; ?></td>
                                <td><?php echo $row["cuti"]; ?></td>
                                <td><?php echo $row["tanpa_keterangan"]; ?></td>
                            </tr>
                            <?php
        }
    }
    ?>
                        </tbody>
                    </table>
                    <div class="container-fluid">
                        <h1>Rekap Absensi</h1>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <?php
            // Fetch unique variations of id_jam_kerja_fix from rekap_absensi
            $variationSQL = "SELECT DISTINCT id_jam_kerja_fix FROM rekap_absensi";
            $variationResult = mysqli_query($conn, $variationSQL);

            // Initialize a variable to check if there are any black boxes
            $hasBlackBox = false;

            // Loop through the variations and create black boxes with buttons
            while ($variationRow = mysqli_fetch_assoc($variationResult)) {
                $id_jam_kerja_fix = $variationRow["id_jam_kerja_fix"];

                // Fetch data based on the unique id_jam_kerja_fix
                $blackBoxSQL = "SELECT nama_shift, shift_ke, jam_shift 
                                FROM rekap_absensi 
                                WHERE id_jam_kerja_fix = '$id_jam_kerja_fix'";
                $blackBoxResult = mysqli_query($conn, $blackBoxSQL);

                // Display the black boxes only if there are records for the unique id_jam_kerja_fix
                if (mysqli_num_rows($blackBoxResult) > 0) {
                    $hasBlackBox = true;

                    $blackBoxRow = mysqli_fetch_assoc($blackBoxResult);
                    $nama_shift = $blackBoxRow["nama_shift"];
                    $shift_ke = $blackBoxRow["shift_ke"];
                    $jam_shift = $blackBoxRow["jam_shift"];

                    echo '
                    <div class="col-md-3">
                        <div class="black-box mx-2 my-2 d-flex flex-column justify-content-between">
                            <p style="color:#FFF6E0">Nama Shift: ' . $nama_shift . '</p>
                            <p style="color:#FFF6E0">Shift ke: ' . $shift_ke . '</p>
                            <p style="color:#FFF6E0">Jam Shift: ' . $jam_shift . '</p>
                            <div class="btn-group d-flex justify-content-center mt-3">
                                <a class="btn btn-dark btn-primary" style="background-color:#FFF6E0;color:black" href="view_rekap.php?id_jam_kerja_fix=' . $id_jam_kerja_fix . '"">View</a>
                                <a class="btn btn-dark btn-primary" style="background-color:#FFF6E0;color:black" href="update_rekap.php?id_jam_kerja_fix=' . $id_jam_kerja_fix . '"">Update</a>
                                <a class="btn btn-dark btn-primary" style="background-color:#FFF6E0;color:black" href="#" data-id="' . $id_jam_kerja_fix . '" onclick="delete_rekap(event)">Delete</a>
                            </div>
                        </div>
                    </div>
                    ';
                }
            }

            // If there are no black boxes, display a default black box with the message "Tidak ada rekap"
            if (!$hasBlackBox) {
                echo '
                    <div class="col-md-3">
                        <div class="black-box">
                            <p>Tidak ada rekap</p>
                        </div>
                    </div>
                ';
            }
            ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </main>
    <script>
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

    function delete_rekap(event) {
        event.preventDefault(); // Prevent the default link behavior (page navigation)

        const karyawanId = event.currentTarget.getAttribute('data-id');

        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Rekap ini akan dihapus. Tindakan ini tidak dapat diurungkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Batal',
            cancelButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {} else if (result.dismiss === Swal.DismissReason.cancel) {
                window.location.href = `rekap_absen.php?id_jam_kerja_fix=${karyawanId}`;
            }
        });
    }
    document.addEventListener("DOMContentLoaded", function() {
        <?php
            if (isset($_SESSION["delete_success"]) && $_SESSION["delete_success"]) {
                echo 'successDeleteAlert();';
                unset($_SESSION["delete_success"]);
            }
            ?>

        function successDeleteAlert() {
            Swal.fire(
                'Rekap Terhapus!',
                'Rekap Absensi Berhasil Terhapus!.',
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
                'Rekap Terupdate!',
                'Rekap Absensi Berhasil Diperbarui!.',
                'success'
            );
        }
    });
    // search
    let timeoutId;
    const searchInput = document.querySelector(".form-control");
    searchInput.addEventListener("input", delayedSearch);
    searchKaryawan();
    </script>
</body>

</html>