<?php
// update_status.php

include "../../db_conn.php";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dataToUpdate"])) {
    $dataToUpdate = json_decode($_POST["dataToUpdate"], true);
    $idJamKerjaFix = generateRandomString();
    $selectedDate = $_POST["selectedDate"];
    foreach ($dataToUpdate as $name => $status) {
        // Make sure the status is one of the valid options
        $statusColumns = ["hadir", "izin", "sakit", "cuti", "tanpa_keterangan"];
        if (in_array($status, $statusColumns)) {
            // Get the employee's ID from the database
            $query = "SELECT id_karyawan FROM daftar_karyawan WHERE nama = '$name'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $idKaryawan = $row['id_karyawan'];

            // Get the current count of the status for the employee
            $query = "SELECT $status FROM absensi_karyawan WHERE id_karyawan = '$idKaryawan'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $currentCount = $row[$status];

            $newCount = $currentCount + 1;
            $query = "UPDATE absensi_karyawan SET $status = $newCount WHERE id_karyawan = '$idKaryawan'";
            mysqli_query($conn, $query);

            // Extract shift and selected_id_jam_kerja from URL parameters
            $shift = isset($_GET['shift']) ? intval($_GET['shift']) : 1;
            $selectedShift = isset($_GET['shift']) ? intval($_GET['shift']) : 1;
            $selectedShiftTimes = explode(",", $jamShift);
            $selected_id_jam_kerja = isset($_GET['id_jam_kerja']) ? $_GET['id_jam_kerja'] : null;
            
            // Insert into the rekap_absensi table for each shift
            if ($selected_id_jam_kerja) {
                $query = "SELECT nama_shift, jam_shift FROM jam_kerja WHERE id_jam_kerja = $selected_id_jam_kerja";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $namaShift = $row['nama_shift'];
                $jamShift = $row['jam_shift'];

                // Get the selected time for the current shift
                $selectedShiftTimes = explode(",", $jamShift);
                $selectedTime = isset($selectedShiftTimes[$selectedShift - 1]) ? trim($selectedShiftTimes[$selectedShift - 1]) : '';
                // Insert into the rekap_absensi table
                $query = "INSERT INTO rekap_absensi (id_jam_kerja_fix, nama_shift, shift_ke, jam_shift, tanggal, nama_karyawan, statuss) VALUES ('$idJamKerjaFix', '$namaShift', $shift, '$selectedTime', '$selectedDate', '$name', '$status')";
                mysqli_query($conn, $query);
                deleteEmptyNamaKaryawan();
            }
        }
    }

    // Send a response back to the client (optional)
    echo "Status counts updated successfully!";
}

function deleteEmptyNamaKaryawan() {
    include "../../db_conn.php";

    // Delete rows from the rekap_absensi table where the nama_karyawan is an empty string
    $query = "DELETE FROM rekap_absensi WHERE nama_karyawan = ''";
    mysqli_query($conn, $query);
}
function generateRandomString($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
function getDataFromBrackets($input, $shift) {
    // Mencocokkan pola dengan menggunakan ekspresi reguler berdasarkan nilai shift
    preg_match_all('/\(([^)]+)\)/', $input, $matches);

    // Mengambil isi dari kurung berdasarkan shift
    if (isset($matches[1][$shift - 1])) {
        $data = array_map('trim', explode(",", $matches[1][$shift - 1]));
        return $data;
    } else {
        return [];
    }
}

function getDefaultStatus($row) {
    $statuses = ["hadir", "izin", "sakit", "cuti"];
    foreach ($statuses as $status) {
        if ($row[$status] == 1) {
            return $status;
        }
    }
    return "tanpa_keterangan"; // Default to "tanpa_keterangan" if no valid status is found
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
                        style="margin-top: 10px;margin-bottom:10px">
                    <h4 style="text-align:center;margin-top:20px">Form Absensi</h4>
                    <?php if (isset($_GET['id_jam_kerja'])): ?>
                    <?php
                            $id_jam_kerja = $_GET['id_jam_kerja']; 
                            $sql = "SELECT id_jam_kerja, nama_shift, jumlah_shift, jam_shift, pembagian_karyawan FROM jam_kerja WHERE id_jam_kerja = $id_jam_kerja";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $jam_shift = $row['jam_shift'];
                            if (isset($_GET['shift'])) {
                                $shift = intval($_GET['shift']);
                            } else {
                                $shift = 1;
                            }
                            $shift_times = explode(',', $jam_shift);
                            ?>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h4>Info Shift:</h4>
                            <p><strong>Nama Shift:</strong> <?php echo $row['nama_shift']; ?></p>
                            <?php
                                    // Get the shift number from $_GET['shift']
                                    $shiftNumber = isset($_GET['shift']) ? intval($_GET['shift']) : 1;
                                    // Get the shift times from the 'jam_shift' column
                                    $shiftTimes = explode(',', $row['jam_shift']);
                                    // If the shift number is not found, display an error message
                                    if (empty($shiftTimes) || !isset($shiftTimes[$shiftNumber - 1])) {
                                        echo "<p>Shift not found</p>";
                                    } else {
                                        echo "<p><strong>Shift Time:</strong> " . $shiftTimes[$shiftNumber - 1] . "</p>";
                                    }
                                ?>
                            <p><strong>Shift-ke:</strong> <?php echo $shift; ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pilih Tanggal:</label>
                            <input type="date" class="form-control" name="tanggal" required>
                        </div>
                    </div>
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
                            <tr id="noDataMessage" style="display: none;">
                                <td colspan="7">No Data Available</td>
                            </tr>
                            <?php
        if (isset($_GET['id_jam_kerja'])) {
            $selected_id_jam_kerja = $_GET["id_jam_kerja"];
            $sql = "SELECT id_jam_kerja, nama_shift, jumlah_shift, jam_shift, pembagian_karyawan FROM jam_kerja WHERE id_jam_kerja = $selected_id_jam_kerja";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $pembagian_karyawan = $row['pembagian_karyawan'];
            
            if (isset($_GET['shift'])) {
                $shift = intval($_GET['shift']);
            } else {
                $shift = 0;
            }
            $dataInShift = getDataFromBrackets($pembagian_karyawan, $shift);
            $countInShift = count($dataInShift);

            // Loop through the data and display the names in the table
            $rowNumber = 1;
            foreach ($dataInShift as $name) {
                $sql = "SELECT * FROM daftar_karyawan JOIN absensi_karyawan ON daftar_karyawan.id_karyawan = absensi_karyawan.id_karyawan WHERE daftar_karyawan.nama = '$name'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                // Determine the selected status for this employee
                $selectedStatus = getDefaultStatus($row);
                $statuses = ["hadir", "izin", "sakit", "cuti"];
                foreach ($statuses as $status) {
                    if ($row[$status] == 1) {
                        $selectedStatus = $status;
                        break;
                    }
                }
        ?>
                            <tr>
                                <td><?php echo $rowNumber; ?></td>
                                <td><?php echo $name; ?></td>
                                <td><input type="radio" name="status_<?php echo $rowNumber; ?>" value="hadir"
                                        <?php echo ($selectedStatus == "hadir") ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="status_<?php echo $rowNumber; ?>" value="sakit"
                                        <?php echo ($selectedStatus == "sakit") ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="status_<?php echo $rowNumber; ?>" value="izin"
                                        <?php echo ($selectedStatus == "izin") ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="status_<?php echo $rowNumber; ?>" value="cuti"
                                        <?php echo ($selectedStatus == "cuti") ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="status_<?php echo $rowNumber; ?>" value="tanpa_keterangan"
                                        <?php echo ($selectedStatus == "tanpa_keterangan") ? 'checked' : ''; ?>></td>
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
                        <a href="absensi_karyawan_2.php?id_jam_kerja=<?php echo $selected_id_jam_kerja; ?>"
                            class="btn btn-dark" style="margin-bottom: 20px;color:#FFF6E0;">Kembali</a>
                        <button type="button" class="btn btn-dark" id="btnSave"
                            style="margin-bottom: 20px;color:#FFF6E0">Simpan</button>
                    </div>
                </main>
            </div>
        </div>
    </main>
    <script>
    $(document).ready(function() {
        // Function to handle the "Save" button click
        $("#btnSave").on("click", function() {
            var selectedDate = $("input[name='tanggal']").val();

            // Check if the selected date is empty
            if (!selectedDate) {
                Swal.fire({
                    icon: "info",
                    title: "Please select a date.",
                });
                return;
            }

            var dataToUpdate = {};
            $("tbody tr").each(function() {
                var name = $(this).find("td:nth-child(2)").text();
                var statusValue = $(this).find("input[type='radio']:checked").val();
                // If no radio button is checked, set the "tanpa_keterangan" status to 1
                dataToUpdate[name] = statusValue || "tanpa_keterangan";
            });

            // Send data to the server using AJAX to update the database
            $.ajax({
                type: "POST",
                url: window.location
                .href, // Use the current page URL to handle the AJAX request
                data: {
                    dataToUpdate: JSON.stringify(dataToUpdate),
                    selectedDate: selectedDate
                }, // Include the selected date in the data
                success: function(response) {
                    // Handle success response (if needed)
                    Swal.fire({
                        icon: "success",
                        title: "Form Absensi Berhasil Tersimpan!",
                    }).then(function() {
                        // Redirect to "absensi_karyawan.php" after successful save
                        window.location.href = "absensi_karyawan.php";
                    });
                },
                error: function(xhr, status, error) {
                    // Handle error (if needed)
                    Swal.fire({
                        icon: "error",
                        title: "An error occurred while updating status counts.",
                    });
                },
            });
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