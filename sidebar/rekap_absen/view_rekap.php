<?php
session_start();
include "../../db_conn.php";
if (!isset($_SESSION["email"])) {
    header("Location: ../../index.php");
}

// Retrieve data from the rekap_absensi table based on the id_jam_kerja_fix
if (isset($_GET['id_jam_kerja_fix'])) {
    $idJamKerjaFix = $_GET['id_jam_kerja_fix'];
    $sql = "SELECT * FROM rekap_absensi WHERE id_jam_kerja_fix = '$idJamKerjaFix'";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $rows = []; // Empty array if id_jam_kerja_fix is not set
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

    th {
        vertical-align: middle;
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

    .black-box {
        background-color: black;
        color: white;
        padding: 10px;
        margin: 5px;
        height: 280px;
        overflow-y: auto;
        position: relative;
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
                    <input type="text" class="form-control" placeholder="Cari Berdasarkan Nama Shift"
                        style="margin-top: 10px" name="search" id="searchInput">
                    <h4 style="text-align:center;;margin-top:20px">Detail Rekap</h4>
                    <?php if (count($rows) > 0) { ?>
                    <?php
                    $row = $rows[0]; // Get the first row to display the common values
                    ?>
                    <div>
                        <p>Tanggal: <?php echo $row['tanggal']; ?></p>
                        <p>Nama Shift: <?php echo $row['nama_shift']; ?></p>
                        <p>Shift Ke: <?php echo $row['shift_ke']; ?></p>
                        <p>Jam Shift: <?php echo $row['jam_shift']; ?></p>
                    </div>
                    <?php } else { ?>
                    <p>No Data Available</p>
                    <?php } ?>
                    <table class="table table-hover text-center" style="background-color:#FFFFFF" id="table-container">
                        <colgroup>
                            <col style="width: 5%">
                            <col style="width: 20%">
                            <col style="width: 17.75%">
                            <col style="width: 17.75%">
                            <col style="width: 17.75%">
                            <col style="width: 17.75%">
                        </colgroup>
                        <thead class="table-dark" style="color:#FFF6E0">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Hadir</th>
                                <th scope="col">Sakit</th>
                                <th scope="col">Izin</th>
                                <th scope="col">Cuti</th>
                                <th scope="col">Tanpa Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (count($rows) > 0) {
                                    $rowNumber = 1;
                                    foreach ($rows as $row) {
                                        $nama_karyawan = $row['nama_karyawan'];
                                        $statuss = $row['statuss'];
                            ?>
                            <tr>
                                <td><?php echo $rowNumber; ?></td>
                                <td><?php echo $nama_karyawan; ?></td>
                                <td><input type="radio" name="status_<?php echo $rowNumber; ?>" value="hadir"
                                        <?php echo ($statuss == "hadir") ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="status_<?php echo $rowNumber; ?>" value="sakit"
                                        <?php echo ($statuss == "sakit") ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="status_<?php echo $rowNumber; ?>" value="izin"
                                        <?php echo ($statuss == "izin") ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="status_<?php echo $rowNumber; ?>" value="cuti"
                                        <?php echo ($statuss == "cuti") ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="status_<?php echo $rowNumber; ?>" value="tanpa_keterangan"
                                        <?php echo ($statuss == "tanpa_keterangan") ? 'checked' : ''; ?>></td>
                            </tr>
                            <?php
                                        $rowNumber++;
                                    }
                                } else {
                            ?>
                            <tr>
                                <td colspan="7">No Data Available</td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <a href="rekap_absen.php" class="btn btn-dark"
                            style="color:#FFF6E0; margin-bottom: 20px;">Kembali</a>
                    </div>
                </main>
            </div>
        </div>
    </main>
    <script>
    $(document).ready(function() {
        $("input[type='radio']").attr("disabled", true);
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