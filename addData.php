<?php
include "db_conn.php";

if(isset($_POST["submit"])){
  $id_karyawan = $_POST["id_karyawan"];
  $no_ktp = $_POST["no_ktp"];
  $nama = $_POST["nama"];
  $alamat = $_POST["alamat"];
  $telp = $_POST["telp"];
  $email = $_POST["email"];
  $jenis_kelamin = $_POST["jenis_kelamin"];

    $query = "INSERT INTO daftar_karyawan (id_karyawan, no_ktp, nama, alamat, telp, email, jenis_kelamin) VALUES ('$id_karyawan', '$no_ktp', '$nama', '$alamat', '$telp', '$email', '$jenis_kelamin')";
    mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Manajemen Karyawan</title>
    <style>
    .alert-top {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
    }
    </style>
</head>



<body>
    <nav class="navbar navbar-light justify-content-center fs-3 mb-5"
        style="background-color: black; color: whitesmoke;">
        DATA KARYAWAN
    </nav>

    <div class="container">
        <div class="text-center mb-4">
            <h3>Tambah Data</h3>
            <p class="text-muted">Tambahkan Data Karyawan</p>
        </div>

        <div class="container d-flex justify-content-center">
            <form action="" method="post" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
                <div class="mb-3">
                    <label class="form-label">id_karyawan:</label>
                    <input type="text" class="form-control" name="id_karyawan" placeholder="Id Karyawan">
                </div>
                <div class="mb-3">
                    <label class="form-label">no_ktp:</label>
                    <input type="text" class="form-control" name="no_ktp" placeholder="NO KTP">
                </div>
                <div class="mb-3">
                    <label class="form-label">nama:</label>
                    <input type="text" class="form-control" name="nama" placeholder="Nama">
                </div>
                <div class="mb-3">
                    <label class="form-label">alamat:</label>
                    <input type="text" class="form-control" name="alamat" placeholder="alamat">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor Telefon:</label>
                    <input type="text" class="form-control" name="telp" placeholder="+62">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="text" class="form-control" name="email" placeholder="email">
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin:</label>
                    <select class="form-control" name="jenis_kelamin" required>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div>
                    <br>
                    <button type="submit" class="btn btn-dark btn-success" name="submit">Save</button>
                    <a href="index.php" class="btn btn-dark btn-danger">Cancel</a>
                    <br><br>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>