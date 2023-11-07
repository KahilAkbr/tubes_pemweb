<?php
// update_status.php
session_start();
include "../../db_conn.php";
if (!isset($_SESSION["email"])) {
    header("Location: ../../index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dataToUpdate"])) {
    $dataToUpdate = json_decode($_POST["dataToUpdate"], true);

    foreach ($dataToUpdate as $idKaryawan => $status) {
        // Make sure the status is one of the valid options
        $statusColumns = ["hadir", "izin", "sakit", "cuti", "tanpa_keterangan"];
        if (in_array($status, $statusColumns)) {
            // Get the current count of the status for the employee
            $query = "SELECT $status FROM absensi_karyawan WHERE id_karyawan = '$idKaryawan'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $currentCount = $row[$status];

            // Increment the count and update the database
            $newCount = $currentCount + 1;
            $query = "UPDATE absensi_karyawan SET $status = $newCount WHERE id_karyawan = '$idKaryawan'";
            mysqli_query($conn, $query);
        }
    }
    
    // Send a response back to the client (optional)
    echo "Status counts updated successfully!";
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
    <link rel="stylesheet" href="absen.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
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
        height: 150px;
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
                    <?php
                    if (isset($_GET["id_jam_kerja"])) {
                        $selected_id_jam_kerja = $_GET["id_jam_kerja"];

                        // Fetch shift details for the selected id_jam_kerja from the database
                        $sql = "SELECT id_jam_kerja, nama_shift, jumlah_shift, jam_shift, pembagian_karyawan FROM jam_kerja WHERE id_jam_kerja = $selected_id_jam_kerja";
                        $result = mysqli_query($conn, $sql);

                        // Check if the shift exists
                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $id_jam_kerja = $row['id_jam_kerja'];
                            $nama_shift = $row['nama_shift'];
                            $jumlah_shift = $row['jumlah_shift'];
                            $jam_shift = $row['jam_shift'];
                            $pembagian_karyawan = $row['pembagian_karyawan'];

                            // Split the jam_shift into individual shift times
                            $shift_times = explode(',', $jam_shift);
                            $karyawan_per_shift = explode('),(', $pembagian_karyawan);
                            // Make sure the $karyawan_per_shift array has a zero-based index
                            array_unshift($karyawan_per_shift, '');

                            echo '<div class="row">';
                            echo "<h5 class='my-3' style='padding-top:20px'>Nama Shift yang Dipilih: $nama_shift</h5>";
                            for ($i = 1; $i <= $jumlah_shift; $i++) {
                                echo '<div class="col-md-4">';
                                echo '<div class="black-box mx-2 my-2 d-flex flex-column justify-content-between">';
                                echo "<h5 style='text-align:center;color:#FFF6E0'>Shift $i</h5>";
                            
                                // Check if the current shift has karyawan assigned
                                if (isset($karyawan_per_shift[$i])) {
                                    $karyawan_shift = str_replace(array('(', ')'), '', $karyawan_per_shift[$i]);
                                    echo "<p style='color:#FFF6E0'>Karyawan: $karyawan_shift</p>";
                            
                                    // Create the button to select the shift and pass the karyawan name as a query parameter
                                    echo "<a href='absensi_karyawan_3.php?id_jam_kerja=$selected_id_jam_kerja&shift=$i' class='btn btn-dark action-buttons' style='background-color:#FFF6E0;color:black'>Pilih</a>";
                                } else {
                                    echo "<p>Tidak Ada Karyawan Untuk Shift $i</p>";
                                    echo "<a href='absensi_karyawan_3.php?id_jam_kerja=$selected_id_jam_kerja&shift=$i' class='btn btn-dark action-buttons'>Pilih</a>";
                                }
                            
                                echo '</div>';
                                echo '</div>';
                            }
                            echo '</div>';
                        } else {
                            echo '<div class="col">';
                            echo '<div class="black-box mx-2 my-2">';
                            echo '<h4>Shift Details</h4>';
                            echo '<p>No shift data available for the selected shift.</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="col">';
                        echo '<div class="black-box mx-2 my-2">';
                        echo '<h4>Shift Details</h4>';
                        echo '<p>No shift selected.</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                    
                    ?>
                    <div class="text-center">
                        <a href="absensi_karyawan.php" class="btn btn-dark btn-primary action-buttons"
                            style="margin-top:10px;color:#FFF6E0">Kembali</a>
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
    </script>
</body>

</html>