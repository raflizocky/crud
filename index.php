<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Talent</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="frameworks/bootstrap-5.3.0-dist/css/bootstrap.min.css">
</head>
<body>
    <header></header>

    <main>
        <div class="container">
            <h2 class="mt-3">List Mahasiswa</h2>
            <div class="text-end mb-2">
                <button type="button" title="Tambah Data" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal"><i class="fa-solid fa-plus"></i>  Tambah Data</button>
            </div>
            <table class="table table-bordered border-primary">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NIM</th>
                        <th>NAMA</th>
                        <th>GENDER</th>
                        <th>JURUSAN</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    include("db/koneksi.php");
                    $mahasiswa = mysqli_query($koneksi, "SELECT * FROM mahasiswa");
                    $no = 1;
                    foreach ($mahasiswa as $row) :
                        $jenis_kelamin = $row['jenis_kelamin'] == 'P' ? 'Perempuan' : 'Laki-laki';
                    ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= $row['nim']; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $jenis_kelamin; ?></td>
                        <td><?= $row['jurusan']; ?></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" title="Edit Data" data-bs-target="#editModal-<?= $row['id_mhs']; ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button type="button" class="btn btn-danger" title="Hapus Data" onclick="confirmDelete(<?= $row['id_mhs']; ?>)"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php
                        $no++;
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Data Mahasiswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="crud.php?action=tambah" method="post">
                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="nim" name="nim" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_laki" value="L" required>
                                <label class="form-check-label" for="jk_laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_perempuan" value="P" required>
                                <label class="form-check-label" for="jk_perempuan">Perempuan</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <select class="form-select" id="jurusan" name="jurusan" required>
                                <option value="TEKNIK INFORMATIKA">TEKNIK INFORMATIKA</option>
                                <option value="TEKNIK ELEKTRO">TEKNIK ELEKTRO</option>
                                <option value="REKAMEDIS">REKAMEDIS</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php foreach ($mahasiswa as $row) : ?>
                <!-- Modal Edit -->
                <div class="modal fade" id="editModal-<?= $row['id_mhs']; ?>" tabindex="-1" aria-labelledby="editModalLabel-<?= $row['id_mhs']; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data Mahasiswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="crud.php?action=edit" method="post">
                            <input type="hidden" name="id_mhs" value="<?= $row['id_mhs']; ?>">
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" required id="nim" name="nim" value="<?= $row['nim']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" required id="nama" name="nama" value="<?= $row['nama']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <div class="form-check">
                                    <input class="form-check-input" required type="radio" name="jenis_kelamin" id="jk_laki" value="L" <?= $row['jenis_kelamin'] == 'L' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="jk_laki">Laki-laki</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_perempuan" value="P" <?= $row['jenis_kelamin'] == 'P' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="jk_perempuan">Perempuan</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="jurusan" class="form-label">Jurusan</label>
                                <select class="form-select" required id="jurusan" name="jurusan">
                                    <option value="TEKNIK INFORMATIKA" <?= $row['jurusan'] == 'TEKNIK INFORMATIKA' ? 'selected' : ''; ?>>TEKNIK INFORMATIKA</option>
                                    <option value="TEKNIK ELEKTRO" <?= $row['jurusan'] == 'TEKNIK ELEKTRO' ? 'selected' : ''; ?>>TEKNIK ELEKTRO</option>
                                    <option value="REKAMEDIS" <?= $row['jurusan'] == 'REKAMEDIS' ? 'selected' : ''; ?>>REKAMEDIS</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://kit.fontawesome.com/96d7bcabcb.js" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <script src="frameworks/bootstrap-5.3.0-dist/js/bootstrap.min.js"></script>
</body>
</html>