<?php
require "config/connection.php";

session_start();

if (!isset($_SESSION["nama"])) {
    header("Location: auth/login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_post"])) {
        $judul = $_POST["judul"];
        $konten = $_POST["konten"];
        $gambar = $_POST["gambar"];
        $user_id = $_SESSION["id"];

        $gambar = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $gambar_path = "upload/" . $gambar;

        move_uploaded_file($gambar_tmp, $gambar_path);

        $sql_insert = "INSERT INTO post (judul, konten, gambar, tanggal_post, user_id) VALUES ('$judul', '$konten', '$gambar_path',CURRENT_TIMESTAMP, '$user_id')";

        if ($conn->query($sql_insert) === TRUE) {
            header("Location: index.php");
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    }
}

if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $sql_getSingleData = "DELETE FROM user WHERE id = '$id'";

    if ($conn->query($sql_getSingleData) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql_getSingleData . "<br>" . $conn->error;
    }
}

$sql_getAllData = "SELECT * FROM user";
$result = $conn->query($sql_getAllData);

$sql_getAllPostData = "SELECT * FROM post";
$postResult = $conn->query($sql_getAllPostData);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Applikasi Ku</title>
    <link rel="icon" href="image/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <nav id="navbar" class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
            <img src="image/logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">AppKu
            </a>
            <form action="auth/logout.php" method="post" class="logout-form">
                <p class="greeting">Howdy, <?php echo $_SESSION["nama"]; ?></p>
                <button type="submit" class="btn btn-primary" name="logout">Logout</button>
            </form>
        </div>
        
    </nav>
     <!-- Form unutk Get seluruh data Data -->
    <h2 id="h2-data-user" class="text-center">User</h2>
    <div class="card-container">
        <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card' style='width: 18rem;'>";
                    // echo "<img src='...' class='card-img-top' alt='...'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . $row["nama"] . "</h5>";
                    echo "<p class='card-text'>" . $row["alamat"] . "</p>";
                    if ($_SESSION["level"] == 1) {
                        echo "<a href='edit.php?id=" . $row["id"] . "' class='btn btn-primary mx-2'>Edit</a>";
                        echo "<a href='?delete=" . $row["id"] . "' class='btn btn-danger'>Delete</a>";
                    }
                    echo "</div>";
                    echo "</div>";
                }
            }
        ?>
    </div>
    <h2 class="text-center">Postingan</h2>
<div class="card-container">
    <?php
    if ($postResult->num_rows > 0) {
        while ($postRow = $postResult->fetch_assoc()) {
            echo "<div class='card' style='width: 18rem;'>";
            echo "<img src='" . $postRow["gambar"] . "' class='card-img-top' alt='Gambar'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'><a href='post/detailPost.php?id=" . $postRow["id"] . "' class='custom-link'>" . $postRow["judul"] . "</a></h5>";
            echo "<p class='card-text'>" . $postRow["konten"] . "</p>";
            echo "<p class='card-text'>At: " . $postRow["tanggal_post"] . "</p>";
            $user_id = $postRow["user_id"];
            $sql_getUser = "SELECT nama FROM user WHERE id = '$user_id'";
            $userResult = $conn->query($sql_getUser);
            if ($userResult->num_rows > 0) {
                $userRow = $userResult->fetch_assoc();
                echo "<p class='card-text'>By: " . $userRow["nama"] . "</p>";
            }
            echo "</div>";
            echo "</div>";
        }
    }
    ?>
</div>
<div class="insert-post">
    <h2>Tambah postingan</h2>
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
        <button type="submit" name="add_post" class="btn btn-primary mt-10">Submit</button>
    </form>
</div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
