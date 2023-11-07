<?php
include "../../db_conn.php";
// Get the ID of the selected shift from the URL query parameter
if (isset($_GET['id_jam_kerja'])) {
    $id_jam_kerja = $_GET['id_jam_kerja'];

    // Fetch shift details from the database based on the ID
    $sql = "SELECT nama_shift, jumlah_shift, jam_shift, pembagian_karyawan FROM jam_kerja WHERE id_jam_kerja = '$id_jam_kerja'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    // Check if the shift exists in the database
    if ($row) {
        $nama_shift = $row['nama_shift'];
        $jumlah_shift = $row['jumlah_shift'];
        $jam_shift = $row['jam_shift'];
        $pembagian_karyawan = $row['pembagian_karyawan'];
    } else {
        // Redirect to the previous page if the shift ID is invalid or not found
        header("Location: absensi_karyawan.php");
        exit();
    }
} else {
    // Redirect to the previous page if no shift ID is provided in the URL
    header("Location: absensi_karyawan.php");
    exit();
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
    <link rel="stylesheet" href="absen.css">
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
                <main role="main" class="col-md-10 ml-sm-auto" style="background-color:whitesmoke">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="black-box mx-2 my-2">
                                <h4 style="text-align:center;margin-top:20px">Detail Shift</h4>
                                <form action="update_shift_details.php" method="post">
                                    <div class="form-group">
                                        <label for="nama_shift">Nama Shift:</label>
                                        <input type="text" class="form-control" id="nama_shift" name="nama_shift"
                                            value="<?php echo $nama_shift; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="jumlah_shift" style="padding-top:10px">Jumlah Shift:</label>
                                        <input type="number" class="form-control" id="jumlah_shift" name="jumlah_shift"
                                            value="<?php echo $jumlah_shift; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <?php
                        // Split the jam_shift into individual shift times
                        $shift_times = explode(',', $jam_shift);
                        $karyawan_per_shift = explode('),(', $pembagian_karyawan);

                        // Make sure the $karyawan_per_shift array has a zero-based index
                        array_unshift($karyawan_per_shift, '');

                        foreach ($shift_times as $index => $shift_time) {
                            // Display the shift number before each set of shift details
                            $shift_number = $index + 1;
                            echo "<h6 style='margin-top:10px'>Shift $shift_number</h6>";

                            // Display shift time as non-editable text
                            echo "<input type='text' class='form-control' value='$shift_time' readonly>";
                            // Include hidden input fields to send the shift times during form submission
                            echo "<input type='hidden' name='shift_times[]' value='$shift_time'>";

                            // Check if the karyawan_per_shift array has data for the current shift
                            if (isset($karyawan_per_shift[$shift_number])) {
                                // Remove parentheses from the shift data
                                $karyawan_shift = str_replace(array('(', ')'), '', $karyawan_per_shift[$shift_number]);
                                // Separate names with commas and display them on new lines in the textarea
                                $karyawan_names = explode(',', $karyawan_shift);
                                $karyawan_names_formatted = implode("\n", $karyawan_names);
                                // Display karyawan per shift as a textarea to allow multiple names in separate lines
                                echo "<textarea class='form-control' name='karyawan_per_shift[]' rows='3' style='margin-top:10px;min-height:125px' readonly>$karyawan_names_formatted</textarea>";
                            } else {
                                // If no karyawan for the shift, display the message
                                echo "<p>Tidak Ada Karyawan Untuk Shift Ini</p>";
                            }
                        }
                        ?>
                                    </div>
                                    <!-- Remove the submit button if you don't want to update the data -->
                                    <!-- <button type="submit" class="btn btn-primary">Update Shift Details</button> -->
                                </form>
                                <div class="text-center">
                                    <!-- Use the custom class to set background color -->
                                    <a href="absensi_karyawan.php" class="btn btn-dark btn-primary action-buttons"
                                        style="margin-top:10px;color:#FFF6E0">Kembali</a>
                                </div>
                            </div>
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
    </script>
</body>

</html>