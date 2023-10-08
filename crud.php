<?php
include("db/koneksi.php");

function edit($id, $nim, $nama, $jenis_kelamin, $jurusan)
{
    global $koneksi;

    $query = "UPDATE mahasiswa SET nim='$nim', nama='$nama', jenis_kelamin='$jenis_kelamin', jurusan='$jurusan' WHERE id_mhs='$id'";

    if (mysqli_query($koneksi, $query)) {
        return true;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
        return false;
    }
}

function hapus($id)
{
    global $koneksi;

    $query = "DELETE FROM mahasiswa WHERE id_mhs='$id'";

    if (mysqli_query($koneksi, $query)) {
        return true;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
        return false;
    }
}

function tambah($nim, $nama, $jenis_kelamin, $jurusan)
{
    global $koneksi;

    $query_check = "SELECT COUNT(*) FROM mahasiswa WHERE nim='$nim'";
    $result = mysqli_query($koneksi, $query_check);
    $row = mysqli_fetch_array($result);
    $count = $row[0];

    if ($count > 0) {
        echo "Error: Data dengan NIM tersebut sudah ada dalam database.";
        return false;
    }

    $query = "INSERT INTO mahasiswa (nim, nama, jurusan, jenis_kelamin) VALUES ('$nim', '$nama', '$jurusan', '$jenis_kelamin')";

    if (mysqli_query($koneksi, $query)) {
        return true;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
        return false;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nim']) && isset($_POST['nama']) && isset($_POST['jurusan']) && isset($_POST['jenis_kelamin'])) {
        $nim = $_POST['nim'];
        $nama = $_POST['nama'];
        $jurusan = $_POST['jurusan'];
        $jenis_kelamin = $_POST['jenis_kelamin'];

        if ($_GET['action'] === 'tambah') { 
            if (tambah($nim, $nama, $jenis_kelamin, $jurusan)) {
                header("Location: index.php");
                exit;
            }
        } elseif ($_GET['action'] === 'edit') { 
            $id = $_POST['id_mhs'];
            if (edit($id, $nim, $nama, $jenis_kelamin, $jurusan)) {
                header("Location: index.php");
                exit;
            }
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'hapus' && isset($_GET['id'])) {
    $id_mhs = $_GET['id'];

    if (hapus($id_mhs)) {
        header("Location: index.php");
        exit;
    }
}
?>
