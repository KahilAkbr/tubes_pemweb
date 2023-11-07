<?php
include "../../../db_conn.php";

// Generate the dropdown options for karyawan
$karyawanOptions = array();
$sql = "SELECT * FROM daftar_karyawan";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $karyawanOptions[] = $row['nama'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_jam_kerja = $_GET['id_jam_kerja'];
    // Process the form data
    if (isset($_POST["submit"])) {
        $karyawanStringFormat = $_POST['mydata'];
        $shiftCount = $_POST["shiftCount"];
        $namaShift = $_POST["namaShift"];
        $shiftHours = array();
        $pembagianKaryawan = array();

        // Collect shift hours and employee distribution data
        for ($i = 1; $i <= $shiftCount; $i++) {
            $start = $_POST["shift{$i}_start"];
            $end = $_POST["shift{$i}_end"];
            $shiftHours[] = "$start-$end";

            if (isset($_POST["dropdownKaryawan{$i}"])) {
                $selectedKaryawan = $_POST["dropdownKaryawan{$i}"];
                $karyawanList = explode(",", $selectedKaryawan);
                $pembagianKaryawan[] = $karyawanList;
            } else {
                $pembagianKaryawan[] = [];
            }
        }

        // Convert arrays to strings for database insertion
        $shiftHoursString = implode(",", $shiftHours);
        $pembagianKaryawan = json_encode($pembagianKaryawan);

        // Perform the UPDATE operation based on id_jam_kerja
        $sql = "UPDATE jam_kerja 
                SET nama_shift = '$namaShift', jumlah_shift = '$shiftCount', jam_shift = '$shiftHoursString', pembagian_karyawan = '$karyawanStringFormat'
                WHERE id_jam_kerja = '$id_jam_kerja'";

        // Execute the query
        mysqli_query($conn, $sql);
        $_SESSION["update_success"] = true;
        header("Location: ../jadwal_kerja.php");
        exit();
        
    }
}else{
    if (isset($_GET['id_jam_kerja'])) {
        $id_jam_kerja = $_GET['id_jam_kerja'];

        // Retrieve the data for the provided id_jam_kerja from the database
        $sql = "SELECT * FROM jam_kerja WHERE id_jam_kerja = '$id_jam_kerja'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Fetch the data
            $row = $result->fetch_assoc();
            $namaShift = $row['nama_shift'];
            $jumlahShift = $row['jumlah_shift'];
            $jamShift = $row['jam_shift'];
            $pembagianKaryawan = $row['pembagian_karyawan'];

            // Convert the jamShift and pembagianKaryawan data back to arrays
            $shiftHours = explode(",", $jamShift);
            
            $pembagianKaryawanArr = json_decode($pembagianKaryawan, true);

            // Now you can use these variables to populate the form fields
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Kerja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <link rel="stylesheet" href="../jadwal.css">
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

    #shiftHoursInputs,
    #karyawanInputs {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    /* CSS untuk mengatur lebar kontainer form */
    #shiftHoursInputs .form-field,
    #karyawanInputs .form-field {
        flex: 0 0 calc(100%);
        margin: 5px;
        /* Jarak antara form */
    }

    #shiftForm {
        display: none;
    }

    .black-box {
        background-color: black;
        color: white;
        padding: 10px;
        margin: 5px;
        /* Jarak antara form */
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

    .karyawan-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
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
                                <a class="nav-link" href="../../dashboard/dashboard.php" style="color:#FFF6E0">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../../daftar_karyawan/daftar_karyawan.php"
                                    style="color:#FFF6E0">
                                    <i class="fas fa-users"></i> Daftar Karyawan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../../absensi_karyawan/absensi_karyawan.php"
                                    style="color:#FFF6E0">
                                    <i class="fas fa-calendar-check"></i> Absensi Karyawan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../../jadwal_kerja/jadwal_kerja.php" style="color:#FFF6E0">
                                    <i class="fas fa-calendar"></i> Jadwal Kerja
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../../insentif/insentif.php" style="color:#FFF6E0">
                                    <i class="fas fa-gift"></i> Insentif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../../rekap_absen/rekap_absen.php" style="color:#FFF6E0">
                                    <i class="fas fa-file-alt"></i> Rekap Absensi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../../logout/logout.php" style="color:#FFF6E0"
                                    onclick="showLogoutAlert(event)">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- Content -->
                <main role="main" class="col-md-10 ml-sm-auto" style="background-color:whitesmoke">
                    <form action="" method="post" enctype="multipart/form-data" name="karyawanForm">
                        <div id="shiftNameForm">
                            <div class="container">
                                <div class="text-center mb-4">
                                    <h3 style="margin-top: 35px">Update Jadwal Kerja</h3>
                                    <p class="text-muted">Masukkan nama shift kerja</p>
                                </div>
                                <div style="justify-content: center;display:flex">
                                    <div class="col-md-3 mb-4">
                                        <input type="text" class="form-control" id="namaShift" name="namaShift"
                                            placeholder="Nama Shift (contoh : Senin)" maxlength="20" required
                                            value="<?php echo isset($namaShift) ? htmlspecialchars($namaShift) : ''; ?>">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="../jadwal_kerja.php" class="btn btn-dark btn-secondary"
                                        style="color:#FFF6E0">Kembali</a>
                                    <button type="button" class="btn btn-dark btn-success" id="btnSubmitShiftName"
                                        style="color:#FFF6E0">Lanjut</button>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                        <div id="shiftForm">
                            <div class="container">
                                <div class="text-center mb-4">
                                    <h3 style="margin-top: 35px">Update Jadwal Kerja</h3>
                                    <p class="text-muted">Masukkan jumlah shift kerja (1-10)</p>
                                </div>
                                <div style="justify-content: center;display:flex">
                                    <div class="col-md-3 mb-4">
                                        <input type="number" class="form-control" id="shiftCount" name="shiftCount"
                                            placeholder="Jumlah Shift" min="1" max="10" required
                                            value="<?php echo isset($jumlahShift) ? htmlspecialchars($jumlahShift) : ''; ?>">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-dark btn-secondary" id="btnBackToShiftNameForm"
                                        style="color:#FFF6E0">Kembali</button>
                                    <button type="button" class="btn btn-dark btn-success" id="btnSubmitShift"
                                        style="color:#FFF6E0">Lanjut</button>
                                    <br><br>
                                </div>
                            </div>
                        </div>

                        <div id="shiftHoursForm" style="display:none;">
                            <div class="container">
                                <div class="text-center mb-4">
                                    <h3 style="margin-top: 35px">Update Jadwal Kerja</h3>
                                    <p class="text-muted">Masukkan jam kerja untuk setiap shift</p>
                                </div>
                                <!-- Kode HTML untuk form jam kerja -->
                                <div id="shiftHoursInputs" class="mx-auto">

                                    <!-- Dynamic form fields for shift hours will be added here -->
                                </div>
                                <div class="text-center" style="padding-top:20px">
                                    <a class="btn btn-dark btn-secondary" id="btnBackToShiftForm"
                                        style="color:#FFF6E0">Kembali</a>
                                    <button type="button" class="btn btn-dark btn-success" id="btnAddKaryawanForm"
                                        style="color:#FFF6E0">Lanjut</button>
                                    <br><br>
                                </div>
                            </div>
                        </div>

                        <div id="karyawanForm" style="display:none;">
                            <input type="hidden" name="mydata" id="mydata">
                            <div class="container">
                                <div class="text-center mb-4">
                                    <h3 style="margin-top: 35px">Update Karyawan ke Shift</h3>
                                </div>
                                <!-- White box to display daftar_karyawan -->

                                <!-- Div container for displaying karyawan to shifts -->
                                <div id="karyawanInputs" class="mx-auto">
                                    <!-- Dynamic content for karyawan input will be added here -->
                                </div>
                                <div class="text-center">
                                    <a class="btn btn-dark btn-secondary" id="btnBackToShiftHoursForm"
                                        style="color:#FFF6E0">Kembali</a>
                                    <button type="submit" class="btn btn-dark btn-success" id="btnSubmitKaryawan"
                                        name="submit" style="color:#FFF6E0">Simpan</button>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </form>
                </main>
            </div>
        </div>
    </main>
    <script>
    const karyawanOptions = <?php echo json_encode($karyawanOptions); ?>;
    // JavaScript code starts here

    // Function to populate the dropdown options
    function populateDropdownOptions(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        karyawanOptions.forEach((option) => {
            const optionElement = document.createElement("option");
            optionElement.textContent = option;
            optionElement.value = option;
            dropdown.appendChild(optionElement);
        });
    }

    // Function to set up the "Tambah Karyawan" button for each shift
    function setupTambahKaryawanButtons() {
        for (let i = 1; i <= shiftCountInput.value; i++) {
            const btnTambahKaryawan = document.getElementById(`btnTambahKaryawan${i}`);
            btnTambahKaryawan.addEventListener("click", function() {
                tambahKaryawan(i);
            });
        }
    }
    let karyawanYangHilang = [];
    // Function to display the selected employees for each shift
    function tambahKaryawan(i) {
        const dropdown = document.getElementById(`dropdownKaryawan${i}`);
        const selectedKaryawan = dropdown.value;

        if (selectedKaryawan !== "") {
            const namaKaryawanContainer = document.getElementById(`namaKaryawanContainer${i}`);

            // Create a separate container for each employee
            const karyawanContainer = document.createElement("div");
            karyawanContainer.classList.add("karyawan-container");
            namaKaryawanContainer.appendChild(karyawanContainer);

            // Display the employee's name and a "Remove" button
            const namaKaryawanElement = document.createElement("div");
            namaKaryawanElement.textContent = selectedKaryawan;
            karyawanContainer.appendChild(namaKaryawanElement);

            const removeButton = document.createElement("button");
            removeButton.textContent = "Remove";
            removeButton.classList.add("btn", "btn-danger", "btn-dark");
            removeButton.onclick = function() {
                event.preventDefault(); // Prevent form submission
                removeKaryawan(i, karyawanContainer, selectedKaryawan);
            };
            karyawanContainer.appendChild(removeButton);

            // Remove the selected option from the dropdown
            const selectedOptionIndex = dropdown.selectedIndex;
            if (selectedOptionIndex !== -1) {
                dropdown.remove(selectedOptionIndex);

                // Store the selected employee name in the karyawanYangHilang array
                if (!karyawanYangHilang[i - 1]) {
                    karyawanYangHilang[i - 1] = [];
                }
                karyawanYangHilang[i - 1].push(selectedKaryawan);

                // Call the function to convert the karyawanYangHilang array to the desired string format
                const karyawanStringFormat = convertToDesiredFormat(karyawanYangHilang);
                $("#mydata").val(karyawanStringFormat);

                // Display the result
                console.log(karyawanYangHilang);
                console.log(karyawanStringFormat);
            }
        }
    }

    function convertToDesiredFormat(karyawanArr) {
        let result = "";
        for (let i = 0; i < karyawanArr.length; i++) {
            if (karyawanArr[i].length > 0) {
                if (result !== "") {
                    result += ",";
                }
                result += "(" + karyawanArr[i].join(",") + ")";
            }
        }
        return result;
    }

    function removeKaryawan(shiftNumber, employeeContainer, selectedKaryawan) {
        const karyawanContainer = employeeContainer;

        // Retrieve the name of the employee to be removed
        const namaKaryawanElement = karyawanContainer.querySelector("div");
        const removedKaryawan = namaKaryawanElement.textContent;

        // Remove the selected employee from the shift
        karyawanContainer.remove();

        // Add the selected employee back to the dropdown
        const dropdown = document.getElementById(`dropdownKaryawan${shiftNumber}`);
        const optionElement = document.createElement("option");
        optionElement.textContent = removedKaryawan;
        optionElement.value = removedKaryawan;
        dropdown.appendChild(optionElement);

        // Remove the selected employee from the karyawanYangHilang array
        const shiftIndex = shiftNumber - 1;
        const employeeIndex = karyawanYangHilang[shiftIndex].indexOf(selectedKaryawan);
        if (employeeIndex !== -1) {
            karyawanYangHilang[shiftIndex].splice(employeeIndex, 1);
        }

        // Update the hidden input value with the updated karyawanYangHilang array
        const karyawanStringFormat = convertToDesiredFormat(karyawanYangHilang);
        $("#mydata").val(karyawanStringFormat);

        console.log(karyawanYangHilang);
        console.log(karyawanStringFormat);
    }
    document.addEventListener("DOMContentLoaded", function() {
        const shiftForm = document.getElementById("shiftForm");
        const shiftHoursForm = document.getElementById("shiftHoursForm");
        const karyawanForm = document.getElementById("karyawanForm");
        const shiftCountInput = document.getElementById("shiftCount");

        let shiftHoursData = []; // Array untuk menyimpan data jam kerja setiap shift

        // Function untuk menampilkan form jam kerja berdasarkan jumlah shift yang diinput
        function showShiftHoursForm(count) {
            shiftForm.style.display = "none";
            shiftHoursForm.style.display = "block";
            const shiftHoursInputs = document.getElementById("shiftHoursInputs");
            shiftHoursInputs.innerHTML = "";

            for (let i = 1; i <= count; i++) {
                const shiftField = document.createElement("div");
                shiftField.classList.add("form-field");
                shiftField.innerHTML = `
            <label class="form-label">Shift ${i}:</label>
            <div class="input-group">
                <input type="text" class="form-control" name="shift${i}_start" placeholder="Waktu Shift Dimulai (JJ:MM) (contoh : 16:00)" required >
                <span class="input-group-text">-</span>
                <input type="text" class="form-control" name="shift${i}_end" placeholder="Waktu Shift Berakhir (JJ:MM) (contoh : 16:00)" required>
            </div>
            `;
                shiftHoursInputs.appendChild(shiftField);
            }
        }

        function isKaryawanContainerEmpty() {
            for (let i = 1; i <= shiftCountInput.value; i++) {
                const karyawanContainer = document.getElementById(`namaKaryawanContainer${i}`);
                if (karyawanContainer.textContent.trim() === "") {
                    return true;
                }
            }
            return false;
        }
        // Function untuk menampilkan form tambah karyawan berdasarkan jumlah shift
        function showKaryawanForm() {
            shiftHoursForm.style.display = "none";
            karyawanForm.style.display = "block";
            const karyawanInputs = document.getElementById("karyawanInputs");
            karyawanInputs.innerHTML = "";

            for (let i = 1; i <= shiftCountInput.value; i++) {
                const karyawanField = document.createElement("div");
                karyawanField.classList.add("form-field");
                const shiftHourData = shiftHoursData[i - 1]; // Ambil data jam kerja untuk shift tertentu
                const shiftHourText = shiftHourData ?
                    `${shiftHourData.start} - ${shiftHourData.end}` :
                    "Jam kerja belum diatur"; // Tampilkan jam kerja jika sudah diatur, jika belum tampilkan pesan

                karyawanField.innerHTML = `
            <label class="form-label">Shift ${i}:</label>
            <input type="text" class="form-control" name="karyawan_shift${i}" value="${shiftHourText}" required readonly>
            `;
                karyawanInputs.appendChild(karyawanField);
            }
        }

        // Function untuk validasi format waktu
        function isValidTimeFormat(time) {
            const timeRegex = /^(0[0-9]|1\d|2[0-3]):([0-5]\d)$/;
            return timeRegex.test(time);
        }

        function toggleSeeDetails(shiftNumber) {
            const seeDetails = document.querySelector(`.see-details-${shiftNumber}`);
            seeDetails.classList.toggle("visible");
        }
        // Function untuk menambahkan event listeners pada "See Details" buttons
        function addSeeDetailsListeners() {
            const seeDetailsButtons = document.querySelectorAll(".see-details-button");
            seeDetailsButtons.forEach((button) => {
                const shiftNumber = button.dataset.shiftNumber;
                button.addEventListener("click", function() {
                    toggleSeeDetails(shiftNumber);
                });
            });
        }

        function showShiftNameForm() {
            const shiftForm = document.getElementById("shiftForm");
            const shiftNameForm = document.getElementById("shiftNameForm");
            shiftForm.style.display = "none";
            shiftNameForm.style.display = "block";
        }

        // Event listener for "Back" button on shiftNameForm
        document.querySelector("#shiftNameForm a").addEventListener("click", function() {
            // Redirect to jadwal_kerja.php
            window.location.href = "../jadwal_kerja.php";
        });
        // Event listener for "Next" button on shiftNameForm
        document.getElementById("btnSubmitShiftName").addEventListener("click", function() {
            const namaShiftInput = document.getElementById("namaShift");
            const namaShift = namaShiftInput.value.trim();

            if (namaShift === "") {
                alert("Nama shift tidak boleh kosong.");
                return;
            }

            // Store the shift name in the namaShiftInput field
            namaShiftInput.value = namaShift;
            showShiftForm();
        });


        // Function to navigate to the shiftForm
        function showShiftForm() {
            const shiftNameForm = document.getElementById("shiftNameForm");
            const shiftForm = document.getElementById("shiftForm");
            shiftForm.style.display = "block";
            shiftNameForm.style.display = "none";
        }

        // Event listener for "Back" button on shiftForm
        document.getElementById("btnBackToShiftNameForm").addEventListener("click", function() {
            showShiftNameForm();
        });
        // Function untuk menampilkan "See Details" section untuk setiap shift
        function displayKaryawanDetails() {
            const karyawanInputs = document.getElementById("karyawanInputs");
            karyawanInputs.innerHTML = "";

            for (let i = 1; i <= shiftCountInput.value; i++) {
                const shiftHourData = shiftHoursData[i - 1];
                const shiftHourText = shiftHourData ?
                    `${shiftHourData.start} - ${shiftHourData.end}` :
                    "Jam kerja belum diatur";

                const karyawanField = document.createElement("div");
                karyawanField.classList.add("form-field", "black-box");

                // Shift Header with "Tambah Karyawan" button
                const shiftHeader = document.createElement("div");
                shiftHeader.innerHTML = `
                    <p class="shift-title">Shift ${i}: ${shiftHourText}</p>
                    <button type="button"class="btn btn-primary btn-dark see-details-button" style="background-color:#FFF6E0;color:black" data-shift-number="${i}" onclick="toggleSeeDetails(${i})">
                        Tambah Karyawan
                    </button>
                `;

                // "See Details" section
                const seeDetails = document.createElement("div");
                seeDetails.classList.add("see-details",
                `see-details-${i}`); // Add a unique class for each shift's "See Details" section
                seeDetails.innerHTML = `
                    <label for="dropdownKaryawan${i}" style="color:black">Pilih Karyawan:</label>
                    <select id="dropdownKaryawan${i}" name="dropdownKaryawan${i}">
                        <option value="" disabled selected>Pilih Karyawan</option>
                        <?php
                        // Query untuk mengambil nama karyawan dari tabel daftar_karyawan
                        $sql = "SELECT nama FROM daftar_karyawan";
                        $result = $conn->query($sql);

                        // Memasukkan data nama karyawan ke dalam opsi dropdown
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['nama'] . '">'. $row['nama'] . '</option>';
                        }
                        ?>
                    </select>
                    <button type="button"class="btn btn-dark btn-sm" id="btnTambahKaryawan${i}" onclick="tambahKaryawan(${i})">Tambah</button>
                    <div id="namaKaryawanContainer${i}" style="color:black"></div>
                `;

                karyawanField.appendChild(shiftHeader);
                karyawanField.appendChild(seeDetails);
                karyawanInputs.appendChild(karyawanField);

                // Set selected karyawan (if any) in "See Details" section for the current shift
                const dropdown = document.getElementById(`dropdownKaryawan${i}`);
                const namaKaryawanContainer = document.getElementById(`namaKaryawanContainer${i}`);
                const selectedKaryawan = dropdown.value;

                if (selectedKaryawan !== "") {
                    const namaKaryawanElement = document.createElement("div");
                    namaKaryawanElement.textContent = selectedKaryawan;
                    namaKaryawanContainer.appendChild(namaKaryawanElement);

                    // Store the selected employee name in the karyawanYangHilang array
                    if (!karyawanYangHilang[i - 1]) {
                        karyawanYangHilang[i - 1] = [];
                    }
                    karyawanYangHilang[i - 1].push(selectedKaryawan);
                }
            }

            addSeeDetailsListeners(); // Add event listeners to the newly generated "See Details" buttons
        }


        // Event listener untuk tombol "Submit" pada shiftForm
        document.getElementById("btnSubmitShift").addEventListener("click", function() {
            const count = parseInt(shiftCountInput.value);
            if (!isNaN(count) && count >= 1 && count <= 10) {
                showShiftHoursForm(count);
            } else {
                alert("Jumlah shift harus berada dalam rentang 1-10.");
            }
        });

        // Event listener untuk tombol "Back" pada shiftHoursForm
        document.getElementById("btnBackToShiftForm").addEventListener("click", function() {
            shiftHoursForm.style.display = "none";
            shiftForm.style.display = "block";
        });

        // Event listener untuk tombol "Continue" pada shiftHoursForm
        document.getElementById("btnAddKaryawanForm").addEventListener("click", function() {
            const count = parseInt(shiftCountInput.value);
            let timeInputsValid = true;

            for (let i = 1; i <= count; i++) {
                const shiftStart = document.querySelector(`input[name="shift${i}_start"]`).value;
                const shiftEnd = document.querySelector(`input[name="shift${i}_end"]`).value;

                if (!isValidTimeFormat(shiftStart) || !isValidTimeFormat(shiftEnd)) {
                    timeInputsValid = false;
                    break;
                }
            }

            if (isNaN(count) || count < 1 || count > 10) {
                alert("Jumlah shift harus berada dalam rentang 1-10.");
            } else if (!timeInputsValid) {
                alert(
                    "Anda harus mengisi jam kerja untuk setiap shift dalam format JJ:MM (contoh: 16:00).");
            } else {
                // Simpan data jam kerja untuk setiap shift ke dalam array shiftHoursData
                shiftHoursData = [];
                for (let i = 1; i <= count; i++) {
                    const shiftStart = document.querySelector(`input[name="shift${i}_start"]`).value;
                    const shiftEnd = document.querySelector(`input[name="shift${i}_end"]`).value;
                    shiftHoursData.push({
                        start: shiftStart,
                        end: shiftEnd
                    });
                }
                showKaryawanForm();
                displayKaryawanDetails();
            }
        });

        // Event listener untuk tombol "Back" pada karyawanForm
        document.getElementById("btnBackToShiftHoursForm").addEventListener("click", function() {
            karyawanYangHilang = [];
            karyawanForm.style.display = "none";
            shiftHoursForm.style.display = "block";
        });
        document.getElementById("btnSubmitKaryawan").addEventListener("click", function() {
            if (isKaryawanContainerEmpty()) {
                alert("Masih Ada Shift yang Belum Terisi Karyawan");
                event.preventDefault(); // Prevent form submission
            }
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