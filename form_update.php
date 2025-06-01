<?php
include 'database/conn.php';

// Ambil ID buku dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID tidak valid'); window.location.href='data_buku.php';</script>";
    exit();
}

$id_buku = (int) $_GET['id'];

// Ambil data buku berdasarkan ID
$query = "SELECT * FROM buku WHERE id_buku = $id_buku";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Proses update saat form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn = $_POST['isbn'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $jumlah = $_POST['jumlah'];

    // Default: pakai foto lama
    $foto = $data['foto'];

    // Jika ada upload file baru
    if ($_FILES['foto']['name']) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            $foto = $_FILES["foto"]["name"];
        }
    }

    $updateQuery = "UPDATE buku SET 
                      isbn = '$isbn',
                      judul = '$judul',
                      pengarang = '$pengarang',
                      penerbit = '$penerbit',
                      tahun_terbit = '$tahun_terbit',
                      jumlah = '$jumlah',
                      foto = '$foto'
                    WHERE id_buku = $id_buku";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Data berhasil diperbarui'); window.location.href='index.php';</script>";
        exit();
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($conn);
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Data Buku</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Page body -->
    <div class="page-body p-4">
        <div class="container-xl">
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $id_buku) ?>" method="POST"
                enctype="multipart/form-data">
                <div class="pb-3">
                    <h3>Update Data Buku</h3>
                </div>
                <div class="card">
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">No. ISBN</label>
                                <input type="text" name="isbn" class="form-control" value="<?= $data['isbn'] ?>"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" name="judul" class="form-control" value="<?= $data['judul'] ?>"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pengarang</label>
                                <input type="text" name="pengarang" class="form-control"
                                    value="<?= $data['pengarang'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Penerbit</label>
                                <input type="text" name="penerbit" class="form-control" value="<?= $data['penerbit'] ?>"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" class="form-control"
                                    value="<?= $data['tahun_terbit'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" class="form-control" value="<?= $data['jumlah'] ?>"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ganti Foto (Opsional)</label>
                                <input type="file" name="foto" class="form-control">
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYQ4a2WxGv9C49Ck0p3ylbFZlZHpZIGbFQZ9CkEeoUZYB7q0J5WI2kFs6" crossorigin="anonymous">
    </script>
</body>

</html>