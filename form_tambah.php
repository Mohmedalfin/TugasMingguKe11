<?php
// koneksi ke database
include 'database/conn.php';

// Ambil ISBN terakhir
$query = "SELECT isbn FROM buku ORDER BY id_buku DESC LIMIT 1";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($data) {
    $last_isbn = $data['isbn'];
    $parts = explode('-', $last_isbn);
    $prefix = $parts[0];
    $number = (int) $parts[1];

    $next_number = str_pad($number + 1, 2, '0', STR_PAD_LEFT);
    $next_isbn = $prefix . '-' . $next_number;
} else {
    $next_isbn = 'BK-01';
}

// cek jika tombol submit ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn = $_POST['isbn'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $jumlah = $_POST['jumlah'];

    $foto_name = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];

    // Buat nama file unik
    $foto_new_name = uniqid('buku_') . '_' . basename($foto_name);
    
    $target_dir = "uploads/";
    $target_path = $target_dir . $foto_new_name;

    if (move_uploaded_file($foto_tmp, $target_path)) {
        $query = "INSERT INTO buku (isbn, judul, pengarang, penerbit, tahun_terbit, jumlah, foto)
              VALUES ('$isbn', '$judul', '$pengarang', '$penerbit', '$tahun_terbit', '$jumlah', '$foto_new_name')";

        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>alert('Data berhasil disimpan'); window.location.href='index.php';</script>";
        } else {
            echo "Gagal menyimpan data: " . mysqli_error($conn);
        }
    } else {
        echo "Upload foto gagal!";
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
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST"
                enctype="multipart/form-data">
                <div class="pb-3">
                    <h3>Tambahkan Buku</h3>
                </div>
                <div class="card">
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">No. ISBN</label>
                                <input type="text" name="isbn" class="form-control" value="<?= $next_isbn ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" name="judul" class="form-control" placeholder="Masukkan Judul Buku"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pengarang</label>
                                <input type="text" name="pengarang" class="form-control"
                                    placeholder="Masukkan Nama Pengarang" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Penerbit</label>
                                <input type="text" name="penerbit" class="form-control"
                                    placeholder="Masukkan Nama Penerbit" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" class="form-control"
                                    placeholder="Masukkan Tahun Terbit" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" class="form-control"
                                    placeholder="Masukkan Jumlah Buku" required>
                            </div>
                            <div class="md-3">
                                <label for="" class="form-label">Foto</label>
                                <input type="file" class="form-control" name="foto" id="foto"
                                    placeholder="Masukkan foto" required>
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