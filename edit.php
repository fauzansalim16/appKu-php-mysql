<?php
require "config/connection.php";
session_start();

if (!isset($_SESSION["nama"])) {
    // Pengguna belum login, mengarahkan kembali ke halaman login.php
    header("Location: auth/login.php");
    exit;
}

// Memeriksa apakah form telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];

    // Mengupdate data berdasarkan ID
    $sql_update = "UPDATE user SET nama='$nama', alamat='$alamat' WHERE id='$id'";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
}

// Memeriksa apakah parameter ID telah diberikan
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Mendapatkan data berdasarkan ID
    $sql_getSingleData = "SELECT * FROM user WHERE id = '$id'";
    $result = $conn->query($sql_getSingleData);

    if ($result->num_rows == 1) {
        // Menampilkan formulir dengan data yang telah ada
        $row = $result->fetch_assoc();
        $nama = $row["nama"];
        $alamat = $row["alamat"];
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Data User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/edit.css">
</head>
<body>
    <form class="edit-form" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <h2 class="text-center">Edit Data</h2>
        <div class="mb-3">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="nama" class="form-label">Nama</label>
            <input type="nama" class="form-control" name="nama" value="<?php echo $nama; ?>" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="alamat" class="form-control" name="alamat" value="<?php echo $alamat; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Edit</button>
        <p><a href='index.php'>Batalkan</a></p>
    </form>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</body>
</html>
