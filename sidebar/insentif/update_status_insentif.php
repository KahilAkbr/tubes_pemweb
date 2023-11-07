<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input values from the form
    $hadir = $_POST["hadir_input"];
    $izin = $_POST["izin_input"];
    $sakit = $_POST["sakit_input"];
    $cuti = $_POST["cuti_input"];
    $tanpa_keterangan = $_POST["tanpa_keterangan_input"];

    // Perform the update query
    $updateSQL = "UPDATE kriteria_insentif 
                  SET hadir = '$hadir', izin = '$izin', sakit = '$sakit', cuti = '$cuti', tanpa_keterangan = '$tanpa_keterangan'";

    if (mysqli_query($conn, $updateSQL)) {
        // Select query to get counts from the rekap_absensi table
        $sql = "SELECT dk.nama, dk.no_ktp,
                       COALESCE(SUM(ra.statuss = 'hadir'), 0) AS hadir,
                       COALESCE(SUM(ra.statuss = 'izin'), 0) AS izin,
                       COALESCE(SUM(ra.statuss = 'sakit'), 0) AS sakit,
                       COALESCE(SUM(ra.statuss = 'cuti'), 0) AS cuti,
                       COALESCE(SUM(ra.statuss = 'tanpa_keterangan'), 0) AS tanpa_keterangan
                FROM daftar_karyawan dk
                LEFT JOIN rekap_absensi ra ON dk.nama = ra.nama_karyawan
                GROUP BY dk.nama, dk.no_ktp
                ORDER BY dk.nama ASC";

        $result = mysqli_query($conn, $sql);

        // Loop through the result set and update the status_insentif in insentif_karyawan table
        while ($row = mysqli_fetch_assoc($result)) {
            $nama = $row['nama'];
            $hadirCount = $row['hadir'];
            $izinCount = $row['izin'];
            $sakitCount = $row['sakit'];
            $cutiCount = $row['cuti'];
            $tanpa_keteranganCount = $row['tanpa_keterangan'];

            $updateStatusSQL = "UPDATE insentif_karyawan 
                                SET status_insentif = 
                                CASE 
                                    WHEN $hadirCount >= $hadir
                                         AND $izinCount <= $izin
                                         AND $sakitCount <= $sakit
                                         AND $cutiCount <= $cuti
                                         AND $tanpa_keteranganCount <= $tanpa_keterangan
                                    THEN 'YA'
                                    ELSE 'TIDAK'
                                END
                                WHERE id_karyawan IN (
                                    SELECT id_karyawan FROM daftar_karyawan WHERE nama = '$nama'
                                )";

            if (!mysqli_query($conn, $updateStatusSQL)) {
                echo "Error updating status_insentif for $nama: " . mysqli_error($conn);
            }
        }

        // Free the result set
        mysqli_free_result($result);
    } else {
        echo "Error updating data: " . mysqli_error($conn);
    }
}

?>