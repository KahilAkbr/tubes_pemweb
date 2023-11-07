<?php
    include "../../db_conn.php";
    if (!isset($_SESSION["email"])) {
        header("Location: ../../index.php");
    }

    $query_total_karyawan = "SELECT COUNT(*) AS total_karyawan FROM daftar_karyawan";
    $result_total_karyawan = mysqli_query($conn, $query_total_karyawan);

    if ($result_total_karyawan) {
        $row_total_karyawan = mysqli_fetch_assoc($result_total_karyawan);
        $total_karyawan = $row_total_karyawan['total_karyawan'];
    } else {
        $total_karyawan = 0;
    }


    $query_total_jadwal = "SELECT COUNT(*) AS total_jadwal FROM jam_kerja";
    $result_total_jadwal = mysqli_query($conn, $query_total_jadwal);

    if ($result_total_jadwal) {
        $row_total_jadwal = mysqli_fetch_assoc($result_total_jadwal);
        $total_jadwal = $row_total_jadwal['total_jadwal'];
    } else {
        $total_jadwal = 0;
    }


    $query_insentif = "SELECT * FROM insentif_karyawan WHERE status_insentif = 'Ya'";
    $result_insentif = mysqli_query($conn, $query_insentif);
    if ($result_insentif){
        $count_insentif = mysqli_num_rows($result_insentif);
    }
    else{
        $count_insentif = 0;
    }
?>