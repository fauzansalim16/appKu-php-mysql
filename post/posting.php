<?php
require "../config/connection.php";

session_start();

if (!isset($_SESSION["nama"])) {
    header("Location: ../auth/login.php");
    exit;
}
function insertPost($conn, $judul, $konten, $gambar, $user_id) {
    $gambar_path = "upload/" . $gambar['name'];
    $gambar_path_move_file = "../upload/" . $gambar['name'];
    move_uploaded_file($gambar['tmp_name'], $gambar_path_move_file);

    $sql = "INSERT INTO post (judul, konten, gambar, tanggal_post, user_id) VALUES ('$judul', '$konten', '$gambar_path', CURRENT_TIMESTAMP, '$user_id')";

    return $conn->query($sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_post"])) {
        $judul = $_POST["judul"];
        $konten = $_POST["konten"];
        $gambar = $_FILES['gambar'];
        $user_id = $_SESSION["id"];

        if (insertPost($conn, $judul, $konten, $gambar, $user_id)) {
            header("Location: ../index.php");
        } else {
            echo "Error: Gagal menambahkan postingan.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Tambah Postingan</title>
    <link rel="icon" href="../image/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body id="body" style="background-color: aliceblue;">
    <nav id="navbar" class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <img src="../image/favicon.ico" alt="Logo" width="25" height="25" class="d-inline-block align-text-top">  AppKu
            </a>    
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="../index.php">Home</a>
                    <a class="nav-link" href="../user/users.php">Users</a>
                    <a class="nav-link active" href="#">Posting!</a>
                </div>
            </div>
            <form action="../auth/logout.php" method="post" class="logout-form">
                <p class="greeting">Howdy, <?php echo $_SESSION["nama"]; ?></p>
                <button type="submit" class="btn btn-primary" name="logout">Logout</button>
            </form>
        </div>
    </nav>
    
    <div class="insert-post">
        <h2>Tambah Postingan</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>
            <div class="form-group">
                <label for="konten">Konten</label>
                <textarea class="form-control" id="konten" name="konten" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="gambar">Gambar</label>
                <input type="file" class="form-control-file" id="gambar" name="gambar">
            </div>
            <button type="submit" name="add_post" class="btn btn-primary mt-10 submit-button">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
