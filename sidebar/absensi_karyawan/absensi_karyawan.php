<?php
session_start();
include "../../db_conn.php";
if (!isset($_SESSION["email"])) {
    header("Location: ../../index.php");
}

// Fetch shift details from the database
$sql = "SELECT id_jam_kerja, nama_shift, jumlah_shift, jam_shift, pembagian_karyawan FROM jam_kerja"; // Replace 'table_name' with the actual table name in your database
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$totalRows = mysqli_num_rows($result);

// Reset the pointer to the beginning of the result set
mysqli_data_seek($result, 0);
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
    <link rel="stylesheet" href="absen.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
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

    .action-buttons {
        background-color: #606C38;
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

    .see-details {
        display: none;
        background-color: white;
        padding: 10px;
        margin-top: 5px;
    }

    .see-details.visible {
        display: block;
    }

    .hideShift {
        display: block;
    }

    .highlighted {
        border: 2px solid yellow;
        /* Contoh: beri border merah pada elemen jadwal yang cocok */
        background-color: yellow;
        /* Contoh: beri latar belakang kuning pada elemen jadwal yang cocok */
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
                    <div class="custom-form-container" id="judulHlm">
                        <div class="container" style="padding-top:10px">
                            <div class="text-center mb-4">
                                <h3 style="margin-top: 10px;font-size:35px">Absensi Karyawan</h3>
                                <p class="text-muted" style="font-size:15px">Pilih Shift dan Lakukan Absensi!</p>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-4 g-4">
                        <?php
                        // Check if there are shift data in the database
                        if ($totalRows > 0) {
                            // Loop through each shift and create a black box for each
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id_jam_kerja = $row['id_jam_kerja'];
                                $nama_shift = $row['nama_shift'];
                                $jumlah_shift = $row['jumlah_shift'];
                                $jam_shift = $row['jam_shift'];
                                ?>
                        <!-- Use Bootstrap grid classes to create equal-sized columns -->

                        <div class="col-md-3">
                            <div class="hideShift">
                                <div class="black-box mx-2 my-2 d-flex flex-column justify-content-between">
                                    <!-- Content inside the black box -->
                                    <div>
                                        <h4 style="text-align:center;color:#FFF6E0">Detail Shift</h4>
                                        <p style="color:#FFF6E0">Nama Shift: <?php echo $nama_shift; ?></p>
                                        <?php
                                                // Split the jam_shift into individual shift times
                                                $shift_times = explode(',', $jam_shift);
                                                foreach ($shift_times as $index => $shift_time) {
                                                    echo "<p style='color:#FFF6E0'>Shift " . ($index + 1) . ": " . $shift_time . "</p>";
                                                }
                                                ?>
                                    </div>
                                    <!-- Buttons at the bottom of the black box -->
                                    <div class="btn-group d-flex justify-content-center mt-3">
                                        <!-- Use the custom class to set background color -->
                                        <a href="view_jadwal.php?id_jam_kerja=<?php echo $id_jam_kerja; ?>"
                                            class="btn btn-dark btn-primary"
                                            style="background-color:#FFF6E0;color:black">Lihat</a>
                                        <a class="btn btn-dark btn-primary" style="background-color:#FFF6E0;color:black"
                                            href="absensi_karyawan_2.php?id_jam_kerja=<?php echo $id_jam_kerja; ?>">Pilih</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                            }
                        } else {
                            // Display a message if there is no shift data available
                            echo '<div class="col">';
                            echo '<div class="black-box mx-2 my-2">';
                            echo '<h4>Shift Details</h4>';
                            echo '<p>No shift data available.</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </main>
            </div>
        </div>
    </main>
    <script>
    $(document).ready(function() {
        function toggleHideShiftElements() {
            var searchInputValue = $('#searchInput').val().toLowerCase();
            if (searchInputValue === '') {
                // Jika kotak pencarian kosong, hapus highlight dari semua elemen jadwal
                $('.hideShift').removeClass('highlighted');
            } else {
                $('.hideShift').each(function() {
                    var shiftName = $(this).find('p').first().text().toLowerCase();
                    if (shiftName.includes(searchInputValue)) {
                        $(this).addClass(
                        'highlighted'); // Tambahkan class 'highlighted' ke elemen jadwal yang cocok
                    } else {
                        $(this).removeClass(
                        'highlighted'); // Hapus class 'highlighted' dari elemen jadwal yang tidak cocok
                    }
                });
            }
        }

        $('#searchInput').on('input', function() {
            toggleHideShiftElements();
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
    </script>


</body>

</html>