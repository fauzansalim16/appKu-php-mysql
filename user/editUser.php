<?php
require "../config/connection.php";
session_start();

if (!isset($_SESSION["nama"])) {
    header("Location: auth/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];

    $sql_update = "UPDATE user SET nama='$nama', alamat='$alamat' WHERE id='$id'";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: ../index.php");
        exit;
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql_getSingleData = "SELECT * FROM user WHERE id = '$id'";
    $result = $conn->query($sql_getSingleData);

    if ($result->num_rows == 1) {
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Edit Data User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/edit_user.css">
</head>
<body id="body" style="background-color: aliceblue;">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</body>
</html>
