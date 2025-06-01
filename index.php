<?php
include 'database/conn.php';
$query = "SELECT id_buku, isbn, judul, pengarang, penerbit, tahun_terbit, jumlah FROM buku";
$result = mysqli_query($conn, $query);
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
    <div class="page-body py-4">
        <div class="container-xl">
            <!-- Tombol Tambah Data -->
            <a href="form_tambah.php" class="btn btn-primary">
                <span class="text"><i class="fa-solid fa-folder-plus me-1"></i>Tambah Data</span>
            </a>

            <!-- Table -->
            <table class="table table-bordered mt-3">
                <thead class="text-center table-light">
                    <tr>
                        <th>No.</th>
                        <th>No. ISBN</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Tahun Terbit</th>
                        <th>Jumlah</th>
                        <th>CRUD</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    if (mysqli_num_rows($result) > 0):
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)):
                            ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['isbn']) ?></td>
                        <td><?= htmlspecialchars($row['judul']) ?></td>
                        <td><?= htmlspecialchars($row['pengarang']) ?></td>
                        <td><?= htmlspecialchars($row['penerbit']) ?></td>
                        <td><?= $row['tahun_terbit'] ?></td>
                        <td><?= $row['jumlah'] ?></td>
                        <td>
                            <a href="form_detail.php?id=<?= $row['id_buku'] ?>" 1
                                class="badge bg-primary btn px-2 py-1">Details</a>
                            <a href="form_update.php?id=<?= $row['id_buku'] ?>"
                                class="badge bg-warning text-white btn px-2 py-1">Edit</a>
                            <a href="form_hapus.php?id=<?= $row['id_buku'] ?>"
                                class="badge bg-danger btn px-2 py-1">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr>
                        <td colspan="7">Data kosong, silakan tambahkan data baru.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYQ4a2WxGv9C49Ck0p3ylbFZlZHpZIGbFQZ9CkEeoUZYB7q0J5WI2kFs6" crossorigin="anonymous">
    </script>
</body>

</html>