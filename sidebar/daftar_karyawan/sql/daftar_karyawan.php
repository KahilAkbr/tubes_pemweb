<?php
if (isset($_POST["submit"])) {
    $no_ktp = $_POST["no_ktp"];
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $telp = $_POST["telp"];
    $email = $_POST["email"];
    $jenis_kelamin = $_POST["jenis_kelamin"];

    // Check if the no_ktp already exists in the database
    $randomPart1 = generateRandomString(4);
    $randomPart2 = generateRandomString(4);
    $randomPart3 = generateRandomString(4);
    $randomPart4 = generateRandomString(4);

    $check_query = "SELECT * FROM `daftar_karyawan` WHERE nama = '$nama'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Nama Sudah Ada Dalam Daftar')</script>";
    }else{
        $id_karyawan = $randomPart1 . "-" . $randomPart2 . "-" . $randomPart3 . "-" . $randomPart4;
        $query = "INSERT INTO daftar_karyawan (id_karyawan, no_ktp, nama, alamat, telp, email, jenis_kelamin) VALUES ('$id_karyawan', '$no_ktp', '$nama', '$alamat', '$telp', '$email', '$jenis_kelamin')";
        mysqli_query($conn, $query);
        $queryAbsensi = "INSERT INTO absensi_karyawan (id_karyawan, hadir, izin, sakit, cuti, tanpa_keterangan) VALUES ('$id_karyawan', '0', '0', '0', '0', '0')";
        mysqli_query($conn, $queryAbsensi);
        $queryInsentif = "INSERT INTO insentif_karyawan (id_karyawan, status_insentif) VALUES ('$id_karyawan', 'TIDAK')";
        mysqli_query($conn, $queryInsentif);
        $_SESSION["tambah_success"] = true;
        header("Location: daftar_karyawan.php");
        exit();
    }
}
?>