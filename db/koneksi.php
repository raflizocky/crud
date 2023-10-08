<?php
$koneksi = mysqli_connect(
    'localhost',    // server location/ip/host
    'root',         // user
    '',             // password
    'db_mhs'        // nama db
);

// cek koneksi
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

return $koneksi;
?>
