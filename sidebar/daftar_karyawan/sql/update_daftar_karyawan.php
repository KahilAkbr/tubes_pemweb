<?php
if (isset($_POST["submit"])) {
    $id_karyawan = $_POST["id_karyawan"];
    $no_ktp = $_POST["no_ktp"];
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $telp = $_POST["telp"];
    $email = $_POST["email"];
    $jenis_kelamin = $_POST["jenis_kelamin"];

    $query = "UPDATE daftar_karyawan SET no_ktp='$no_ktp', nama='$nama', alamat='$alamat', telp='$telp', email='$email', jenis_kelamin='$jenis_kelamin' WHERE id_karyawan='$id_karyawan'";
    if (mysqli_query($conn, $query)) {
        // Update successful, redirect to daftar_karyawan.php
        $_SESSION["update_success"] = true;
        header("Location: daftar_karyawan.php");
        exit();
    }
}
?>